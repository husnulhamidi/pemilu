<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SysRole extends Model implements Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $table = 'sys_roles';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'role',
        'is_disposisi',
        'is_approval',
        'is_back_document',
        'is_confirm_document',
        'is_update_document',
        'is_update_text',
        'status_code'
    ];
}
