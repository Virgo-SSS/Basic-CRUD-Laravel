@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(Auth::user()->isAdmin)
                <a href="{{ route('products.create') }}">
                    <button class="btn btn-primary">
                        Create Product
                    </button>
                </a>
            @endif

            <a href="{{ route('cart.show') }}">
                <button class="btn btn-primary">
                    Carts
                </button>
            </a>

            <a href="{{ route('order.index') }}">
                <button class="btn btn-primary">
                    Orders
                </button>
            </a>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$product->image) }}" alt="" width="100px">
                            </td>
                            <td>
                                <a href="{{ route('products.show', $product) }}">
                                    <button class="btn btn-success">
                                        Detail
                                    </button>
                                </a>
                                |
                              
                                <form action="{{ route('products.delete', $product) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </form>
                                
                                <form action="{{ route('cart.store', $product) }}" method="POST">
                                    @csrf
                                    <input type="number" name="amount" required value="1">
                                    <button type="submit" class="btn btn-info">
                                        Add to Cart
                                    </button>
                                </form>
                                
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection