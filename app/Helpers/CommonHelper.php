<?php

use App\Models\Invoice;
use App\Models\InvoiceHistory;
use App\Models\Pajak;
use App\Models\PajakHistory;
use App\Models\RefLiburNasional;
use App\Models\SysRoleMenuAction;
use App\Models\DelegasiPlh;
use App\Models\Saldo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function checkAccess($act)
{
    $role_id = auth()->user()->role_id;
    $page    = request()->path();
    $action  =  strtolower($act);
    $data = SysRoleMenuAction::select('sys_role_menu_actions.menu_action_id')
            ->leftJoin('sys_menu_actions as sma','sma.id','sys_role_menu_actions.menu_action_id')
            ->leftJoin('sys_menus as sm','sm.id','sma.menu_id')
            ->leftJoin('sys_actions as sa','sa.id','sma.action_id')
            ->where('sys_role_menu_actions.role_id',$role_id)
            ->where('sm.page',$page)
            ->where('sa.action_function',$action)
            ->first();

    if(!empty($data)){
        $return = 'true';
    }else{
        $return = 'false';
    }

    return $return;
}

function checkAccessMenu($url="")
{
    $role_id = auth()->user()->role_id;
    $page    = $url!=""?$url:request()->path();
    $data = SysRoleMenuAction::select(DB::raw('GROUP_CONCAT(sa.action_function SEPARATOR ",") as action_function'))
            ->leftJoin('sys_menu_actions as sma','sma.id','sys_role_menu_actions.menu_action_id')
            ->leftJoin('sys_menus as sm','sm.id','sma.menu_id')
            ->leftJoin('sys_actions as sa','sa.id','sma.action_id')
            ->where('sys_role_menu_actions.role_id',$role_id)
            ->where('sm.page',$page)
            ->first();

    if(!empty($data)){
        $return = $data;
    }else{
        $return = array();
    }

    return $return;
}

function getSaldoPerBank($bank_id){
    $in = Saldo::select('nominal')->where('tipe','in')->where('bank_id',$bank_id)->where('status_code','active')->sum('nominal');
    $out = Saldo::select('nominal')->where('tipe','out')->where('bank_id',$bank_id)->where('status_code','active')->sum('nominal');

    $saldo = $in-$out;
    $return = array(
        'in'            =>$in,
        'out'           =>$out,
        'saldo'         =>$saldo
    );
    return $return;
}

function getSaldoPerCurrency($CurrencyID){
    $in = Saldo::select('nominal')->where('tipe','in')->where('currency_id',$CurrencyID)->where('status_code','active')->sum('nominal');
    $out = Saldo::select('nominal')->where('tipe','out')->where('currency_id',$CurrencyID)->where('status_code','active')->sum('nominal');

    $saldo = $in-$out;
    $return = array(
        'in'            =>$in,
        'out'           =>$out,
        'saldo'         =>$saldo
    );
    return $return;
}

function affilite(){
    $date=date('Y-m-d');
    $user_id = session('user_id');
    $user = DelegasiPlh::with(['user' => function($query){
        $query->with('role');
    }])
    ->where('user_id_plh',$user_id)
    ->where('start_date','<=',$date)
    ->where('end_date','>=',$date)
    ->get();


    $user = $user->map(function ($item){
        return collect([
            'user_id' => $item->user_id,
            'name' => $item->user->name,
            'role' => $item->user->role->role,
            'start_date' =>$item->start_date,
            'end_date' =>$item->end_date
        ]);
    });

    return $user;
}

function findDaysSLA($invoiceID)
{
    $invoice = Invoice::find($invoiceID, ['id', 'created_at', 'tahapan_id']);
    $HistoryDate = InvoiceHistory::where('invoice_id', $invoiceID)->max(DB::raw('date(created_at)'));
    

    $dateInvoice = ($invoice['tahapan_id'] > '12') ? $HistoryDate : Carbon::now();
    $dateFrom   = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($invoice['created_at'])));
    $dateTo     = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($dateInvoice)));
    
    $total_days = ($dateFrom->diffInDays($dateTo)+1);
    $weekDays   = countWeekends($dateFrom, $dateTo);
    $NatDays    = findNationalDays($dateFrom,$dateTo);
    $pendingInv = slaPendingInvoice($invoiceID);
    $daysLeft   =  $total_days - $weekDays - $NatDays-$pendingInv['sisa'];

    $result = array(
        'total_days'       => $total_days,
        'national_days'    => $NatDays, 
        'weekdays'         => $weekDays,
        'pending'          => $pendingInv['sisa'],
        'daysleft'         => $daysLeft,
        'sla'              => $daysLeft." Hari",
        'start_date'       => date('Y-m-d', strtotime($invoice['created_at'])),
        'end_date'         => date('Y-m-d', strtotime($dateInvoice)),
        'date'             => date('d M Y', strtotime($invoice['created_at']))." s/d ".date('d M Y', strtotime($dateInvoice))
    );

    return $result;
}

