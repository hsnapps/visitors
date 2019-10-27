<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\WetLab;

class WetLabsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        
        for ($i=ord('A'); $i < ord('I'); $i++) { 
            WetLab::create([
                'name' => 'WetLab '.chr($i),
                'starts_on' => $faker->dateTimeBetween('0 years', 'now', 'Asia/Riyadh'),
            ]);
        }
    }
}
