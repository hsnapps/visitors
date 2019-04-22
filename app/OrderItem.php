<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'item_type',
        'item_name',
        'item_id',
        'item_price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
