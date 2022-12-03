@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('products.index') }}">
                <button class="btn btn-primary">
                    Back
                </button>
            </a>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">stock</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->description }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$product->image) }}" alt="" width="100px">
                        </td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                </tbody>
            </table>
            <a href="{{ route('products.edit', $product) }}">
                <button class="btn btn-primary">
                    Edit Product
                </button>
            </a>
        </div>
    </div>
</div>
@endsection