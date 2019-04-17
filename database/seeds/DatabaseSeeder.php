<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use App\Passport;
use App\Course;
use App\WetLab;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $passport = Passport::create([
            'title' => 'Phd.',
            'first_name' => 'Hassan',
            'last_name' => 'Baabdullah',
            'work_place' => 'KFAFAH',
            'country' => 'SA',
            'mobile_no' => '966569163852',
            'profession' => 'BCS, PMP',
            'email' => 'prog.hasan@gmail.com',
            'password' => bcrypt('1234'),
        ]);

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

        for ($i=ord('A'); $i < ord('I'); $i++) { 
            WetLab::create([
                'name' => 'WetLab '.chr($i),
                'seats' => rand(200, 2000),
                'starts_on' => $faker->dateTimeBetween('0 years', 'now', 'Asia/Riyadh'),
                'days' => rand(1, 5),
                'price' => 1000,
            ]);
        }

        $course = Course::find(1);

        DB::insert('INSERT INTO course_passport (course_id, passport_id) values (?, ?)', [
            $passport->id,
            $course->id
        ]);
    }
}
