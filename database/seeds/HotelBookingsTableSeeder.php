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
        $faker = Faker\Factory::create();

        for ($i=0; $i < 30; $i++) { 
            $days = rand(1, 5);
            HotelBooking::create([
                'days' => $days,
                'price' => $days * 250,
            ]);
        }
    }
}
