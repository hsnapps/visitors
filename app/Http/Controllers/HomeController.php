<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Course;
use App\WetLab;
use App\Cart;

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

        // Avatar
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'file|max:51200|mimes:jpeg,jpg,png',
            ]);
            $avatar = $request->file('avatar');
            if ($avatar->isValid()) {
                $dir = 'public/avatars';
                //dd($dir);
                $avatar->storeAs($dir, $user->id.'.png');
            }
        }

        // Password
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

    public function addCourseToCart(Request $request)
    {
        foreach ($request->courses as $item) {
            $course = Course::findOrFail($item);

            Cart::create([
                'passport_id' => $request->user()->id,
                'item_type' => $request->item_type,
                'item_id' => $course->id,
                'expiration_date' => today()->addHours(env('EXPIRATION_DATE', 48)),
                'title' => $course->name,
                'starts_on' => $course->starts_on,
                'price' => $course->price,
                'days' => $course->days,
            ]);   
        }

        return back()->with('status', title_case($request->item_type).' added to the cart');
    }

    public function removeCourseFromCart(Request $request)
    {
        Cart::destroy($request->id);
        return back();
    }

    public function preparePayment(Request $request)
    {
        $entityId = env('OPPWA_ENTITYID');
        $currency = env('CURRENCY');
        $amount = $request->amount;
        $url = env('OPPWA_CHECKOUT_URL');
        $data = "entityId=$entityId" .
                    "&amount=$amount" .
                    "&currency=$currency" .
                    "&paymentType=DB";
        $token = env('OPPWA_AUTH_TOKEN');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization:Bearer $token"));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        
        if(curl_errno($ch)) {
            // return curl_error($ch);
            return back()->with('error', curl_error($ch));
        }
        curl_close($ch);

        $response = json_decode($responseData);

        return redirect()->route('payment-form', ['checkoutId' => $response->id]);
    }

    public function showPaymentForm($checkoutId)
    {
        return view('payment', [
            'script_src' => env('OPPWA_PAYMENT_SCRIPT').$checkoutId,
            'checkoutId' => $checkoutId,
        ]);
    }

    public function paymentStatus(Request $request)
    {
        dd($request->all());

        $entityId = env('OPPWA_ENTITYID');
        $resourcePath = $request->resourcePath;
        $result_URL = env('OPPWA_RESULT_URL');
        $url = str_replace('<id>', '');
        $token = env('OPPWA_AUTH_TOKEN');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData);

        return view('payment', [
            'checkoutId' => $response->id
        ]);
    }
}
