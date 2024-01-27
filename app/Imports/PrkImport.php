<?php

namespace App\Imports;

use App\Models\Prk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class PrkImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        $prk = Prk::where('no_prk',$row[1])->where('tahun',$row[10])->first();
        if(empty($prk)){
            $data = array(
                'no_prk'    => $row[1],
                'user'      => $row[2],
                'owner'     => $row[3],
                'kategori'  => $row[4],
                'uraian'    => $row[5],
                'anggaran_multiyears'   => $row[6]!=''? (double)$row[6]:null,
                'anggaran_operasi'      => (double) $row[7],
                'ako'        => (double) $row[8],
                'saldo_ako'  => (double) $row[8],
                'jenis'     => $row[9],
                'tahun'     => $row[10],
                'created_by'=> auth()->user()->id,
            );
            return new Prk($data);
        }
        
    }

    public function startRow(): int
    {
        return 2;
    }
}
