<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\Session;

class WetLabsRule implements Rule
{

    protected $lab = '';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // dd($value);
        $requested_wetlabs = array_keys($value);
        // dd($requested_wetlabs);
        $_sessions = [];
        foreach ($requested_wetlabs as $wetlab_id) {
            $session_id = $value[$wetlab_id][0];
            $session = Session::find($session_id);
            array_push($_sessions, [
                'day' => $session->wetlab->starts_on->format('Y-m-d'),
                'hour' => substr($session->start_time, 0, 5),
            ]);
        }
        $sessions = collect($_sessions);
        $days = $sessions->groupBy('day');
        $hours = $sessions->groupBy(['day', 'hour']);
        if (count($days) != count($hours)) {
            return false;
        }

        $carts = Cart::where('passport_id', Auth::user()->id)->get();
        if ($carts->count() == 0) {
            return true;
        }

        $map = $carts->map(function($item){
                    if ($item->item_type == 'wetlabs') {
                        $s = Session::find($item->item_id);
                        $wl = $s->wetlab;
                        return $wl->name;
                    }
                });

            $_requestedWetLabs = array();
            foreach (array_keys($value) as $id) {
                $wl = Session::find($id)->wetlab->name;
                array_push($_requestedWetLabs, $wl);
            }
            $requestedWetLabs = collect($_requestedWetLabs);
            $count = $map->intersect($requestedWetLabs)->count();
            
            return $count == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return sprintf('Sorry.. You cannot request two sessions in the same WetLab nor in the same time!');
    }
}
