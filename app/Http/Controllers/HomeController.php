<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
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
            return back()->with('success', 'Profile updated successfully');
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

        return back()->with('success', title_case($request->item_type).' added to the cart');
    }

    public function removeCourseFromCart(Request $request)
    {
        Cart::destroy($request->id);
        return back();
    }

    public function showPaymentForm(Request $request)
    {
        if ($request->isMethod('get')) {
            return redirect()->route('cart');
        }

        $months = array();
        for ($i=1; $i < 13; $i++) { 
            $dt = Carbon::parse("2019-$i-01");
            $shortName = $dt->shortEnglishMonth;
            $month = sprintf('%s (%d)', $shortName, $i);
            array_push($months, $month);
        }

        $years = array();
        $year = now()->year;
        for ($i=0; $i < 10; $i++) { 
            array_push($years, $year);
            $year++;
        }

        return view('payment', [
            'currency' => env('CURRENCY'),
            'amount_formated' => number_format($request->amount, 2 , '.', ','),
            'amount' => $request->amount,
            'months' => $months,
            'years' => $years,
        ]);
    }

    public function pay(Request $request)
    {
        $url = env('OPPWA_CHECKOUT_URL');
        $entityId = env('OPPWA_ENTITYID');
        $userId = env('OPPWA_USER_ID');
        $password = env('OPPWA_PASSWORD');
        $currency = env('CURRENCY');

        $amount  =  $request->amount;
        $cardType = $request->cardType;
        $paymentType = '';
        $cardNo    = $request->card_number;
        $cardHolder = $request->card_holder_name;
        $cardExpiryMonth = str_pad($request->expiry_month, 2, '0', STR_PAD_LEFT);
        $cardExpiryYear = $request->expiry_year;
        $cvv = $request->cvv;
        $shopperResultUrl = route('payment-result');

	    $data = "authentication.userId=$userId" .
            "&authentication.password=$password" .
            "&authentication.entityId=$entityId" .
            "&amount=$amount" .
            "&currency=$currency" .
            "&paymentBrand=$cardType" .
            "&paymentType=$paymentType" .
            "&card.number=$cardNo" .
            "&card.holder=$cardHolder" .
            "&card.expiryMonth=$cardExpiryMonth" .
            "&card.expiryYear=$cardExpiryYear" .
            "&card.cvv=$cvv".
            "&shopperResultUrl=$shopperResultUrl";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);

        if(curl_errno($ch)) {
            return back()->with('error', curl_error($ch));
        }
        
        curl_close($ch);
        $response = json_decode($responseData);  
        dd($response);
        return redirect()->route('home')->with('status', 'Thank You for payment Oppwa');
    }

    public function paymentStatus(Request $request)
    {
        dd($request->all());
    }
}
