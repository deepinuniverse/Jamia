<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyCardData extends Model
{
    use HasFactory;
    
    protected $table='shareholdersnfamilydata';
    protected $guarded=[];
    
    public $timestamps = false;
}
