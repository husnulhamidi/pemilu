<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysRoleMenuAction extends Model
{

    protected $fillable = [
        'role_id',
        'menu_action_id'
    ];

    public function menu_action(){
        return $this->belongsTo(SysMenuAction::class,'menu_action_id');
	}
}
