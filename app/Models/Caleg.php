<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Caleg extends Model implements Auditable
{
    use SoftDeletes,\OwenIt\Auditing\Auditable;
    protected $table = 'calegs';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'no',
        'nama',
        'partai',
        'status_code',
        'updated_by',
        'updated_at',
        'created_by',
        'created_at'
    ];
}
