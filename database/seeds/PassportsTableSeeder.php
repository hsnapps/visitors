<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Passport;

class PassportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Passport::create([
            'category_id' => 1,
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
            'category_id' => 2,
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
            'category_id' => 3,
            'first_name' => $faker->firstNameMale,
            'last_name' => $faker->lastName,
            'work_place' => $faker->company,
            'country' => 'SA',
            'mobile_no' => $faker->phoneNumber,
            'profession' => $faker->words(2, true),
            'email' => $faker->freeEmail,
            'password' => bcrypt('1234'),
        ]);
    }
}
