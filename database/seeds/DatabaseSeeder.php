<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Passport;
use App\Course;
use App\WetLab;
use App\PassportTitle;
use App\HotelBooking;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PassportTitle::create(['name' => 'Phd.']);
        PassportTitle::create(['name' => 'Dr.']);
        PassportTitle::create(['name' => 'Std.']);

        Passport::create([
            'passprt_title_id' => 1,
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

        Passport::create([
            'passprt_title_id' => 2,
            'first_name' => $faker->firstNameMale,
            'last_name' => $faker->lastName,
            'work_place' => $faker->company,
            'country' => 'SA',
            'mobile_no' => $faker->phoneNumber,
            'profession' => $faker->words(2, true),
            'email' => $faker->freeEmail,
            'password' => bcrypt('1234'),
        ]);

        Passport::create([
            'passprt_title_id' => 3,
            'first_name' => $faker->firstNameMale,
            'last_name' => $faker->lastName,
            'work_place' => $faker->company,
            'country' => 'SA',
            'mobile_no' => $faker->phoneNumber,
            'profession' => $faker->words(2, true),
            'email' => $faker->freeEmail,
            'password' => bcrypt('1234'),
        ]);

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

        for ($day=1; $day < 6; $day++) { 
            HotelBooking::create([
                'days' => $day,
                'price' => $day * 250,
            ]);
        }
    }
}
