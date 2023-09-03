<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStocks extends Model
{
    use HasFactory;

    public function attribute_info() {
        return $this->belongsTo(Variation::class, 'variant', 'id');
    }

    public function color_info() {
        return $this->belongsTo(Colors::class, 'color', 'id');
    }

    public function product_info() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


    

}
