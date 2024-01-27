<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysAction extends Model
{
    //use HasFactory;
    use SoftDeletes;
    protected $table = 'sys_actions';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
}
