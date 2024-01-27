<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\SysRoleTahapan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Reimburse;

class ReimburseExportInbox implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        
        $deskripsi = $this->request['deskripsi_exp'];
        $no_invoice = $this->request['no_invoice_exp'];
        $nama_vendor = $this->request['nama_vendor_exp'];
        $no_kontrak = str_replace(" ","",$this->request['no_kontrak_exp']);
        $tahapan_id = $this->request['tahapan_id_exp'];
        $ColumnShow = $this->request['ColumnShow'];
        $ColumnShowDetail = $this->request['ColumnShowDetail'];
        
        $start_date = $this->request['start_date_exp'];
        if($this->request['end_date_exp']!=""){
            $end_date = $this->request['end_date_exp'];
        }else{
            $end_date = date('Y-m-d');
        }

        $nilai_start = $this->request['nilai_start_exp'];
        if($this->request['nilai_end_exp']!=""){
            $nilai_end = $this->request['nilai_end_exp'];
        }else{
            $nilai_end = $nilai_start;
        }

        $tgl_bayar_start = $this->request['tgl_bayar_start_exp'];
        if($this->request['tgl_bayar_end_exp']!=""){
            $tgl_bayar_end = $this->request['tgl_bayar_end_exp'];
        }else{
            $tgl_bayar_end = date('Y-m-d');
        }

        $role_id = auth()->user()->role_id;
        $tahapan = SysRoleTahapan::select(DB::raw('GROUP_CONCAT(DISTINCT(tahapan_id) SEPARATOR ",") as tahapan_id'))->where('role_id_pengirim',$role_id)->first();
        
        if(@$tahapan->tahapan_id!=""){
            $tahapan_id = $tahapan->tahapan_id;
            $arr =  explode(',',$tahapan_id);
            $arra_uniq = array_unique($arr);
            $tahapan_id= implode(',',$arra_uniq);
        }else{
            $tahapan_id = "1000";
        }
        
        if($role_id==12){
            $where ="";
        }else{
            $where ="AND  his.recipient=$role_id
                    AND `his`.`is_complete` = '0' ";
        }

        $reim = Reimburse::with(['tahapan' => function($query){
                return $query->select('id','label');
            },'bank' => function($query){
                return $query->select('id','bank');
            },
            'invoice'
            ])
            ->leftJoin('reimburse_histories as his', function($join)
            {
                $join->on('his.reimburse_id', '=', 'reimburses.id');
                $join->on('his.tahapan_id', '=', 'reimburses.tahapan_id');
                $join->on('his.is_complete','=',DB::raw("'0'"));
            })
            ->when($deskripsi, function ($query, $deskripsi) {
                return $query->where('uraian','like', '%'.$deskripsi.'%');
            })
            ->when($start_date, function ($query) use ($start_date,$end_date) {
                return $query->whereBetween('tgl_reimburse',[$start_date, $end_date]);
            })
            ->when($nilai_start, function ($query) use ($nilai_start,$nilai_end) {
                return $query->whereBetween('total_nilai',[$nilai_start, $nilai_end]);
            })
            ->when($tgl_bayar_start, function ($query) use ($tgl_bayar_start,$tgl_bayar_end) {
                return $query->whereBetween('tgl_bayar',[$tgl_bayar_start, $tgl_bayar_end]);
            })
            
            ->when($no_invoice, function ($query, $no_invoice) {
                $query->whereHas('invoice', function( $query ) use ( $no_invoice ){
                    $query->where('no_invoice','like', '%'.$no_invoice.'%');
                });
            })
            ->when($no_kontrak, function ($query, $no_kontrak) {
                $query->whereHas('invoice', function( $query ) use ( $no_kontrak ){
                    $query->where('no_kontrak','like', '%'.$no_kontrak.'%');
                });
            })
            ->when($nama_vendor, function ($query, $nama_vendor) {
                $query->whereHas('invoice', function( $query ) use ( $nama_vendor ){
                    $query->where('nama_vendor','like', '%'.$nama_vendor.'%');
                });
            })
            ->when($tahapan_id, function ($query) use ($tahapan_id) {
                return $query->where('reimburses.tahapan_id',$tahapan_id);
            })
            ->whereRaw(DB::raw("reimburses.tahapan_id IN ( $tahapan_id ) ".$where." "))
            ->where('reimburses.is_cancel','!=', '1')
            ->get();
        return view('pages.exports.reimburse', [
            'reimburse' => $reim,
            'ColumnShow' =>$ColumnShow,
            'ColumnShowDetail'  => $ColumnShowDetail
        ]);
    }
}
