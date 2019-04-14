<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Course;
use App\WetLab;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $courses_ids = $user->courses()->get()->map(function ($item) {
            return $item->id;
        })->toArray();
        $coursesList = Course::whereNotIn('id', $courses_ids)->get();
        $wetlabs_ids = $user->wetlabs()->get()->map(function ($item) {
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
        $user = $request->user();
        $request->validate([
            'first_name' => 'required|string|max:191|min:2',
            'last_name' => 'required|string|max:191|min:2',
            'email' => [
                'required',
                Rule::unique('passports')->ignore($user->id),
            ],
        ]);

        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->has('avatar')) {
            $request->validate([
                'avatar' => 'file|max:51200|mimes:jpeg,jpg,png',
            ]);
        }

        if (isset($request->password)) {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            if (Hash::check($request->old_password, $user->password)) {
                $user->password = $request->password;
            }
        }

        if ($user->save()) {
            return back()->with('status', 'Profile updated successfully');
        }

        return back()->with('error', 'Profile not updated!');
    }
}
