<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function testMail(Request $request)
    {
        $passport = $request->user();
        if (Order::count() > 0) {
            $order = Order::first();
        } else {
            $order = new Order();
            $fillable = [
                'passport_id',
                'subtotal',
                'payment_id',
                'vat',
                'amount',
                'status',
            ];
            $order->passport_id = $passport->id;
            $order->subtotal = 0;
            $order->payment_id = 0;
            $order->vat = 0;
            $order->amount = 0;
            $order->status = true;
        }
        Mail::to($passport)->send(new OrderPlaced($order));

        return redirect()->route('home');
    }
}
