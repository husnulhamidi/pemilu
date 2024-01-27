<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Reimburse;

class ReimburseExport implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        
        $deskripsi = $this->request['deskripsi_exp_out'];
        $no_invoice = $this->request['no_invoice_exp_out'];
        $nama_vendor = $this->request['nama_vendor_exp_out'];
        $no_kontrak = str_replace(" ","",$this->request['no_kontrak_exp_out']);
        $tahapan_id = $this->request['tahapan_id_exp_out'];
        $ColumnShow = $this->request['ColumnShow'];
        $ColumnShowDetail = $this->request['ColumnShowDetail'];
        
        $start_date = $this->request['start_date_exp_out'];
        if($this->request['end_date_exp_out']!=""){
            $end_date = $this->request['end_date_exp_out'];
        }else{
            $end_date = date('Y-m-d');
        }

        $nilai_start = $this->request['nilai_start_exp_out'];
        if($this->request['nilai_end_exp_out']!=""){
            $nilai_end = $this->request['nilai_end_exp_out'];
        }else{
            $nilai_end = $nilai_start;
        }

        $tgl_bayar_start = $this->request['tgl_bayar_start_exp_out'];
        if($this->request['tgl_bayar_end_exp_out']!=""){
            $tgl_bayar_end = $this->request['tgl_bayar_end_exp_out'];
        }else{
            $tgl_bayar_end = date('Y-m-d');
        }

        $reim = Reimburse::with(['tahapan' => function($query){
                return $query->select('id','label');
            },'bank' => function($query){
                return $query->select('id','bank');
            },
            'invoice'
            ])
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
                return $query->where('tahapan_id',$tahapan_id);
            })
            ->get();
        return view('pages.exports.reimburse', [
            'reimburse' => $reim,
            'ColumnShow' =>$ColumnShow,
            'ColumnShowDetail'  => $ColumnShowDetail
        ]);
    }
}
