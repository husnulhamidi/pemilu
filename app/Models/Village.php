<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Village extends Model 
{
    //use HasFactory;
    //use SoftDeletes,\OwenIt\Auditing\Auditable;
    protected $table = 'reg_village';
    protected $primaryKey = 'VillageID';
    //protected $dates = ['deleted_at'];
    
    public function subdistrict()
    {
        return $this->belongsTo(SubDistrict::class,'SubDistrictID','SubDistrictID')->select(['SubDistrictID', 'SubDistrictName']);
    }
}
