<?php

namespace App\Http\Controllers;

use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = products::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'required',
            'stock' => 'required',
        ]);

        $file = $request->file('image');

        $fileName = time() . '_'. $request->name . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/' . $fileName, file_get_contents($file));

        products::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $fileName,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index');
    }

    public function show(products $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(products $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(products $product,Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'stock' => 'required',
        ]);

        $fileName  = $request->old_image;
        if($request->file('image')){
            $file = $request->file('image');
    
            $fileName = time() . '_'. $request->name . '.' . $file->getClientOriginalExtension();
    
            Storage::disk('local')->put('public/' . $fileName, file_get_contents($file));
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $fileName,
            'stock' => $request->stock,
        ]);

        return redirect()->route('products.index');
    }

    public function delete(products $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
