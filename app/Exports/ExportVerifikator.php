<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\KlasifikasiInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class ExportVerifikator implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        $title='form verifikasi umum';
        $InvoiceID = $this->request['invid_export'];
        $inv = Invoice::select('invoices.*','jp.pajak as pph','u.name as nama_verifikator','cur.currency','cur.code as currency_code','ven.sapid')
                ->leftJoin('jenis_pajaks as jp','jp.id','=','invoices.pajak_id')
                ->leftJoin('users as u','u.id','=','invoices.verifikator')
                ->leftJoin('ref_currencies as cur','cur.id','=','invoices.currency_id')
                ->leftJoin('sys_vendor as ven','ven.vendor','=','invoices.nama_vendor')
                ->where('invoices.id',$InvoiceID)
                ->first();

        $cheklistKelengkapan = KlasifikasiInvoice::
            leftJoin('invoice_checklist_kelengkapans as ck', function($join) use ($InvoiceID)
            {
                $join->on('ck.klasifikasi_invoice_id', '=', 'klasifikasi_invoices.id');
                $join->on('ck.invoice_id','=',DB::raw($InvoiceID));
            })
            ->select('klasifikasi_invoices.id','klasifikasi_invoices.jenis_tagihan','klasifikasi_invoices.uraian','ck.invoice_id','ck.is_check','ck.keterangan','ck.created_at')
            ->where('jenis_tagihan',$inv->jenis_tagihan)
            ->orderBy('klasifikasi_invoices.id','ASC')
            ->get();
        
        $i=0;
        // $data = array(
        //     'title' =>$title,
        //     'inv' => $inv,
        //     'cheklistKelengkapan' => $cheklistKelengkapan
        // ); 
        // echo json_encode($data);die;
        return view('pages.exports.form_verifikator', [
            'title' =>$title,
            'inv' => $inv,
            'cheklistKelengkapan' => $cheklistKelengkapan
        ]);
    }
}
