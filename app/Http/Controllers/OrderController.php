<?php

namespace App\Http\Controllers;

use App\Models\carts;
use App\Models\orders;
use App\Models\products;
use App\Models\Transcation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if($user->isAdmin){
            $orders = orders::with(['user','transcation'])->get();
        }
        else{
            $orders = orders::with(['user','transcation'])->where('user_id', $user->id)->get();
        }


        return view('order.index', compact('orders'));
    }

    public function checkout()
    {
        $carts = carts::where('user_id', Auth::user()->id)->get();

        if(!$carts){
            return redirect()->route('products.index');
        }

        $order = orders::create([
            'user_id' => Auth::user()->id,
            'isPaid' => false,
            'payment_receipt' => 'bca',
        ]);

        foreach($carts as $cart){
            products::find($cart->product_id)->decrement('stock', $cart->amount);


            Transcation::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'amount' => $cart->amount,
            ]);

            $cart->delete();
        }

        return redirect()->route('products.index');
    }

    public function show(orders $order)
    {

        if($order->user_id == Auth::user()->id || Auth::user()->isAdmin){
            return view('order.show', compact('order'));
        }
        
        return redirect()->route('products.index');
    }

    public function payment(orders $order, Request $request)
    {
        $request->validate([
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $file = $request->file('payment_receipt');

        $fileName = time() . '_'. $order->id . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/payment/' . $fileName, file_get_contents($file));

        $order->update([
            'payment_receipt' => $fileName,
        ]);

        return redirect()->route('order.index');
    }

    public function confirm_payment(orders $order)
    {
        $order->update([
            'isPaid' => true,
        ]);

        return redirect()->route('order.index');
    }
}
