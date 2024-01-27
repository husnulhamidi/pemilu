<?php

namespace App\Exports;

use App\Models\Pajak;
use App\Models\SysRoleTahapanPajak;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class PajakExportInbox implements FromView
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
        $ColumnShow = $this->request['ColumnShow'];

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

        $role_id = auth()->user()->role_id;
        $tahapan = SysRoleTahapanPajak::select(DB::raw('GROUP_CONCAT(DISTINCT(tahapan_id) SEPARATOR ",") as tahapan_id'))->where('role_id_pengirim',$role_id)->first();
      
        if(@$tahapan->tahapan_id!=""){
            $tahapan_id = $tahapan->tahapan_id;
            $arr =  explode(',',$tahapan_id);
            $arra_uniq = array_unique($arr);
            $tahapan_id= implode(',',$arra_uniq);
        }else{
            $tahapan_id = "1000";
        }

        if($role_id==10){
            $where ="";
        }else{
            $where ="AND  his.recipient=$role_id
                    AND `his`.`is_complete` = '0' ";
        }

        $pjk = Pajak::select('pajaks.id','pajaks.is_cancel_payment','pajaks.jenis_pajak' ,'pajaks.no_pajak','pajaks.jenis_pajak_id','pajaks.no_doc_sap','pajaks.tgl_pajak','pajaks.masa_pajak','pajaks.nilai_pajak','pajaks.tgl_bayar','pajaks.tahapan_id','pajaks.keterangan','jp.pajak as jns_pajak','rtp.label as tahapan','his.is_verifikasi','his.is_complete')
                ->with(['detail' => function ($query) {
                    $query->with('jenis_pajak');
                }])     
                ->leftJoin('jenis_pajaks as jp','jp.id','=','pajaks.jenis_pajak_id')
                ->leftJoin('ref_tahapan_pajaks as rtp','rtp.id','=','pajaks.tahapan_id')
                ->leftJoin('pajak_histories as his', function($join)
                {
                    $join->on('his.pajak_id', '=', 'pajaks.id');
                    $join->on('his.tahapan_id', '=', 'pajaks.tahapan_id');
                    $join->on('his.is_complete','=',DB::raw("'0'"));
                })
            ->whereRaw(DB::raw(" pajaks.status_code='active' AND pajaks.tahapan_id IN ( $tahapan_id ) ".$where." "))
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
            ->orderBy('pajaks.id','DESC')
            ->get(); 
        return view('pages.exports.pajak', [
            'pajak' => $pjk,
            'ColumnShow' =>$ColumnShow
        ]);
    }
}
