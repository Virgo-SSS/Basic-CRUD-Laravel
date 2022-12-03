@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="{{ route('products.index') }}">
                <button class="btn btn-primary">
                    back
                </button>
            </a>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_price = 0;
                    @endphp
                    @foreach ($carts as $cart)
                        @php
                            $total_price += $cart->product->price * $cart->amount;
                        @endphp
                        <tr>
                            <td>{{ $cart->product->name }}</td>
                            <td>
                                <img src="{{ asset('storage/'.$cart->product->image) }}" alt="" width="100px">
                            </td>
                            <td>{{ $cart->amount }}</td>
                            <td>{{ $cart->product->price * $cart->amount; }}</td>
                            <td>
                                <form action="{{ route('cart.delete', $cart) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </form>
                                <form action="{{ route('cart.update', $cart) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" value="{{ $cart->amount }}" name="amount" required>
                                    <button type="submit" class="btn btn-info">
                                        update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <h3>Total Price = {{ $total_price }}</h3>
            @if($carts != '[]')
                <form action="{{ route('order.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        Checkout
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection