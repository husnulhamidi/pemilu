<?php

namespace App\Exports;

use App\Models\Prk;
use App\Models\InvoiceAnggaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;


class ExportPrk implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }
    public function view(): View
    {
        
        $year = $this->request['tahun_exp'];
        $no_prk = $this->request['no_prk_exp'];
        $user = $this->request['user_exp'];
        $owner = $this->request['owner_exp'];
        $kategori = $this->request['kategori_exp'];
        $uraian = $this->request['uraian_prk_exp'];
        $saldo_ako = $this->request['saldo_ako_exp'];

        $prk = Prk::select('prks.*',DB::raw('DATE_FORMAT(prks.updated_at, "%d-%m-%Y %H:%i:%s") as date_updated, IFNULL(SUM(inv.nilai_invoice_idr),0) as nilai_invoice'))
            ->leftJoin('invoice_anggarans as ia','ia.prk_id','=','prks.id')
            ->leftJoin('invoices as inv', function($join)
            {
                $join->on('inv.id', '=', 'ia.invoice_id');
                $join->on('inv.is_cancel_payment','!=',DB::raw("'1'"));
                $join->whereNull('inv.deleted_at');
            })
            ->withCount('invoice_ang')
            ->where('prks.tahun',$year)
            ->when($no_prk, function ($query, $no_prk) {
                return $query->where('prks.no_prk','like', '%'.$no_prk.'%');
            })
            ->when($user, function ($query, $user) {
                return $query->where('prks.user',$user);
            })
            ->when($owner, function ($query, $owner) {
                return $query->where('prks.owner',$owner);
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('prks.kategori',$kategori);
            })
            ->when($saldo_ako, function ($query, $saldo_ako) {
                return $query->where('prks.saldo_ako','<',$saldo_ako);
            })
            ->where('prks.status_code','active')
            ->groupBy('prks.id')
            ->orderBy('prks.updated_at','DESC')->get(); 

            $collection = collect($prk);

            $multiplied = $collection->map(function ($item, $key) {

                return [
                    "id"                    =>$item->id,
                    "no_prk"                =>$item->no_prk,
                    "user"                  =>$item->user,
                    "owner"                 =>$item->owner,
                    "kategori"              =>$item->kategori,
                    "uraian"                =>$item->uraian,
                    "anggaran_multiyears"   =>$item->anggaran_multiyears,
                    "anggaran_operasi"      =>$item->anggaran_operasi,
                    "ako"                   =>$item->ako,
                    "jenis"                 =>$item->jenis,
                    "tahun"                 =>$item->tahun,
                    "saldo_ako"             =>$item->saldo_ako,
                    "realisasi"             =>$item->realisasi,
                    "status_code"           =>$item->status_code,
                    "date_updated"          =>$item->date_updated,

                    "realisasi_show"        =>$item->realisasi_show,
                    "nilai_invoice"         =>$item->nilai_invoice,
                    "status_code"           =>$item->status_code,
                    "date_updated"          =>$item->date_updated,
                    "saldo_ako_terpotong"   =>$this->getRealisasiAko($item->id)
                ];
            });
            
            $dataprk = $multiplied->all();

        return view('pages.exports.prk', [
            'prk' => $dataprk
        ]);
    }

    private function getRealisasiAko($id){
        return $invoice = InvoiceAnggaran::whereHas('invo',function($builder){
            $builder->where('is_cancel_payment','!=',DB::raw("'1'"));
            $builder->whereNull('deleted_at');
        })
        ->where('prk_id',$id)->sum('nilai_invoice_idr');
    }
}
