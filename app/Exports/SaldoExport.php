<?php

namespace App\Exports;

use App\Models\Saldo;
use App\Models\RefBank;
use App\Models\RefCurrency;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class SaldoExport implements FromView
{
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }

    public function view(): View
    {
        $currency_id = $this->request['currency_id_exp'];
        $curr = RefCurrency::find($currency_id);
        $bank_id = $this->request['bank_id_exp'];
        $no_cek = $this->request['no_cek_exp'];
        $uraian = $this->request['uraian_exp'];
        
        if($bank_id!=""){
            $getbank = RefBank::find($bank_id);
            $bank = $getbank->bank;
        }else{
            $bank = "Semua Bank";
        }
        // $date_end = date('Y-m-d');
        // $lastWeek = date('Y-m-d',strtotime('-7 days',strtotime($date_end)));
        // $lastMonth = date('Y-m-d',strtotime('-1 months',strtotime($date_end))); 
        // $date_start = $lastMonth;

        $date_start = $this->request['start_date_exp'];
        $date_end = $this->request['end_date_exp'];
       
        $in_awal = Saldo::select('nominal')->where('tipe','in')
                    ->where('currency_id',$currency_id)
                    ->where('tanggal','<',$date_start)
                    ->when($bank_id, function ($query, $bank_id) {
                        return $query->where('bank_id', $bank_id);
                    })
                    
                    ->where('status_code','active')
                    ->sum('nominal');
        $out_awal = Saldo::select('nominal')->where('tipe','out')
                    ->where('currency_id',$currency_id)
                    ->where('tanggal','<',$date_start)
                    ->when($bank_id, function ($query, $bank_id) {
                        return $query->where('bank_id', $bank_id);
                    })
                    
                    ->where('status_code','active')
                    ->sum('nominal');
        
        $saldo_awal = $in_awal-$out_awal;

        $in = Saldo::select('nominal')->where('tipe','in')
                ->where('currency_id',$currency_id)
                ->whereBetween('tanggal', [$date_start, $date_end])
                ->when($bank_id, function ($query, $bank_id) {
                    return $query->where('bank_id', $bank_id);
                })
                ->when($no_cek, function ($query, $no_cek) {
                    return $query->where('no_cek', $no_cek);
                })
                ->where('status_code','active')
                ->sum('nominal');
        $out = Saldo::select('nominal')->where('tipe','out')
                ->where('currency_id',$currency_id)
                ->whereBetween('tanggal', [$date_start, $date_end])
                ->when($bank_id, function ($query, $bank_id) {
                    return $query->where('bank_id', $bank_id);
                })
                ->when($no_cek, function ($query, $no_cek) {
                    return $query->where('no_cek', $no_cek);
                })
                
                ->where('status_code','active')
                ->sum('nominal');

        $total_out = Saldo::select('nominal')->where('tipe','out')
                ->where('currency_id',$currency_id)
                ->whereBetween('tanggal', [$date_start, $date_end])
                ->when($bank_id, function ($query, $bank_id) {
                    return $query->where('bank_id', $bank_id);
                })
                ->where('status_code','active')
                ->sum('nominal');

        $saldo_akhir = ($saldo_awal+$in)-$out;
        //$saldo_akhir = ($saldo_awal+$in)-$total_out;

        $invoice = Saldo::select('saldos.*','inv.nama_vendor','b.bank',DB::raw("IF(tipe='in',nominal,0) as dana_masuk,IF(tipe='out',nominal,0) as dana_keluar"))
                    ->leftJoin('ref_banks as b','b.id','saldos.bank_id')
                    ->leftJoin('invoices as inv','inv.id','saldos.invoice_id')
                    ->where('saldos.currency_id',$currency_id)
                    ->whereBetween('saldos.tanggal',[$date_start, $date_end])
                    ->when($bank_id, function ($query, $bank_id) {
                        return $query->where('saldos.bank_id', $bank_id);
                    })
                    ->when($no_cek, function ($query, $no_cek) {
                        return $query->where('saldos.no_cek', $no_cek);
                    })
                    ->when($uraian, function ($query, $uraian) {
                        return $query->where('saldos.keterangan','like', '%'.$uraian.'%');
                    })
                    ->where('saldos.status_code','active')
                    ->orderBy('tanggal','ASC')
                    ->get(); 

        return view('pages.exports.saldo_bank', [
            'invoices'      => $invoice,
            'saldo_awal'    => $saldo_awal,
            'in'            => $in,
            'out'           => $out,
            'saldo_akhir'   => $saldo_akhir,
            'date_start'       => $date_start,
            'date_end'       => $date_end,
            'bank'           => $bank,
            'currency'      => $curr->currency,
            'no_cek'        => $no_cek

        ]);
    }
}
