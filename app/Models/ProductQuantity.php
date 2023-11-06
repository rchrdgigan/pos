<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuantity extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sale_item_id', 'delivery_item_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
