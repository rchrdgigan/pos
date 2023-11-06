<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = ['tracking_no', 'supplier_id', 'total_price'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($delivery) {
            $delivery->tracking_no = 'TXN' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function deliveryItems()
    {
        return $this->hasMany(DeliveryItem::class, 'delivery_id');
    }

    public function calculateTotalPrice()
    {
        $totalPrice = $this->deliveryItems->sum(function ($item) {
            return $item->del_qty * $item->del_price;
        });

        $this->total_price = $totalPrice;
        $this->save();
    }
}
