<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    use HasFactory;

    protected $fillable = ['delivery_id', 'product_id', 'del_price'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function delivery()
    {
        return $this->belongsTo(Delivery::class, 'delivery_id');
    }

    public function quantity()
    {
        return $this->hasOne(ProductQuantity::class, 'delivery_item_id');
    }
}
