<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(Category:: class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(Category:: class, 'parent_id');
    }

    public function menu_child()
    {
        return $this->hasMany(Category:: class, 'parent_id')->where('is_menu_active', 0);
    }
    
    public function product()
    {
        return $this->hasMany(Product:: class);
    }
}
