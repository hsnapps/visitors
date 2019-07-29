<?php

use Illuminate\Database\Seeder;
use App\HotelBooking;

class HotelBookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($day=1; $day < 6; $day++) { 
            HotelBooking::create([
                'days' => $day,
                'price' => $day * 250,
            ]);
        }
    }
}
