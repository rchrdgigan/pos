<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionSale extends Model
{
    use HasFactory;

    protected $fillable = ['trans_no', 'user_id', 'total_price','cash', 'change'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sale) {
            $sale->trans_no = 'GDG' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactionSaleItems()
    {
        return $this->hasMany(TransactionSaleItem::class, 'transaction_sale_id');
    }

}
