<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Voter extends Model implements Auditable
{
    //use HasFactory;
    use SoftDeletes,\OwenIt\Auditing\Auditable;
    protected $table = 'voters';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'nama',
        'nik',
        'umur',
        'status',
        'telp',
        'alamat',
        'status_code',
        'updated_by',
        'updated_at',
        'created_by',
        'created_at'
    ];
}
