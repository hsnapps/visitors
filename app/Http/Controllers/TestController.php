<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
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
            $order->passport_id = $passport->id;
            $order->subtotal = 0;
            $order->payment_id = 0;
            $order->vat = 0;
            $order->amount = 0;
            $order->status = true;
        }
        Mail::to($passport)->send(new TestMail());

        return back()->with('success', 'Email sent successfully!');
    }
}
