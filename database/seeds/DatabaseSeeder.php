<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PassportsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(WerLabsTableSeeder::class);
    }
}
