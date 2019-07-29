<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\WetLab;

class CourseesDatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::all();
        $wetLabs = WetLab::all();
        $faker = Faker\Factory::create();

        foreach ($courses as $course) {
            $course->starts_on = $faker->dateTimeBetween('now', '+18 months');
            $course->save();
        }

        foreach ($wetLabs as $wetLab) {
            $wetLab->starts_on = $faker->dateTimeBetween('now', '+18 months');
            $wetLab->save();
        }
    }
}
