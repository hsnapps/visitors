<?php

use Illuminate\Database\Seeder;

class CategoriesRelationsshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minCat = App\Category::min('id');
        $maxCat = App\Category::max('id');

        foreach (App\Course::all() as $course) {
            $cat_id = rand($minCat, $maxCat);
            $cat = App\Category::find($cat_id);
            $cat->courses()->attach($course->id);
        }

        foreach (App\WetLab::all() as $wetlab) {
            $cat_id = rand($minCat, $maxCat);
            $cat = App\Category::find($cat_id);
            $cat->wetLabs()->attach($wetlab->id);
        }
    }
}
