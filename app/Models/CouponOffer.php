<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponOffer extends Model
{
    use HasFactory;
    public function offerCategory()
    {
        return $this->belongsTo('App\Models\OfferCategory','offer_categories_id');
    }
}
