<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Doctors']);
        Category::create(['name' => 'Nurses']);
        Category::create(['name' => 'Students']);
        Category::create(['name' => 'Academics']);
    }
}
