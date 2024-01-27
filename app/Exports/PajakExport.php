<?php

namespace App\Exports;

use App\Models\Pajak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class PajakExport implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }

    public function view(): View
    {
        $jenis_pajak = $this->request['jenis_pajak_exp_out'];
        $no_doc_sap = $this->request['no_doc_sap_exp_out'];
        $masa_pajak = $this->request['masa_pajak_exp_out'];
        $no_doc_bayar = $this->request['no_doc_bayar_exp_out'];
        $ColumnShow = $this->request['ColumnShow'];

        $start_date = $this->request['start_date_exp_out'];
        if($this->request['end_date_exp_out']!=""){
            $end_date = $this->request['end_date_exp_out'];
        }else{
            $end_date = date('Y-m-d');
        }

        $nilai_pajak_start = $this->request['nilai_pajak_start_exp_out'];
        if($this->request['nilai_pajak_end_exp_out']!=""){
            $nilai_pajak_end = $this->request['nilai_pajak_end_exp_out'];
        }else{
            $nilai_pajak_end = $nilai_pajak_start;
        }

        $tgl_bayar_start = $this->request['tgl_bayar_start_exp_out'];
        if($this->request['tgl_bayar_end_exp_out']!=""){
            $tgl_bayar_end = $this->request['tgl_bayar_end_exp_out'];
        }else{
            $tgl_bayar_end = date('Y-m-d');
        }

        $pjk = Pajak::select('pajaks.id','pajaks.no_pajak','pajaks.jenis_pajak_id','pajaks.no_doc_sap','pajaks.tgl_pajak','pajaks.masa_pajak','pajaks.nilai_pajak','pajaks.no_dokumen_bayar','pajaks.tgl_bayar','pajaks.tahapan_id','pajaks.keterangan','pajaks.jenis_pajak','rtp.label as tahapan','his.is_verifikasi')
                ->with(['detail' => function ($query) {
                    $query->with('jenis_pajak');
                }])    
                ->leftJoin('jenis_pajaks as jp','jp.id','=','pajaks.jenis_pajak_id')
                ->leftJoin('ref_tahapan_pajaks as rtp','rtp.id','=','pajaks.tahapan_id')
                ->leftJoin('pajak_histories as his', function($join)
                {
                    $join->on('his.pajak_id', '=', 'pajaks.id');
                    $join->on('his.tahapan_id', '=', 'pajaks.tahapan_id');
                    $join->on('his.is_verifikasi','=',DB::raw("'0'"));
                    $join->on('his.is_complete','=',DB::raw("'0'"));
                })
                ->when($jenis_pajak, function ($query, $jenis_pajak) {
                    return $query->where('pajaks.jenis_pajak' ,'like', '%'.$jenis_pajak.'%');
                })
                ->when($no_doc_bayar, function ($query, $no_doc_bayar) {
                    return $query->where('pajaks.no_dokumen_bayar','like', '%'.$no_doc_bayar.'%');
                })
                ->when($masa_pajak, function ($query, $masa_pajak) {
                    return $query->where('pajaks.masa_pajak','like', '%'.$masa_pajak.'%');
                })
                ->when($start_date, function ($query) use ($start_date,$end_date) {
                    return $query->whereBetween('pajaks.tgl_pajak',[$start_date, $end_date]);
                })
                ->when($nilai_pajak_start, function ($query) use ($nilai_pajak_start,$nilai_pajak_end) {
                    return $query->whereBetween('pajaks.nilai_pajak',[$nilai_pajak_start, $nilai_pajak_end]);
                })
                ->when($tgl_bayar_start, function ($query) use ($tgl_bayar_start,$tgl_bayar_end) {
                    return $query->whereBetween('pajaks.tgl_bayar',[$tgl_bayar_start, $tgl_bayar_end]);
                })
                ->where('pajaks.status_code','active')
            ->groupBy('pajaks.id')
            ->get(); 
        return view('pages.exports.pajak', [
            'pajak' => $pjk,
            'ColumnShow' =>$ColumnShow
        ]);
    }
}
