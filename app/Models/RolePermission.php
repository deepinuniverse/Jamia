<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    public function role()
    {
        return $this->belongsTo('App\Models\Role','roles_id');
    }
    public function permission()
    {
        return $this->belongsTo('App\Models\Permission','permissions_id');
    }
}
