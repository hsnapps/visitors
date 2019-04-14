<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Course;

class CoursesTableSeeder extends Seeder
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
            Course::create([
                'name' => 'Course '.chr($i),
                'seats' => rand(200, 2000),
                'starts_on' => $faker->dateTimeBetween('0 years', 'now', 'Asia/Riyadh'),
                'days' => rand(1, 5),
                'price' => 1000,
            ]);
        }
    }
}
