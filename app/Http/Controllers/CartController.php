<?php

namespace App\Http\Controllers;

use App\Models\carts;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(products $products, Request $request)
    {
        
        $carts = carts::where('product_id', $products->id)->where('user_id', Auth::id())->first();
        if($carts){
            $request->validate([
                'amount' => 'required|gte:1|lte:'. ($products->stock - $carts->amount)
            ]);

            $carts->update([
                'amount' => $carts->amount + $request->amount
            ]);

        } else {
            $request->validate([
                'amount' => 'required|gte:1|lte:'. $products->stock
            ]);

            $user = Auth::id();
            $product = $products->id;
    
            carts::create([
                'user_id' => $user,
                'product_id' => $product,
                'amount' => $request->amount,
            ]);
        }

     

        return redirect()->route('products.index');
    }

    public function show()
    {
        $user = Auth::id();
        $carts = carts::with(['user','product'])->where('user_id', $user)->get();

        return view('cart.show', compact('carts'));
    }

    public function update(carts $carts, Request $request)
    {
        $request->validate([
            'amount' => 'required|gte:1|lte:'. $carts->product->stock
        ]);

        $carts->update([
            'amount' => $request->amount,
        ]);

        return redirect()->route('cart.show');
    }

    public function delete(carts $carts)
    {
        $carts->delete();

        return redirect()->route('cart.show');
    }
}
