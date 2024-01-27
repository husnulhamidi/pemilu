<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoiceHistory;
use App\Models\Saldo;
use App\Models\SysRoleTahapan;
use App\Models\Pajak;
use App\Models\PajakHistory;
use App\Models\SysRoleTahapanPajak;
use App\Models\SysRole;
use App\Models\SysMenu;
use App\Models\SysMenuAction;
use App\Models\SysRoleMenuAction;
use App\Models\DelegasiPlh;
use DateTime;
class PagesController extends Controller
{
    public function index()
    {
        $now = date('Y-m-d');
        // $d1 = new DateTime("2022-01-20");
        // $d2 = new DateTime($now);
        // $interval = $d1->diff($d2);
        // echo $lastup = $interval->d;die;
        
        $page_title = 'Dashboard';
        $page_description = '';
        $voting = $this->dashboard();
        $kategori = $voting['category'];
        $total_suara = $voting['suara'];
        $accessMenu = $this->accessMenu();
        //return view('pages.dashboard.dashboard', compact('page_title','accessMenu', 'page_description','invoice','pajak','saldo','saldo_jpy','saldo_usd','grafik_inv','grafik_pjk'));
        return view('pages.dashboard.dashboard', compact('page_title','accessMenu', 'page_description','kategori','total_suara'));
    }

    private function dashboard(){
        $sql="SELECT
                c.nama,
                SUM(hp.suara) AS total_suara 
            FROM
                hasil_pemilus AS hp
                LEFT JOIN calegs AS c ON c.id = hp.caleg_id 
            WHERE
                hp.deleted_at IS NULL 
                AND c.deleted_at IS NULL 
            GROUP BY
                hp.caleg_id";
        $data = DB::select($sql);
        $category = array();
        $suara = array();
        foreach ($data as $key => $val) {
            $category[$key]=$val->nama;
            $suara[$key]=(int)$val->total_suara;
        }
        
        $return = array('category'=>json_encode($category),'suara'=>json_encode($suara));
        return $return;
    }
    
