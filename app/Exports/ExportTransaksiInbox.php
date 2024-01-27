<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\SysRoleTahapanTransaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class ExportTransaksiInbox implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        $no_invoice = $this->request['no_invoice_exp'];
        $nama_vendor = $this->request['nama_vendor_exp'];
        $jenis_transaksi_id = $this->request['jenis_transaksi_id_exp'];
        $currency_id = $this->request['currency_id_exp'];
        $tahapan_id = $this->request['tahapan_id_exp'];
        $kendala = $this->request['kendala_exp'];
        $ColumnShow = $this->request['ColumnShow'];

        $start_date = $this->request['start_date_exp'];
        if($this->request['end_date_exp']!=""){
            $end_date = $this->request['end_date_exp'];
        }else{
            $end_date = date('Y-m-d');
        }

        $nilai_invoice_start = $this->request['nilai_invoice_start_exp'];
        if($this->request['nilai_invoice_end_exp']!=""){
            $nilai_invoice_end = $this->request['nilai_invoice_end_exp'];
        }else{
            $nilai_invoice_end = $nilai_invoice_start;
        }

        $tgl_bayar_start = $this->request['tgl_bayar_start_exp'];
        if($this->request['tgl_bayar_end_exp']!=""){
            $tgl_bayar_end = $this->request['tgl_bayar_end_exp'];
        }else{
            $tgl_bayar_end = date('Y-m-d');
        }

        $role_id = auth()->user()->role_id;
        $tahapan = SysRoleTahapanTransaksi::select(DB::raw('GROUP_CONCAT(DISTINCT(tahapan_id) SEPARATOR ",") as tahapan_id'))->where('role_id_pengirim',$role_id)->first();
        
        if(@$tahapan->tahapan_id!=""){
            $tahapan_id = $tahapan->tahapan_id;
            $arr =  explode(',',$tahapan_id);
            $arra_uniq = array_unique($arr);
            $tahapan_id= implode(',',$arra_uniq);
        }else{
            $tahapan_id = "1000";
        }

        if($role_id==3){
            $where ="";
        }else{
            $where ="AND his.is_complete='0'
                    AND his.recipient = $role_id";
        }

        $inv = Invoice::select('invoices.*','rt.label as tahapan','his.is_verifikasi','his.is_complete','cur.currency','cur.code','jt.label as jenis_transaksi',DB::raw('GROUP_CONCAT(DISTINCT(h.penerima) SEPARATOR ",") as disposisi'))
                ->with('history_kendala')
                ->leftJoin('ref_tahapan_transaksis as rt','rt.id','=','invoices.tahapan_id')
                ->leftJoin('ref_jenis_transaksis as jt','jt.id','=','invoices.jenis_transaksi_id')
                ->leftJoin('ref_currencies as cur','cur.id','=','invoices.currency_id')
                ->leftJoin('invoice_histories as his', function($join)
                {
                    $join->on('his.invoice_id', '=', 'invoices.id');
                    $join->on('his.tahapan_id', '=', 'invoices.tahapan_id');
                    $join->on('his.is_complete','=',DB::raw("'0'"));
                })
                ->leftJoin('invoice_histories as h', function($join)
                {
                    $join->on('h.invoice_id', '=', 'invoices.id');
                    $join->on('h.tahapan_id', '=', 'invoices.tahapan_id');
                    $join->on('h.is_complete','=',DB::raw("'0'"));
                })
                ->whereRaw(DB::raw(" invoices.status_code='active' AND invoices.tahapan_id IN ( $tahapan_id ) ".$where." "))
                ->when($no_invoice, function ($query, $no_invoice) {
                    return $query->where('invoices.no_invoice','like', '%'.$no_invoice.'%');
                })
                ->when($nama_vendor, function ($query, $nama_vendor) {
                    return $query->where('invoices.nama_vendor','like', '%'.$nama_vendor.'%');
                })
                ->when($jenis_transaksi_id, function ($query, $jenis_transaksi_id) {
                    return $query->where('invoices.jenis_transaksi_id',$jenis_transaksi_id);
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
                ->when($kendala, function ($query) use ($kendala) {
                    $query->whereHas('history_kendala', function( $query2 ) use ( $kendala ){
                        $query2->where('kendala', $kendala);
                    });
                })
                ->where('invoices.is_trans','1')
                ->where('invoices.is_cancel_payment','!=','1')
                ->groupBy('invoices.id')
                ->get(); 
        return view('pages.exports.transaksi', [
            'invoices' => $inv,
            'ColumnShow' =>$ColumnShow
        ]);
    }
}
