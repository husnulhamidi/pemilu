<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysMenuLabel extends Model
{
    use SoftDeletes;

    protected $table = 'sys_menu_labels';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    public function menu(){
        return $this->belongsTo(SysMenu::class,'menu_id');
	}
}
