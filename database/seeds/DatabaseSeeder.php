<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        // Seeding Categories
        $this->call(CategoriesTableSeeder::class);

        // Seeding Passports
        $this->call(PassportsTableSeeder::class);

        // Seeding Courses
        $this->call(CoursesTableSeeder::class);

        // Seeding WetLabs
        $this->call(WetLabsTableSeeder::class);

        // Seeding Bookings
        $this->call(HotelBookingsTableSeeder::class);

        // Generating Sessions
        $this->call(SessionsTableSeeder::class);

        $this->call(CategoriesRelationsshipSeeder::class);

        DB::commit();
    }
}
