<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'passport_id',
        'item_type',
        'item_id',
        'expiration_date',
        'title',
        'starts_on',
        'price',
        'days'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expiration_date',
        'starts_on',
    ];

    /**
     * Get the passprot that owns the cart.
     */
    public function passprot()
    {
        return $this->belongsTo(Passport::class);
    }
}
