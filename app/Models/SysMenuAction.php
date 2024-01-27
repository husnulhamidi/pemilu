<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysMenuAction extends Model
{
    use SoftDeletes;
    protected $table = 'sys_menu_actions';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'menu_id',
        'action_id',
        'status_code',
        'updated_by',
        'updated_at',
        'created_by',
        'created_at'
    ];

    public function menu(){
        return $this->belongsTo(SysMenu::class,'menu_id');
	}

    public function action(){
        return $this->belongsTo(SysAction::class,'action_id');
	}

    public function role_menu_access(){
        return $this->hasOne(SysRoleMenuAction::class,'menu_action_id');
	}
}
