<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

// class InvoiceExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return Invoice::all();
//     }
// }

class InvoiceExport implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        
        $no_invoice = $this->request['no_invoice_exp_out'];
        $nama_vendor = $this->request['nama_vendor_exp_out'];
        $no_kontrak = str_replace(" ","",$this->request['no_kontrak_exp_out']);
        $currency_id = $this->request['currency_id_exp_out'];
        $tahapan_id = $this->request['tahapan_id_exp_out'];
        $jenis_invoice = $this->request['jenis_invoice_exp_out'];
        $no_prk = $this->request['no_prk_exp_out'];
        $kendala = $this->request['kendala_exp_out'];
        $jenis_prk = $this->request['jenis_prk_exp_out'];
        $ColumnShow = $this->request['ColumnShow'];

        $start_date = $this->request['start_date_exp_out'];
        if($this->request['end_date_exp_out']!=""){
            $end_date = $this->request['end_date_exp_out'];
        }else{
            $end_date = date('Y-m-d');
        }

        $nilai_invoice_start = $this->request['nilai_invoice_start_exp_out'];
        if($this->request['nilai_invoice_end_exp_out']!=""){
            $nilai_invoice_end = $this->request['nilai_invoice_end_exp_out'];
        }else{
            $nilai_invoice_end = $nilai_invoice_start;
        }

        $tgl_bayar_start = $this->request['tgl_bayar_start_exp_out'];
        if($this->request['tgl_bayar_end_exp_out']!=""){
            $tgl_bayar_end = $this->request['tgl_bayar_end_exp_out'];
        }else{
            $tgl_bayar_end = date('Y-m-d');
        }

          $inv = Invoice::select('invoices.*','rt.label as tahapan','his.is_verifikasi','pjk.pajak','cur.currency','cur.code as currency_code','bk.bank','prks.no_prk')
                ->with('history_kendala')
                ->with('reimburse', function($query){
                    $query->with('bank',function($q){
                    });
                })
                ->leftJoin('ref_tahapans as rt','rt.id','=','invoices.tahapan_id')
                ->leftJoin('jenis_pajaks as pjk','pjk.id','=','invoices.pajak_id')
                ->leftJoin('ref_currencies as cur','cur.id','=','invoices.currency_id')
                ->leftJoin('ref_banks as bk','bk.id','=','invoices.bank_id')
                ->leftJoin('invoice_anggarans as ia','ia.invoice_id','=','invoices.id')
                ->leftJoin('prks','prks.id','=','ia.prk_id')
                ->leftJoin('invoice_histories as his', function($join)
                {
                    $join->on('his.invoice_id', '=', 'invoices.id');
                    $join->on('his.tahapan_id', '=', 'invoices.tahapan_id');
                    $join->on('his.is_verifikasi','=',DB::raw("'0'"));
                    $join->on('his.is_complete','=',DB::raw("'0'"));
                })
                ->when($no_invoice, function ($query, $no_invoice) {
                    return $query->where('invoices.no_invoice','like', '%'.$no_invoice.'%');
                })
                ->when($nama_vendor, function ($query, $nama_vendor) {
                    return $query->where('invoices.nama_vendor','like', '%'.$nama_vendor.'%');
                })
                ->when($no_kontrak, function ($query, $no_kontrak) {
                    return $query->where('invoices.no_kontrak','like', '%'.$no_kontrak.'%');
                })
                ->when($currency_id, function ($query, $currency_id) {
                    return $query->where('invoices.currency_id',$currency_id);
                })
                ->when($start_date, function ($query) use ($start_date,$end_date) {
                    return $query->whereBetween('invoices.tgl_invoice',[$start_date, $end_date]);
                })
                ->when($nilai_invoice_start, function ($query) use ($nilai_invoice_start,$nilai_invoice_end) {
                    return $query->whereBetween('invoices.nilai_invoice',[$nilai_invoice_start, $nilai_invoice_end]);
                })
                ->when($tgl_bayar_start, function ($query) use ($tgl_bayar_start,$tgl_bayar_end) {
                    return $query->whereBetween('invoices.tgl_bayar',[$tgl_bayar_start, $tgl_bayar_end]);
                })
                ->when($tahapan_id, function ($query, $tahapan_id) {
                    return $query->where('invoices.tahapan_id',$tahapan_id);
                })
                ->when($jenis_invoice, function ($query) use ($jenis_invoice) {
                    if($jenis_invoice=='reimburse'){
                        return $query->whereNotNull('invoices.reimburse_id');
                    }else{
                        return $query->whereNull('invoices.reimburse_id');
                    }
                })
                ->when($no_prk, function ($query) use ($no_prk) {
                    return $query->where('prks.no_prk','like', '%'.$no_prk.'%');
                })
                ->when($kendala, function ($query) use ($kendala) {
                    $query->whereHas('history_kendala', function( $query2 ) use ( $kendala ){
                        $query2->where('kendala', $kendala);
                    });
                })
                ->when($jenis_prk, function ($query) use ($jenis_prk) {
                    if($jenis_prk=='prk'){
                        return $query->where('ia.prk_id','!=',9999);
                    }else{
                        return $query->where('ia.prk_id',9999);
                    }
                    
                })
                ->where('invoices.status_code','active')
                ->where('invoices.is_trans','0')
                ->groupBy('invoices.id')
                ->get(); 
                
        return view('pages.exports.invoice', [
            'invoices' => $inv,
            'ColumnShow' =>$ColumnShow
        ]);
    }
}
