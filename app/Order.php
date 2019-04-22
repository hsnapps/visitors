<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'passport_id',
        'subtotal',
        'payment_id',
        'vat',
        'amount',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function passport() {
        return $this->belongsTo(Passport::class);
    }
}
