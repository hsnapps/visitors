<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\WetLab;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $user = auth()->user();
        $courses_ids = $user->courses()->get()->map(function($item) {
            return $item->id;
        })->toArray();
        $coursesList = Course::whereNotIn('id', $courses_ids)->get();        
        $wetlabs_ids = $user->wetlabs()->get()->map(function($item) {
            return $item->id;
        })->toArray();
        $wetlabsList = WetLab::whereNotIn('id', $wetlabs_ids)->get();

        // dd(storage_path('app\\public\\avatars\\empty.png'));
        // dd(file_exists(storage_path('app/public/avatars/empty.png')));

        return view('index', [
            'user' => $user,
            'courses' => $user->courses,
            'wetlabs' => $user->wetlabs,
            'courses_list' => $coursesList,
            'wetlabs_list' => $wetlabsList,
            'cart_count' => $user->cart()->count(),
            'avatar' => $user->avatar(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        dd($request->all());
    }
}
