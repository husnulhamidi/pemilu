<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\KlasifikasiInvoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class ExportKategoriInvoice implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        $title='form verifikasi umum';
        $JenisTagihan = $this->request['JenisTagihan'];
        $InvoiceID = $this->request['InvoiceID'];
    
        $checklist = KlasifikasiInvoice::select('klasifikasi_invoices.id','klasifikasi_invoices.jenis_tagihan','klasifikasi_invoices.uraian','ck.is_check','ck.keterangan')
                    ->leftJoin('invoice_checklist_kelengkapans as ck', function($join) use ($InvoiceID)
                    {
                        $join->on('ck.invoice_id', '=', DB::raw($InvoiceID));
                        $join->on('ck.klasifikasi_invoice_id', '=', 'klasifikasi_invoices.id');
                    })
                    ->where('jenis_tagihan',$JenisTagihan)
                    ->orderBy('klasifikasi_invoices.id','ASC')
                    ->get();
        
        return view('pages.exports.kategori_invoice', [
            'title' =>$title,
            'cheklistKelengkapan' => $checklist
        ]);
    }
}
