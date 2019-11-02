<?php

namespace App\Code;

use App\Course;
use Carbon\Carbon;

class Tools
{
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function attachCourses() 
    {
        $courses = Course::where('id', '>', 8)->get();

        foreach ($courses as $course) {
            $course->categories()->attach(1);
        }

        return 'DONE!';
    }

    public static function setCourseStart()
    {
        $times = [
            '9' => '2019-11-21 00:00:00',
            '10' => '2019-07-29 02:25:32',
            '11' => '2019-11-20 08:30:00',
            '12' => '2019-11-20 08:30:00',
            '13' => '2019-11-20 10:30:00',
            '14' => '2019-11-20 10:30:00',
            '15' => '2019-11-20 13:30:00',
            '16' => '2019-11-20 13:30:00',
            '17' => '2019-11-20 16:00:00',
            '18' => '2019-11-20 16:00:00',
            '19' => '2019-11-21 08:00:00',
            '20' => '2019-11-21 10:30:00',
            '21' => '2019-11-21 14:00:00',
            '22' => '2019-11-21 16:00:00',
            '23' => '2019-11-22 08:30:00',
            '24' => '2019-11-22 08:30:00',
            '25' => '2019-11-22 08:30:00',
            '26' => '2019-11-22 10:30:00',
            '27' => '2019-11-22 10:30:00',
            '28' => '2019-11-22 14:00:00',
            '29' => '2019-11-22 14:50:00',
            '30' => '2019-11-22 16:00:00',
            '31' => '2019-11-21 08:30:00',
        ];

        foreach ($times as $key => $value) {
            $course = Course::find($key);
            $course->starts_on = new Carbon($value);
            $course->save();
        }

        return 'DONE!';
    }
}
