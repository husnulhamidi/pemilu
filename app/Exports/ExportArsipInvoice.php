<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\InvoiceDokumen;
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

class ExportArsipInvoice implements FromView
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
        $no_kontrak = $this->request['no_kontrak_exp'];

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
        $inv = InvoiceDokumen::join('invoices as inv','inv.id','=','invoice_dokumens.invoice_id')
                ->select('invoice_dokumens.*','inv.no_invoice','inv.no_kontrak','inv.tgl_invoice','inv.nama_vendor','inv.tgl_bayar','inv.uraian_pekerjaan')
                ->when($no_invoice, function ($query, $no_invoice) {
                    return $query->where('inv.no_invoice','like', '%'.$no_invoice.'%');
                })
                ->when($nama_vendor, function ($query, $nama_vendor) {
                    return $query->where('inv.nama_vendor','like', '%'.$nama_vendor.'%');
                })
                ->when($no_kontrak, function ($query, $no_kontrak) {
                    return $query->where('inv.no_kontrak','like', '%'.$no_kontrak.'%');
                })
                ->when($start_date, function ($query) use ($start_date,$end_date) {
                    return $query->whereBetween('inv.tgl_invoice',[$start_date, $end_date]);
                })
                ->when($nilai_invoice_start, function ($query) use ($nilai_invoice_start,$nilai_invoice_end) {
                    return $query->whereBetween('inv.nilai_invoice',[$nilai_invoice_start, $nilai_invoice_end]);
                })
                ->when($tgl_bayar_start, function ($query) use ($tgl_bayar_start,$tgl_bayar_end) {
                    return $query->whereBetween('inv.tgl_bayar',[$tgl_bayar_start, $tgl_bayar_end]);
                })
                ->where('inv.status_code','active')
                ->get(); 
        return view('pages.exports.arsip_invoice', [
            'invoices' => $inv
        ]);
    }
}
