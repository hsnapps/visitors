<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Passport extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'admin_id',
        'category_id',
        'first_name',
        'middle_name',
        'last_name',
        'work_place',
        'country',
        'bar_code',
        'code',
        'amount',
        'mobile_no',
        'profession',
        'specialist',
        'sfch_number',
        'sfch_image',
        'bank_recipt',
        'email',
        'expire_date',
        'approve',
        'payment',
        'conference_reg',
        'wet_lab_reg',
        'type_of_payment',
        'status',
        'avatar'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fullName()
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    public function getAvatar()
    {
        $path = public_path('avatars/' . $this->avatar . '.png');
        if (file_exists($path)) {
            return url('avatars/' . $this->avatar . '.png');
        }
        return url('avatars/empty.png');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function wetlabs()
    {
        return $this->belongsToMany(WetLab::class, 'passport_wetlab', 'passport_id', 'wetlab_id');
    }

    public function hotelBookings()
    {
        return $this->belongsToMany(HotelBooking::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
