<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsReviews extends Model
{
    use HasFactory;

    public function customer_info() {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    public function product_info() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    


}
