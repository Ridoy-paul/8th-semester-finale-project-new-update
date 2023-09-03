<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleOffer extends Model
{
    use HasFactory;

    public function products() {
        return $this->hasMany(FlashSaleOfferProducts::class, 'flash_sale_id', 'id');
    }


}