function slaPendingInvoice($invoiceID){
    $history = InvoiceHistory::select(DB::raw('date(created_at) AS start_date, IF(created_at=updated_at, date(now()), date(updated_at)) AS end_date '))->where('is_verifikasi','0')->where('invoice_id',$invoiceID)->get();
    $total_days=0;
    $total_weekend =0;
    $total_libur =0;
    foreach ($history as $key => $val) {
        $start_date   = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($val->start_date)));
        $end_date     = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($val->end_date)));
    
        //$total = ($start_date->diffInDays($end_date)+1);
        $total = ($start_date->diffInDays($end_date));
        $total_days = $total_days+$total;

        $weekDays   = countWeekends($start_date, $end_date);
        $NatDays    = findNationalDays($start_date,$end_date);
        $total_weekend = $total_weekend+$weekDays;
        $total_libur = $total_libur+$NatDays;
    }
    $result = array(
        'total'     => $total_days,
        'weekend'   => $total_weekend,
        'libur'     => $total_libur,
        'sisa'      => $total_days-$total_weekend-$total_libur
    );
    return $result;
}

function findDaysSLAPajak($PajakID)
{
    $invoice = Pajak::find($PajakID, ['id', 'created_at', 'tahapan_id']);
    $HistoryDate = PajakHistory::where('pajak_id', $PajakID)->max(DB::raw('date(created_at)'));

    $dateInvoice = ($invoice['tahapan_id'] > '5') ? $HistoryDate : Carbon::now();
    $dateFrom   = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($invoice['created_at'])));
    $dateTo     = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($dateInvoice)));
    
    $total_days = ($dateFrom->diffInDays($dateTo)+1);
    $weekDays   = countWeekends($dateFrom, $dateTo);
    $NatDays    = findNationalDays($dateFrom,$dateTo);
    $pendingPjk = slaPendingPajak($PajakID);
    $daysLeft   =  $total_days - $weekDays - $NatDays-$pendingPjk['sisa'];

    $result = array(
        'total_days'       => $total_days,
        'national_days'    => $NatDays, 
        'weekdays'         => $weekDays,
        'pending'          => $pendingPjk['sisa'],
        'daysleft'         => $daysLeft,
        'sla'              => $daysLeft." Hari",
        'start_date'       => date('Y-m-d', strtotime($invoice['created_at'])),
        'end_date'         => date('Y-m-d', strtotime($dateInvoice)),
        'date'             => date('d M Y', strtotime($invoice['created_at']))." s/d ".date('d M Y', strtotime($dateInvoice))
    );

    return $result;
}

function slaPendingPajak($PajakID){
    $history = PajakHistory::select(DB::raw('date(created_at) AS start_date, IF(created_at=updated_at, date(now()), date(updated_at)) AS end_date '))->where('is_verifikasi','0')->where('pajak_id',$PajakID)->get();
    $total_days=0;
    $total_weekend =0;
    $total_libur =0;
    foreach ($history as $key => $val) {
        $start_date   = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($val->start_date)));
        $end_date     = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($val->end_date)));
    
        //$total = ($start_date->diffInDays($end_date)+1);
        $total = ($start_date->diffInDays($end_date));
        $total_days = $total_days+$total;

        $weekDays   = countWeekends($start_date, $end_date);
        $NatDays    = findNationalDays($start_date,$end_date);
        $total_weekend = $total_weekend+$weekDays;
        $total_libur = $total_libur+$NatDays;
    }
    $result = array(
        'total'     => $total_days,
        'weekend'   => $total_weekend,
        'libur'     => $total_libur,
        'sisa'      => $total_days-$total_weekend-$total_libur
    );
    return $result;
}

function countWeekends($dateFrom, $dateTo)
{
    $resultDays = [
        'Monday'    => 0,
        'Tuesday'   => 0,
        'Wednesday' => 0,
        'Thursday'  => 0,
        'Friday'    => 0,
        'Saturday'  => 0,
        'Sunday'    => 0
    ];
    
    // INPUT START AND END DATE
	// CHANGE STRING TO DATE TIME OBJECT
	$startDate  = new DateTime($dateFrom);
	$endDate    = new DateTime($dateTo);

	// ITERATE OVER START TO END DATE
	while($startDate <= $endDate ){
		$timestamp  = strtotime($startDate->format('Y-m-d')); // FIND THE TIMESTAMP VALUE OF START DATE
		// FIND OUT THE DAY FOR TIMESTAMP AND INCREASE PARTICULAR DAY
		$weekDay    = date('l', $timestamp);
		$resultDays[$weekDay] = $resultDays[$weekDay] + 1;
		$startDate->modify('+1 day'); // INCREASE STARTDATE BY 1
	}

    return $resultDays['Saturday'] + $resultDays['Sunday'];
}

function findNationalDays($date,$endDate) 
{   
   
    $nationalDays       = RefLiburNasional::select('tanggal', 'status_code')->where(function($query) use($date, $endDate){
        $query->where('status_code', 'active');
        $query->whereBetween('tanggal', [$date, $endDate]);
    })->orderBy('tanggal', 'desc')->get();

    $arrWeekDays = [];
    foreach($nationalDays as $key => $day){
        $specificDate = date('l', strtotime($day->tanggal));
        if($specificDate == 'Saturday' || $specificDate == 'Sunday'){continue;}
        $arrWeekDays[$key] = $day;
    }
    
    return count($arrWeekDays);
}

function generateNoVendor(){
    $last = DB::table('sys_vendor')->max('id');
    $next = $last+1;
    $no_vendor =sprintf("%04d", $next);
    return $no_vendor;
}