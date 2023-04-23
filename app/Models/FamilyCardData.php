<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyCardData extends Model
{
    use HasFactory;
    
    protected $table='family_card_data';
    
    public $timestamps = false;
}
