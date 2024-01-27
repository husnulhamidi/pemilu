<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\InvoiceGrouping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class ExportGrouping implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        
        $deskripsi = $this->request['gr_deskripsi_exp'];
        $currency_id = $this->request['gr_currency_id_exp'];
        $bank_id = $this->request['gr_bank_id_exp'];
        $cek = $this->request['gr_cek_exp'];
        $no_invoice = $this->request['gr_no_invoice_exp'];
        $ColumnShow = $this->request['ColumnShowGR'];
        $ColumnShowDetail = $this->request['ColumnShowGRDetail'];
        $tgl_bayar_start = $this->request['gr_tgl_bayar_start_exp'];
        if($this->request['gr_tgl_bayar_end_exp']!=""){
            $tgl_bayar_end = $this->request['gr_tgl_bayar_end_exp'];
        }else{
            $tgl_bayar_end = date('Y-m-d');
        }

        
        $inv = InvoiceGrouping::
                with(['bank' => function ($query) {
                    $query->with('ref_currencies');
                },'invoice'])
                ->withCount('invoice')
                ->when($deskripsi, function ($query, $deskripsi) {
                    return $query->where('keterangan','like', '%'.$deskripsi.'%');
                })
                ->when($currency_id, function ($query) use ($currency_id) {
                    return $query->where('currency_id',$currency_id);
                })
                ->when($bank_id, function ($query) use ($bank_id) {
                    return $query->where('bank_id',$bank_id);
                })
                ->when($cek, function ($query) use ($cek) {
                    return $query->where('no_cek',$cek);
                })
                ->when($tgl_bayar_start, function ($query) use ($tgl_bayar_start,$tgl_bayar_end) {
                    return $query->whereBetween('tgl_bayar',[$tgl_bayar_start, $tgl_bayar_end]);
                })
                ->when($no_invoice, function ($query, $no_invoice) {
                    $query->whereHas('invoice', function( $query ) use ( $no_invoice ){
                        $query->where('no_invoice','like', '%'.$no_invoice.'%');
                    });
                })
                ->groupBy('id')
                ->orderBy('id','DESC')
                ->get(); 
                //dd($inv);
        return view('pages.exports.grouping', [
            'grouping' => $inv,
            'ColumnShow' =>$ColumnShow,
            'ColumnShowDetail'  => $ColumnShowDetail
        ]);
    }
}
