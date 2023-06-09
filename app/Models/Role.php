<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public function permissions()
    {
        return $this->belongsToMany(
            'App\Models\Permission', 'role_permissions', 'roles_id' , 'permissions_id'
        );
    }
}
