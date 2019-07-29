<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Course;
use App\WetLab;
use App\Cart;
use App\Payment;
use App\Order;
use App\OrderItem;
use App\Mail\OrderPlaced;
use App\HotelBooking;

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
        $courses_ids = $user->courses()->get()->map(function ($item) { return $item->id; })->toArray();
        $coursesList = $user->passportTitle->courses()->whereNotIn('id', $courses_ids)->whereDate('starts_on', '>', today()->subDay())->get();
        $wetlabs_ids = $user->wetlabs()->get()->map(function ($item) { return $item->id; })->toArray();
        $wetlabsList = $user->passportTitle->wetLabs()->whereNotIn('id', $wetlabs_ids)->whereDate('starts_on', '>', today()->subDay())->get();
        $bookingList = HotelBooking::all();

        return view('index', [
            'user' => $user,
            'courses' => $user->courses,
            'wetlabs' => $user->wetlabs,
            'bookings' => $user->hotelBookings,

            'courses_list' => $coursesList,            
            'wetlabs_list' => $wetlabsList,
            'bookings_list' => $bookingList,

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

        $user->passprt_title_id = $request->title;
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
                $dir = 'avatars';
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
        // dd($request->all());

        if ($request->item_type == 'booking') {
            foreach ($request->bookings as $item) {
                $booking = HotelBooking::findOrFail($item);
                Cart::create([
                    'passport_id' => $request->user()->id,
                    'item_type' => $request->item_type,
                    'item_id' => $booking->id,
                    'expiration_date' => today()->addHours(env('EXPIRATION_DATE', 48)),
                    'title' => sprintf('%d Days', $booking->days),
                    'starts_on' => null,
                    'price' => $booking->price,
                    'days' => $booking->days,
                ]);

                return back()->with('success', title_case($request->item_type).' added to the cart');
            }
        }

        foreach ($request->courses as $item) {
            if ($request->item_type == 'courses') {
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
            
            if ($request->item_type == 'wetlabs') {
                $wetlab = WetLab::findOrFail($item);
                Cart::create([
                    'passport_id' => $request->user()->id,
                    'item_type' => $request->item_type,
                    'item_id' => $wetlab->id,
                    'expiration_date' => today()->addHours(env('EXPIRATION_DATE', 48)),
                    'title' => $wetlab->name,
                    'starts_on' => $wetlab->starts_on,
                    'price' => $wetlab->price,
                    'days' => $wetlab->days,
                ]);
            }
        }

        return back()->with('success', title_case($request->item_type).' added to the cart');
    }

    public function removeCourseFromCart(Request $request)
    {
        Cart::destroy($request->id);
        return back();
    }

    public function renderPaymentForm(Request $request) 
    {
        $passport = $request->user();

        $amount = str_replace(',', '', $request->amount);

        $debug = env('APP_DEBUG');
        if ($debug) {
            $url = "https://test.oppwa.com/v1/checkouts";
            $data = "entityId=8a8294174d0595bb014d05d82e5b01d2".
                    "&amount=$amount".
                    "&currency=EUR".
                    "&paymentType=DB";
        } else {
            $url = 'https://oppwa.com/v1/checkouts';
            $data = 'authentication.userId=8ac9a4ca6561110c01657c8a9c8b629a' .
                '&authentication.password=qfERPN7gAA' .
                '&authentication.entityId=8ac9a4ca6561110c01657c8adde4629e' .
                '&amount='.$amount .
                '&currency='.env('CURRENCY') .
                '&merchantTransactionId='.$passport->id .
                '&customer.merchantCustomerId='.$passport->id .
                '&customer.email='.$passport->email .
                '&customer.givenName='.$passport->first_name .
                '&customer.surname='.$passport->last_name .
                '&paymentType=DB' .
                '&billing.country='.$passport->country .
                '&billing.city='.$passport->country .
                '&billing.street1='.$passport->country;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        if ($debug) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        
        $response = json_decode($responseData);
        if (isset($response->id)) {
            return view('payment', [
                'checkoutId' => $response->id, 
                'currency' => env('CURRENCY'),
                'amount_formated' => number_format($amount, 2 , '.', ','),
                'amount' => $amount,
            ]);
        }

        if (isset($response)) {
            if (isset($response->result)) {
                // dd($response->result);
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
        $successValue = '000.000.000';
        $order = null;

        $debug = env('APP_DEBUG');
        if ($debug) {
            $successValue = '000.100.110';
            $url = 'https://test.oppwa.com'.$request->resourcePath.'?authentication.entityId=8a8294174d0595bb014d05d82e5b01d2';
        } else {
            $url = 'https://oppwa.com'.$request->resourcePath;
            $url .= "?authentication.userId=$userId";
            $url .=	"&authentication.password=$password";
            $url .=	"&authentication.entityId=$entityId";
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if($debug) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData);

        if($debug) {
            logger($responseData);
        }

        if ($response->result->code == $successValue) {
            DB::beginTransaction();

            $subtotal = $passport->cart->sum('price');

            $payment = Payment::create([
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

            $order = Order::create([
                'passport_id' => $passport->id,
                'payment_id' => $payment->id,
                'subtotal' => $subtotal,
                'vat' => ($subtotal * env('VAT')),
                'amount' => $response->amount,
                'status' => true,
            ]);

            foreach ($passport->cart as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => $cart->item_type,
                    'item_name' => $cart->title,
                    'item_id' => $cart->item_id,
                    'item_price' => $cart->price,
                ]);

                if ($cart->item_type == 'courses') {
                    $course = Course::find($cart->item_id);
                    $course->seats = $course->seats - 1;
                    $course->save();

                    $passport->courses()->attach($cart->item_id);
                }

                if ($cart->item_type == 'wetlabs') {
                    $course = WetLab::find($cart->item_id);
                    $course->seats = $course->seats - 1;
                    $course->save();

                    $passport->wetlabs()->attach($cart->item_id);
                }

                if ($cart->item_type == 'booking') {
                    $passport->hotelBookings()->attach($cart->item_id);
                }
            }

            $passport->cart()->delete();

            DB::commit();

            Mail::to($passport)->send(new OrderPlaced($order));
        }
        
        return view('receipt', [
            'order' => $order,
            'success_value' => $successValue,
            'code' => $response->result->code,
            'description' => $response->result->description,
        ]);
    }

    public function printOrder(Order $order)
    {
        $passport = auth()->user();
        abort_if(!$passport->orders->contains($order), 403);
        return view('invoice', ['order' => $order]);
    }

    public function listOrders()
    {
        $passport = auth()->user();
        return view('orders', ['orders' => $passport->orders()->paginate(env('PAGE'))]);
    }
}
