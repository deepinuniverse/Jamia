<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    public function branchCategory()
    {
        return $this->belongsTo('App\Models\BranchCategory','branch_categories_id');
    }
}
