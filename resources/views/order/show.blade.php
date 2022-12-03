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

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Detail</th>
                        <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @php
                            $price = 0;
                        @endphp
                        <th scope="row">{{ $order->id }}</th>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                            @foreach ($order->transcation as $orderDetail)
                                <p>Product : {{ $orderDetail->product->name }}</p>
                                <p>Quantity : {{ $orderDetail->amount }}</p>
                                <p>Price : {{ $orderDetail->product->price }}</p>
                                @php
                                    $price += $orderDetail->product->price * $orderDetail->amount;
                                @endphp
                            @endforeach
                        </td>
                        <td>
                            {{ $price }}
                        </td>
                    </tr>
                </tbody>
            </table>
            @if(!$order->payment_receipt || $order->payment_receipt == 'bca' )
                <form action="{{ route('order.payment', $order) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <input type="file" name="payment_receipt" required>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            @elseif(!$order->isPaid)
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                    Show Payment Receipt
                </button>
                @if(Auth::user()->isAdmin)
                    <a href="{{ route('order.confirm_payment', $order) }}">
                        <button class="btn btn-success">
                            Confirm Payment
                        </button>
                    </a>
                @endif
            @else
                <h3>Sukses</h3>
            @endif
        </div>
    </div>
 
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-body">
            <img src="{{ asset('storage/payment/'.$order->payment_receipt) }}" alt="" width="100%">
        </div>
        </div>
    </div>
</div>
@endsection