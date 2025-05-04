<?php

namespace App\Models;

use App\Models\backend\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;

    function product(){
        return $this->belongsTo(Product::class);
    }
}
