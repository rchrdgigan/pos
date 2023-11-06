<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSaleItem extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_sale_id', 'product_id', 'sal_discount', 'sal_price', 'sal_subtotal', 'sal_totalprice'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function transactionSale()
    {
        return $this->belongsTo(TransactionSale::class, 'transaction_sale_id');
    }

    public function quantity()
    {
        return $this->hasOne(ProductQuantity::class, 'sale_item_id');
    }
}
