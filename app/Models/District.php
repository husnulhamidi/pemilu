<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class District extends Model 
{
    //use HasFactory;
    //use SoftDeletes,\OwenIt\Auditing\Auditable;
    protected $table = 'reg_district';
    protected $primaryKey = 'District';
    
}
