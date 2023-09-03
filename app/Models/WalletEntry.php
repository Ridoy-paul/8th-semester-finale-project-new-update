<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletEntry extends Model
{
    use HasFactory;

    public function wallet()
    {
    	return $this->belongsTo(Waller::class);
    }
}
