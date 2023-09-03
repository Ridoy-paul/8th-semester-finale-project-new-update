<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function status()
    {
    	return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function order_product()
    {
    	return $this->hasMany(OrderProduct::class, 'order_code', 'code');
    }

    public function customer()
    {
    	return $this->belongsTo(User::class, 'customer_id');
    }

    public function district_info()
    {
    	return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function district_area_info()
    {
    	return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function order_transaction_info()
    {
    	return $this->belongsTo(Transactions::class, 'code', 'tran_id');
    }

    

    

    



}
