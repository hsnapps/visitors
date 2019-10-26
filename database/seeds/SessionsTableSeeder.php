<?php

use App\Session;
use App\WetLab;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wetlabs = WetLab::all();

        foreach ($wetlabs as $wetlab) {
            for ($i=0; $i < 5; $i++) { 
                $start = Carbon::instance($wetlab->starts_on);
                $start->addHours($i + 9);
                $end = Carbon::instance($start);

                Session::create([
                    'name' => sprintf('Session %d', $i + 1),
                    'wetlab_id' => $wetlab->id,
                    'start_time' => $start,
                    'end_time' => $end->addHour(),
                    'seats_available' => rand(1, 4),
                ]);
            }
        }
    }
}
