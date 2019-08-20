<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Code\Tools;
use App\Course;
use App\WetLab;
use App\Cart;
use App\Payment;
use App\Order;
use App\OrderItem;
use App\Mail\OrderPlaced;
use App\HotelBooking;
use App\Room;

class HomeController extends Controller
{
    const CATEGORY = 1;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        // Check cart date validty
        // -------------------------------
        $this->deleteExpiredItems($user);
        // -------------------------------

        $courses_ids = $user->courses()->get()->map(function ($item) { return $item->id; })->toArray();
        $coursesList = $user->category->courses()->whereNotIn('id', $courses_ids)->whereDate('starts_on', '>', today()->subDay())->get();
        $wetlabs_ids = $user->wetlabs()->get()->map(function ($item) { return $item->id; })->toArray();
        $wetlabsList = $user->category->wetLabs()->whereNotIn('id', $wetlabs_ids)->whereDate('starts_on', '>', today()->subDay())->get();
        $bookingList = HotelBooking::where('room_id', self::CATEGORY)->get();

        return view('index', [
            'user' => $user,
            'courses' => $user->courses,
            'wetlabs' => $user->wetlabs,
            'bookings' => $user->hotelBookings,

            'courses_list' => $coursesList,            
            'wetlabs_list' => $wetlabsList,
            'bookings_list' => $bookingList,

            'cart_count' => $user->cart()->count(),
            'availableRooms' => Room::find(self::CATEGORY)->count,
            // 'avatar' => $user->getAvatar(),
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

        // $user->category = $request->title;
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
                $fileName = Tools::generateRandomString(20);
                $avatar->storeAs($dir, $fileName.'.png');
                Storage::delete(sprintf('avatars/%s.png', $user->avatar));
                $user->avatar = $fileName;
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
                $bookingExists = Cart::where([
                    'passport_id' => $request->user()->id,
                    'item_type' => $request->item_type,
                    'item_id' => $item,
                ])->first();

                if ($bookingExists) {
                    return back()->with('status', 'You\'ve already added a booking in the cart!');
                }

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
            $courseExists = Cart::where([
                'passport_id' => $request->user()->id,
                'item_type' => $request->item_type,
                'item_id' => $item,
            ])->first();
            if ($courseExists) {
                continue;
            }

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
        $currency = env('CURRENCY');
        $_amount = str_replace(',', '', $request->amount);
        $__amount = $_amount / env('CURRENCY_RATE');
        $amount = round($__amount, 2);
        $ssl = !env('APP_DEBUG');

        // 1. Prepare the checkout
        $debug = env('APP_DEBUG');
        if ($debug) {
            $url = "https://test.oppwa.com/v1/checkouts";
            $data = "entityId=8a8294174d0595bb014d05d82e5b01d2".
                    "&amount=$request->amount".
                    "&currency=EUR".
                    "&paymentType=DB";
        } else {
            $url = 'https://oppwa.com/v1/checkouts';
            $data = 'authentication.userId=8ac9a4ca6561110c01657c8a9c8b629a' .
                '&authentication.password=qfERPN7gAA' . 
                '&authentication.entityId=8ac9a4ca6561110c01657c8adde4629e' . 
                '&amount='.$amount .
                '&currency='.$currency .
                '&merchantTransactionId='.$passport->id .
                '&customer.merchantCustomerId='.$passport->id .
                '&customer.email='.$passport->email .
                '&customer.givenName='.$passport->first_name .
                '&customer.surname='.$passport->last_name .
                '&paymentType=CD' .
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        // dd($responseData);
        
        $response = json_decode($responseData);
        if (isset($response->id)) {
            // logger($responseData);
            
            return view('payment', [
                // 'script_url' => $script_url,
                'checkoutId' => $response->id, 
                'currency' => env('CURRENCY'),
                'amount_formated' => number_format($amount, 2 , '.', ','),
                'amount' => $amount,
            ]);
        }

        if (isset($response)) {
            if (isset($response->result)) {
                logger(json_encode($response->result));
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
        // $entityId = env('HYPERPAY_ENTITY_ID');
        // $userId = env('HYPERPAY_USER_ID');
        // $password = env('qfERPN7gAA');
        $successValue = '000.000.000';
        $pattern = env('MATCH');
        $order = null;
        $ssl = !env('APP_DEBUG');
        // $checkoutId = $request->id;

        // dd($request->all());

        $debug = env('APP_DEBUG');
        if ($debug) {
            // $successValue = '000.100.112';
            // $url = 'https://test.oppwa.com/'.$request->resourcePath;
            $url = 'https://test.oppwa.com'.$request->resourcePath.'?authentication.entityId=8a8294174d0595bb014d05d82e5b01d2';
        } else {
            $url = 'https://oppwa.com/'.$request->resourcePath;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if($debug) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer OGE4Mjk0MTc0ZDA1OTViYjAxNGQwNWQ4MjllNzAxZDF8OVRuSlBjMm45aA=='));
        }
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl);
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

        if (preg_match($pattern, $response->result->code)) {
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
                    $hotelBooking = HotelBooking::find($cart->item_id);
                    $room = Room::find($hotelBooking->room_id);
                    $room->count -= 1;
                    $room->save();
                    $passport->hotelBookings()->attach($cart->item_id);
                }
            }

            $passport->cart()->delete();

            DB::commit();

            Mail::to($passport)->send(new OrderPlaced($order));
        } else {
            Payment::create([
                'passport_id' => $passport->id,
                'amount' => isset($response->amount) ? $response->amount : 0,
                'online' => true,
                'card_type' => isset($response->paymentBrand) ? $response->paymentBrand : 'N/A',
                'card_holder' => isset($response->card) ?  $response->card->holder : 'N/A',
                'card_expiration' => isset($response->card) ? sprintf('%s-%s', $response->card->expiryMonth, $response->card->expiryYear) : 'N/A',
                'card_last_4' =>  isset($response->card) ? $response->card->last4Digits : 'N/A',
                'currency' => isset($response->currency) ? $response->currency : 'N/A',
                'payment_result_id' => isset($response->id) ? $response->id : 'N/A',
                'payment_result_code' => $response->result->code,
                'payment_result_description' => $response->result->description,
            ]);
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

    private function deleteExpiredItems($user)
    {
        $deleteItems = array();
        foreach ($user->cart as $cart) {
            $hours = today()->diffInHours($cart->created_at);
            $expired = $hours > env('EXPIRATION_HOURS');
            if ($expired) {
                array_push($deleteItems, $cart->id);
            }
        }
        Cart::destroy($deleteItems);
    }
}
