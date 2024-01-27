<?php

namespace App\Imports;

use App\Models\InvoiceChecklistKelengkapan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class KlasifikasiInvImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $request;

    public function __construct($params)
    {
        $this->request = $params;
    }

    public function model(array $row)
    {
        $invoice_id = $this->request['InvoiceID'];
        InvoiceChecklistKelengkapan::where('invoice_id',$invoice_id)->where('klasifikasi_invoice_id',$row[1])->delete();
        if($row[4]!=""){
            $data = array(
                
                'invoice_id'    =>  $invoice_id,
                'klasifikasi_invoice_id'    =>  $row[1],
                'is_check'      =>  1,
                'keterangan'    =>  $row[4],
                'created_by'=> auth()->user()->id,
            );
            return new InvoiceChecklistKelengkapan($data);
        }
        
    }

    public function startRow(): int
    {
        return 2;
    }
}