    public function affiliate(){
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

    private function accessMenu(){
        $result = array(
            'add'               => checkAccess('add'),
            'view_log_activity' => checkAccess('view_log_activity')
        );

        return $result;
    }

    public function viewManualBook()
    {
        $file = "manual_book_tjb_andalanku.pdf";
        $path = public_path('arsip/manual_book/'. $file);
        // header
       $header = [
         'Content-Type' => 'application/pdf',
         'Content-Disposition' => 'inline; filename="' . $file . '"'
       ];
        return response()->file($path, $header);
    }

    public function viewManualBookv2()
    {
        $file = "manual_book_tjb_andalanku_v2.pdf";
        $path = public_path('arsip/manual_book/'. $file);
        // header
       $header = [
         'Content-Type' => 'application/pdf',
         'Content-Disposition' => 'inline; filename="' . $file . '"'
       ];
        return response()->file($path, $header);
    }


    public function permissionDenied()
    {
        
        $page_title = 'Permission Denied';
        $page_description = '';
        return view('pages.permission_denied', compact('page_title', 'page_description'));
        
    }

    private function invoice()
    {
        $role_id = auth()->user()->role_id;

        $tahapan = SysRoleTahapan::select(DB::raw('GROUP_CONCAT(DISTINCT(tahapan_id) SEPARATOR ",") as tahapan_id'))->where('role_id_pengirim',$role_id)->first();
        
        $tahapan_id = $tahapan?$tahapan->tahapan_id:0;
        if($role_id==3){
            $where ="";
        }else{
            $where ="AND inh.is_complete='0'
            AND inh.recipient = $role_id";
        }

        if($tahapan_id>0){
            $sql="SELECT
                `no_invoice`,
                `no_kontrak`,
                tgl_invoice,
                `nilai_invoice`,
                `uraian_pekerjaan` ,
                IF(inh.is_complete='0','yes','no') as is_pending
            FROM
                `invoices` as inv
            LEFT JOIN invoice_histories as inh ON inv.tahapan_id=inh.tahapan_id 
                AND inv.id=inh.invoice_id 
            WHERE
                inv.deleted_at IS NULL
                AND inv.reimburse_id IS NULL
                AND inv.`tahapan_id` IN ($tahapan_id) 
                $where
            GROUP BY
                inv.id";
            $InvoiceTerkini = DB::select($sql);
        }else{
            $InvoiceTerkini = array();
        }
        

        $total_inv = Invoice::count();
        $selesai = Invoice::whereIn('tahapan_id',[16])->count();
        //$pending = InvoiceHistory::where('is_verifikasi','0')->where('is_complete','0')->distinct('invoice_id')->count();
        $pending = Invoice::whereIn('is_cancel_payment',['1','2'])->distinct('id')->count();
        $onprogres = (int) $total_inv-((int)$pending+(int)$selesai);

        $dataInvoice = array(
            'InvoiceTerkini'    => $InvoiceTerkini,
            'selesai'           => $selesai,
            'onprogres'         => $onprogres>0?$onprogres:0,
            'pending'           => $pending
        );
        return $dataInvoice;
    }

    public function grafik_inv(){
        $adminkku = Invoice::where('tahapan_id',1)->count();
        $sekregm = $this->query_grafik_inv(4);
        $gm = $this->query_grafik_inv(5);
        $srmkku = $this->query_grafik_inv(6);
        $MSBKEU = $this->query_grafik_inv(7);
        $MSBANG = $this->query_grafik_inv(8);
        $AMNKEU = $this->query_grafik_inv(9);
        $Pajak = $this->query_grafik_inv(10);
        $Ang = $this->query_grafik_inv(11);
        $Verifikator = $this->query_grafik_inv(12);
        $treasury = $this->query_grafik_inv(13);

        $data = array(
            (int) $adminkku,
            (int) $sekregm,
            (int) $gm,
            (int) $srmkku,
            (int) $MSBKEU,
            (int) $MSBANG,
            (int) $AMNKEU,
            (int) $Pajak,
            (int) $Ang,
            (int) $Verifikator,
            (int) $treasury
        );
        return json_encode($data);
    }

    private function query_grafik_inv($role_id){
        
        $tahapan = SysRoleTahapan::select(DB::raw('GROUP_CONCAT(DISTINCT(tahapan_id) SEPARATOR ",") as tahapan_id'))->where('role_id_pengirim',$role_id)->first();
        
        $tahapan_id = $tahapan?$tahapan->tahapan_id:0;
      
        $total = array(); 
        if($tahapan_id>0){
            $sql="SELECT
                inv.id
            FROM
                `invoices` as inv
            LEFT JOIN invoice_histories as inh ON inv.tahapan_id=inh.tahapan_id 
                AND inv.id=inh.invoice_id 
                AND inh.is_complete='0'
            WHERE
                inv.`tahapan_id` IN ($tahapan_id) 
                AND inv.deleted_at IS NULL
                AND inv.reimburse_id IS NULL
                AND inh.is_complete='0'
                AND inh.recipient = $role_id
            GROUP BY
                inv.id";
            $total = DB::select($sql);
            $inv = count($total);
        }else{
            $inv = 0;
        }
        return $inv;
    }

    private function pajak()
    {
        $role_id = auth()->user()->role_id;

        $tahapan = SysRoleTahapanPajak::select(DB::raw('GROUP_CONCAT(DISTINCT(tahapan_id) SEPARATOR ",") as tahapan_id'))->where('role_id_pengirim',$role_id)->first();
        
        $tahapan_id = $tahapan?$tahapan->tahapan_id:0;
        
        if($role_id==10){
            $where ="";
        }else{
            $where ="AND inh.is_complete='0'
            AND inh.recipient = $role_id";
        }

        if($tahapan_id>0){
        $sql="SELECT
                `no_pajak`,
                `no_doc_sap`,
                tgl_pajak,
                `nilai_pajak`,
                jp.pajak as jenis_pajak ,
                masa_pajak,
                IF(inh.is_complete='0','yes','no') as is_pending
            FROM
                `pajaks` as pjk
            LEFT JOIN pajak_histories as inh ON pjk.tahapan_id=inh.tahapan_id AND pjk.id=inh.pajak_id 
            LEFT JOIN jenis_pajaks as jp ON jp.id=pjk.jenis_pajak_id
            WHERE
                pjk.`tahapan_id` IN ($tahapan_id) 
                AND pjk.deleted_at IS NULL
                $where
            GROUP BY
                pjk.id";
            $PajakTerkini = DB::select($sql);
        }else{
            $PajakTerkini = array();
        }

        $total_pjk = Pajak::count();
        $selesai = Pajak::whereIn('tahapan_id',[9])->count();
        $pending = Pajak::whereIn('is_cancel_payment',['1','2'])->distinct('id')->count();
        $onprogres = (int) $total_pjk-((int)$pending+(int)$selesai);

        $dataPajak = array(
            'PajakTerkini'      => $PajakTerkini,
            'selesai'           => $selesai,
            'onprogres'         => $onprogres>0?$onprogres:0,
            'pending'           => $pending
        );
        return $dataPajak;
    }

    public function grafik_pajak(){
        $Pajak = Pajak::where('tahapan_id',1)->count();
        $AMNKEU = $this->query_grafik_pajak(9);
        $MSBKEU = $this->query_grafik_pajak(7);
        $srmkku = $this->query_grafik_pajak(6);
        $gm = $this->query_grafik_pajak(5);
        $treasury = $this->query_grafik_pajak(13);

        $data = array(
            (int) $Pajak,
            (int) $AMNKEU,
            (int) $MSBKEU,
            (int) $srmkku,
            (int) $treasury,
            (int) $gm
        );
        return json_encode($data);
    }

    private function query_grafik_pajak($role_id){
        
        $tahapan = SysRoleTahapanPajak::select(DB::raw('GROUP_CONCAT(DISTINCT(tahapan_id) SEPARATOR ",") as tahapan_id'))->where('role_id_pengirim',$role_id)->first();
        
        $tahapan_id = $tahapan?$tahapan->tahapan_id:0;
      
        $total = array(); 
        if($tahapan_id>0){
            $sql="SELECT
                `no_pajak`,
                `no_doc_sap`
            FROM
                `pajaks` as pjk
            LEFT JOIN pajak_histories as inh ON pjk.tahapan_id=inh.tahapan_id AND pjk.id=inh.pajak_id 
            WHERE
                pjk.`tahapan_id` IN ($tahapan_id) 
                AND inh.is_complete='0'
                AND pjk.deleted_at IS NULL
                AND inh.recipient = $role_id
                AND pjk.tahapan_id < 9
            GROUP BY
                pjk.id";
            $total = DB::select($sql);
            $pjk = count($total);
        }else{
            $pjk = 0;
        }
        return $pjk;
    }

    private function showBalanceSaldo($currency_id)
    {
        
        // $date_end = date('Y-m-d');
        // $lastWeek = date('Y-m-d',strtotime('-7 days',strtotime($date_end))); 
        // $date_start = $lastWeek;

        $date_end = date('Y-m-d');
        $date_start = date('Y-m').'-01';;

        $saldo_awal = 0; $saldo_akhir = 0;
        
        $in_awal = Saldo::select('nominal')->where('currency_id',$currency_id)->where('tipe','in')->where('tanggal','<',$date_start)->sum('nominal');
        $out_awal = Saldo::select('nominal')->where('currency_id',$currency_id)->where('tipe','out')->where('tanggal','<',$date_start)->sum('nominal');
        
        $saldo_awal = $in_awal-$out_awal;

        $in = Saldo::select('nominal')->where('currency_id',$currency_id)->where('tipe','in')->whereBetween('tanggal', [$date_start, $date_end])->sum('nominal');
        $out = Saldo::select('nominal')->where('currency_id',$currency_id)->where('tipe','out')->whereBetween('tanggal', [$date_start, $date_end])->sum('nominal');

        $saldo_akhir = ($saldo_awal+$in)-$out;
        $tgl_saldo_awal = date('Y-m-d',strtotime('-1 days',strtotime($date_start)));
        $return = array(
            'saldo_awal'    => number_format($saldo_awal,0,',','.'),
            'in'            => number_format($in,0,',','.'),
            'out'           => number_format($out,0,',','.'),
            'saldo_akhir'   =>  number_format($saldo_akhir,0,',','.'),

            'saldo_saat_ini' =>  number_format($saldo_akhir,0,',','.'),
            'tgl_saldo_awal' =>  date('d/m/Y',strtotime($tgl_saldo_awal)),
            'tgl_saldo_akhir' =>  date('d/m/Y',strtotime($date_end)),
            'periode'       =>  date('d-m-Y',strtotime($date_start))." s/d ".date('d-m-Y',strtotime($date_end)),
        );
        return $return;
    }

    public function testing(){
        $role = SysRole::all();
       return $role;
    }

    public function profile(){
        $user_id = auth()->user()->id;
        $role_id = auth()->user()->role_id;
        $page_title = 'Profile';
        $user = User::find(auth()->user()->id);
        $role = SysRole::find($role_id);
        $password="";
        return view('pages.system.user.profile', compact('page_title','role','user','password'));
    }

    public function updatePassword(){
        $user_id = auth()->user()->id;
        $role_id = auth()->user()->role_id;
        $page_title = 'Update Password';
        $user = User::find(auth()->user()->id);
        $role = SysRole::find($role_id);
        //echo json_encode($user);die;
        if($user->last_updated!="" OR $user->last_updated!=NULL){
            $status="2";
            $message ="Password Bapak/Ibu sudah lebih dari 30 hari , untuk keamanan sebaiknya segera ganti Password Bapak/Ibu.";
        }else{
            $status="1";
            $message ="Demi keamanan silahkan ganti Password Default Bapak/Ibu terlebih dahulu!";
        }
        $password="";
        return view('auth.update_password', compact('page_title','role','user','password','message','status'));
    }

    public function generateMenu(){
        $menu = DB::table('sys_menus')->get();
        foreach ($menu as $key => $val) {
            if($val->arrow==1){
                $length = 1;
            }
            else if($val->id==2){
                $length = 19;
            }
            else if($val->id==3){
                $length = 11;
            }
            else{
                $length = 4;
            }

            for ($i=1; $i <= $length; $i++) { 
                $index =array(
                    'menu_id'       =>$val->id,
                    'action_id'     =>$i,
                );
                DB::table('sys_menu_actions')->insert($index);
            }
            
            
        }
    }

    /**
     * Demo methods below
     */

    // Datatables
    public function datatables()
    {
        $page_title = 'Datatables';
        $page_description = 'This is datatables test page';

        return view('pages.datatables', compact('page_title', 'page_description'));
    }

    // KTDatatables
    public function ktDatatables()
    {
        $page_title = 'KTDatatables';
        $page_description = 'This is KTdatatables test page';

        return view('pages.ktdatatables', compact('page_title', 'page_description'));
    }

    // Select2
    public function select2()
    {
        $page_title = 'Select 2';
        $page_description = 'This is Select2 test page';

        return view('pages.select2', compact('page_title', 'page_description'));
    }

    // jQuery-mask
    public function jQueryMask()
    {
        $page_title = 'jquery-mask';
        $page_description = 'This is jquery masks test page';

        return view('pages.jquery-mask', compact('page_title', 'page_description'));
    }

    // custom-icons
    public function customIcons()
    {
        $page_title = 'customIcons';
        $page_description = 'This is customIcons test page';

        return view('pages.icons.custom-icons', compact('page_title', 'page_description'));
    }

    // flaticon
    public function flaticon()
    {
        $page_title = 'flaticon';
        $page_description = 'This is flaticon test page';

        return view('pages.icons.flaticon', compact('page_title', 'page_description'));
    }

    // fontawesome
    public function fontawesome()
    {
        $page_title = 'fontawesome';
        $page_description = 'This is fontawesome test page';

        return view('pages.icons.fontawesome', compact('page_title', 'page_description'));
    }

    // lineawesome
    public function lineawesome()
    {
        $page_title = 'lineawesome';
        $page_description = 'This is lineawesome test page';

        return view('pages.icons.lineawesome', compact('page_title', 'page_description'));
    }

    // socicons
    public function socicons()
    {
        $page_title = 'socicons';
        $page_description = 'This is socicons test page';

        return view('pages.icons.socicons', compact('page_title', 'page_description'));
    }

    // svg
    public function svg()
    {
        $page_title = 'svg';
        $page_description = 'This is svg test page';

        return view('pages.icons.svg', compact('page_title', 'page_description'));
    }

    // Quicksearch Result
    public function quickSearch()
    {
        return view('layout.partials.extras._quick_search_result');
    }
}
