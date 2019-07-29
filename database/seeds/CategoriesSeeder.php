<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\WetLab;

class CategoriesSeeder extends Seeder
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

        foreach ($courses as $course) {
            if (time() % 3 == 0) {
                $course->categories()->attach(1);
            }
            if (time() % 2 == 1) {
                $course->categories()->attach(2);
            }
            if (time() % 2 == 0) {
                $course->categories()->attach(3);
            }

            $course->save();
        }

        foreach ($wetLabs as $wetLab) {
            if (time() % 3 == 0) {
                $wetLab->categories()->attach(1);
            }
            if (time() % 2 == 1) {
                $wetLab->categories()->attach(2);
            }
            if (time() % 2 == 0) {
                $wetLab->categories()->attach(3);
            }

            $wetLab->save();
        }
    }
}
