<?php

namespace App\Exports;

use App\Models\Pajak;
use App\Models\PajakDokumen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class ExportArsipPajak implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }

    public function view(): View
    {
        $jenis_pajak = $this->request['jenis_pajak_exp'];
        $no_doc_sap = $this->request['no_doc_sap_exp'];
        $masa_pajak = $this->request['masa_pajak_exp'];
        $no_doc_bayar = $this->request['no_doc_bayar_exp'];

        $start_date = $this->request['start_date_exp'];
        if($this->request['end_date_exp']!=""){
            $end_date = $this->request['end_date_exp'];
        }else{
            $end_date = date('Y-m-d');
        }

        $nilai_pajak_start = $this->request['nilai_pajak_start_exp'];
        if($this->request['nilai_pajak_end_exp']!=""){
            $nilai_pajak_end = $this->request['nilai_pajak_end_exp'];
        }else{
            $nilai_pajak_end = $nilai_pajak_start;
        }

        $tgl_bayar_start = $this->request['tgl_bayar_start_exp'];
        if($this->request['tgl_bayar_end_exp']!=""){
            $tgl_bayar_end = $this->request['tgl_bayar_end_exp'];
        }else{
            $tgl_bayar_end = date('Y-m-d');
        }

        $pjk = PajakDokumen::join('pajaks as pjk','pjk.id','=','pajak_dokumens.pajak_id')
                ->join('jenis_pajaks as jp','jp.id','=','pjk.jenis_pajak_id')
                ->select('pajak_dokumens.*','pjk.no_pajak','pjk.no_doc_sap','pjk.masa_pajak','pjk.tgl_pajak','pjk.keterangan as uraian','jp.pajak as jenis_pajak')
                ->when($jenis_pajak, function ($query, $jenis_pajak) {
                    return $query->where('pjk.jenis_pajak_id', $jenis_pajak);
                })
                ->when($no_doc_bayar, function ($query, $no_doc_bayar) {
                    return $query->where('pjk.no_dokumen_bayar','like', '%'.$no_doc_bayar.'%');
                })
                ->when($masa_pajak, function ($query, $masa_pajak) {
                    return $query->where('pjk.masa_pajak','like', '%'.$masa_pajak.'%');
                })
                ->when($start_date, function ($query) use ($start_date,$end_date) {
                    return $query->whereBetween('pjk.tgl_pajak',[$start_date, $end_date]);
                })
                ->when($nilai_pajak_start, function ($query) use ($nilai_pajak_start,$nilai_pajak_end) {
                    return $query->whereBetween('pjk.nilai_pajak',[$nilai_pajak_start, $nilai_pajak_end]);
                })
                ->when($tgl_bayar_start, function ($query) use ($tgl_bayar_start,$tgl_bayar_end) {
                    return $query->whereBetween('pjk.tgl_bayar',[$tgl_bayar_start, $tgl_bayar_end]);
                })
                ->where('pjk.status_code','active')
            ->get(); 
        return view('pages.exports.arsip_pajak', [
            'pajak' => $pjk
        ]);
    }
}
