<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SysMenu extends Model
{
    use SoftDeletes;
    protected $table = 'sys_menus';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'parent_id',
        'order',
        'title',
        'page',
        'icon',
        'bullet',
        'arrow',
        'root',
        'is_parent',
        'updated_by',
        'updated_at',
        'created_by',
        'created_at'
    ];

    public function parent()
    {
        return $this->belongsTo(SysMenu::class, 'parent_id')->select(['id', 'title']);
    }

    public function submenu()
    {
        return $this->hasMany(SysMenu::class, 'parent_id');
    }

    public function labelmenu()
    {
        return $this->hasMany(SysMenuLabel::class, 'menu_id');
    }

    public function menu_action()
    {
        return $this->hasMany(SysMenuAction::class, 'menu_id')->where('status_code','active');
    }
}
