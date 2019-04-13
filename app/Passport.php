<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Passport extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
        'password', 'remember_token',
    ];

    public function fullName()
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }
}
