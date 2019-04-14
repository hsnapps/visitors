<?php

use Illuminate\Database\Seeder;
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
    }
}
