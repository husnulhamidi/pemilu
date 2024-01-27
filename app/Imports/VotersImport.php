<?php

namespace App\Imports;

use App\Models\Voter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithStartRow;

class VotersImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {

        return Voter::firstOrCreate(['nik' => $row[1]], [
            'nama'              => $row[0],
            'nik'               => $row[1],
            'telp'              => $row[2],
            'umur'      => $row[3],
            'status'   => $row[4],
            'alamat'   => $row[5]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
