<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class HasilPemilu extends Model implements Auditable
{
    //use HasFactory;
    use SoftDeletes,\OwenIt\Auditing\Auditable;
    protected $table = 'hasil_pemilus';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'tps_id',
        'caleg_id',
        'SubDistrictID',
        'VillageID',
        'no_tps',
        'suara',
        'status_code',
        'updated_by',
        'updated_at',
        'created_by',
        'created_at'
    ];

    public function subdistrict()
    {
        return $this->belongsTo(SubDistrict::class,'SubDistrictID','SubDistrictID')->select(['SubDistrictID', 'SubDistrictName']);
    }

    public function village()
    {
        return $this->belongsTo(Village::class,'VillageID','VillageID')->select(['VillageID', 'VillageName']);
    }

    public function caleg()
    {
        return $this->belongsTo(Caleg::class,'caleg_id')->select(['id', 'nama']);
    }

}
