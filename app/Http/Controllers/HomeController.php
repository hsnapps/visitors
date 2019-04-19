<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Course;
use App\WetLab;
use App\Cart;
use App\Payment;
use App\Order;

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

        $passport = $request->user();
        if(!isset($order)) {
            $order = Order::where([
                    'passport_id' => $passport->id,
                    'amount' => $request->amount,
                    'status' => false,
                ])->orderByDesc('created_at')
                ->first();
            if (!isset($order)) {
                $order = Order::create([
                    'passport_id' => $passport->id,
                    'subtotal' => $request->subtotal,
                    'checkout_id' => null,
                    'vat' => $request->vat,
                    'amount' => $request->amount,
                    'status' => false,
                ]);
                session(['order' => $order]);
            } else {
                session(['order' => $order]);
            }
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

        return view('cc_payment', [
            'currency' => env('CURRENCY'),
            'amount_formated' => number_format($request->amount, 2 , '.', ','),
            'amount' => $request->amount,
            'months' => $months,
            'years' => $years,
            'subtotal' => $request->subtotal,
            'vat' => $request->vat,
        ]);
    }

    public function renderPaymentForm(Request $request) {
        $url = 'https://oppwa.com/v1/checkouts';
        $passport = $request->user();
        $data = 'authentication.userId=8ac9a4ca6561110c01657c8a9c8b629a' .
                '&authentication.password=qfERPN7gAA' .
                '&authentication.entityId=8ac9a4ca6561110c01657c8adde4629e' .
                '&amount='.$request->amount .
                '&currency=SAR' .
                '&merchantTransactionId='.$passport->id .
                '&customer.merchantCustomerId='.$passport->id .
                '&customer.email='.$passport->email .
                '&customer.givenName='.$passport->first_name .
                '&customer.surname='.$passport->last_name .
                '&paymentType=DB' .
                '&billing.country='.$passport->country .
                '&billing.city='.$passport->country .
                '&billing.street1='.$passport->country;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        
        $response = json_decode($responseData);
        logger($responseData);
        if (isset($response->id)) {
            return view('payment', [
                'checkoutId' => $response->id, 
                'currency' => 'SAR',
                'amount_formated' => number_format($request->amount, 2 , '.', ','),
                'amount' => $request->amount,
            ]);
        }

        if (isset($response)) {
            if (isset($response->result)) {
                return back()->with('error', sprintf('%s : %s', $response->result->code, $response->result->description));   
            }
        }

        if (starts_with($responseData, '<!DOCTYPE HTML PUBLIC')) {
            return $responseData;
        }

        return back()->with('error', $responseData);   
    }

    public function paymentStatus(Request $request)
    {
        $passport = $request->user();
        $entityId = '8ac9a4ca6561110c01657c8adde4629e';
        $userId = '8ac9a4ca6561110c01657c8a9c8b629a';
        $password = 'qfERPN7gAA';

        $url = 'https://oppwa.com'.$request->resourcePath;
        $url .= "?authentication.userId=$userId";
        $url .=	"&authentication.password=$password";
        $url .=	"&authentication.entityId=$entityId";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData);

        logger($responseData);

        if ($response->result->code == '000.000.000') {
            DB::beginTransaction();

            Payment::create([
                'passport_id' => $passport->id,
                'amount' => $response->amount,
                'online' => true,
                'card_type' => $response->paymentBrand,
                'card_holder' => $response->card->holder,
                'card_expiration' => sprintf('%s-%s', $response->card->expiryMonth, $response->card->expiryYear),
                'card_last_4' => $response->card->last4Digits,
                'currency' => $response->currency,
                'payment_result_id' => $response->id,
                'payment_result_code' => $response->result->code,
                'payment_result_description' => $response->result->description,
            ]);

            foreach ($passport->cart as $cart) {
                if ($cart->item_type == 'courses') {
                    $course = Course::find($cart->item_id);
                    $course->seats = $course->seats - 1;
                    $course->save();
                }

                if ($cart->item_type == 'wetlabs') {
                    $course = WetLab::find($cart->item_id);
                    $course->seats = $course->seats - 1;
                    $course->save();
                }
            }

            $passport->cart()->delete();

            DB::commit();
        }
        
        return view('receipt', [
            'code' => $response->result->code,
            'description' => $response->result->description,
        ]);
    }
}
