<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class MarEmarExport implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }

    public function view(): View
    {
        $no_invoice = $this->request['no_invoice_exp'];
        $nama_vendor = $this->request['vendor_exp'];
        $no_kontrak = $this->request['no_kontrak_exp'];
        $unit = $this->request['unit_exp'];
        $prk_id = $this->request['prk_exp'];
        $mar_id = $this->request['kategori_mar_exp'];
        $StatusPayment = $this->request['status_payment_exp'];

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

        if($StatusPayment!=""){
            $status_payment = $StatusPayment;
        }else{
            $status_payment = "";
        }
        
        $inv = Invoice::select('invoices.*','mar.label as kategori_mar' ,'prk.no_prk','prk.kategori as kategori_prk' ,'prk.user as bidang','prk.anggaran_operasi','prk.ako','prk.saldo_ako as prk_saldo_ako','ang.saldo_ako','ang.saldo','ang.unit','rem.tgl_bayar as tgl_bayar_reimburse','rem.uraian',DB::raw('IFNULL(invoices.tgl_bayar,rem.tgl_bayar) as tgl_bayar,IFNULL(jt.label,"") as jenis_transaksi '))
        //->with('reimburse')
        ->join('invoice_anggarans as ang','ang.invoice_id','=','invoices.id')
        ->join('ref_mar_emars as mar','mar.id','=','ang.klasifikasi_biaya_id')
        ->join('prks as prk','prk.id','=','ang.prk_id')
        ->leftJoin('reimburses as rem','rem.id','=','invoices.reimburse_id')
        ->leftJoin('ref_jenis_transaksis as jt','jt.id','=','invoices.jenis_transaksi_id')
        ->where('invoices.tahapan_id','>',12)
        ->where('invoices.is_cancel_payment','!=','1')
        ->when($no_invoice, function ($query, $no_invoice) {
            return $query->where('invoices.no_invoice','like', '%'. $no_invoice.'%');
        })
        ->when($nama_vendor, function ($query, $nama_vendor) {
            return $query->where('invoices.nama_vendor','like', '%'.$nama_vendor.'%');
        })
        ->when($no_kontrak, function ($query, $no_kontrak) {
            return $query->where('invoices.no_kontrak','like', '%'.$no_kontrak.'%');
        })
        ->when($start_date, function ($query) use ($start_date,$end_date) {
            return $query->whereBetween('invoices.tgl_invoice',[$start_date, $end_date]);
        })
        ->when($nilai_invoice_start, function ($query) use ($nilai_invoice_start,$nilai_invoice_end) {
            return $query->whereBetween('invoices.nilai_invoice_idr',[$nilai_invoice_start, $nilai_invoice_end]);
        })
        ->when($tgl_bayar_start, function ($query) use ($tgl_bayar_start,$tgl_bayar_end) {
            //return $query->whereBetween('invoices.tgl_bayar',[$tgl_bayar_start, $tgl_bayar_end]);
            return $query->whereBetween(DB::raw('IF(invoices.reimburse_id IS NULL,invoices.tgl_bayar,rem.tgl_bayar)'),[$tgl_bayar_start, $tgl_bayar_end]);
        })
        ->when($unit, function ($query, $unit) {
            return $query->where('ang.unit',$unit);
        })
        ->when($mar_id, function ($query, $mar_id) {
            return $query->where('ang.klasifikasi_biaya_id',$mar_id);
        })
        ->when($prk_id, function ($query, $prk_id) {
            return $query->where('ang.prk_id',$prk_id);
        })
        ->when($status_payment, function ($query, $status_payment) {
            if($status_payment=='Paid'){
                return $query->where('invoices.tahapan_id',16);
            }else{
                return $query->where('invoices.tahapan_id','<',16);
            }
            
        })
        ->where('invoices.status_code','active')
        ->get(); 

        return view('pages.exports.laporan_mar_emar', [
            'invoices' => $inv
        ]);
    }
}
