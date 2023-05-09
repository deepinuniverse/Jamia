<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='oracledata';
    protected $fillable = [
    // Other existing fillable attributes
    'ItemBarcode',
    'ItemCode',
    'ItemName',
    'ItemPrice',
    'vendor'
   ];
    
    public $timestamps = false;
}
