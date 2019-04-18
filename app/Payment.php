<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'passport_id',
        'order_id',
        'amount',
        'online',
        'card_type',
        'card_holder',
        'card_expiration',
        'card_last_4',
        'currency',
        'payment_result_id',
        'payment_result_code',
        'payment_result_description',
     ];
}
