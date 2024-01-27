<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Reimburse;

class InvoiceReimburseExport implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        $reimburse_id = $this->request['reimburse_id_exp'];
          $reimburse =  Reimburse::select('id','uraian')->find($reimburse_id);
          $inv = Invoice::select('invoices.*','rt.label as tahapan','his.is_verifikasi','pjk.pajak','cur.currency','cur.code as currency_code','bk.bank')
                ->leftJoin('ref_tahapans as rt','rt.id','=','invoices.tahapan_id')
                ->leftJoin('jenis_pajaks as pjk','pjk.id','=','invoices.pajak_id')
                ->leftJoin('ref_currencies as cur','cur.id','=','invoices.currency_id')
                ->leftJoin('ref_banks as bk','bk.id','=','invoices.bank_id')
                ->leftJoin('invoice_histories as his', function($join)
                {
                    $join->on('his.invoice_id', '=', 'invoices.id');
                    $join->on('his.tahapan_id', '=', 'invoices.tahapan_id');
                    $join->on('his.is_verifikasi','=',DB::raw("'0'"));
                    $join->on('his.is_complete','=',DB::raw("'0'"));
                })
                ->where('invoices.reimburse_id',$reimburse_id)
                ->where('invoices.status_code','active')
                ->groupBy('invoices.id')
                ->get(); 
        return view('pages.exports.invoice_reimburse', [
            'invoices' => $inv,
            'reimburse' => $reimburse->uraian
        ]);
    }
}
