@extends('layouts.master')

@section('title')
	{{ 'Order Complete' . ' | '. env('APP_NAME') }}
@endsection

@php
    $discount = 0;
    if(Session::has('coupon_discount')){
        $discount = Session::get('coupon_discount');
    }
@endphp

@section('style')
    <style type="text/css">
        .checkout input.form-control{
            border: 0.5px solid #000;
        }
    </style>
@endsection


@section('content')

        <!-- Start of Main -->
        <main class="main order">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="passed">Shopping Cart</li>
                        <li class="passed">Checkout</li>
                        <li class="active">Order Complete</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of PageContent -->
            <div class="page-content mb-10 pb-2">
                <div class="container">
                    <div class="order-success text-center font-weight-bolder text-dark">
                        <i class="fas fa-check"></i>
                        Thank you. Your order has been received.
                    </div>
                    <!-- End of Order Success -->

                    <ul class="order-view list-style-none">
                        <li>
                            <label>Order number</label>
                            <strong>{{ $order->code }}</strong>
                        </li>
                        <li>
                            <label>Status</label>
                            {{-- <strong>{{ $order->status->title }}</strong> --}}
                        </li>
                        <li>
                            <label>Date</label>
                            <strong>{{\Carbon\Carbon::parse($order->created_at)->format('d M, Y')}}</strong>
                        </li>
                        <li>
                            <label>Total</label>
                            <strong>{{ env('CURRENCY') }}{{ $order->price }}</strong>
                        </li>
                        <li>
                            <label>Payment Method</label>
                            <strong>{{ $order->payment_method }}</strong>
                        </li>
                    </ul>
                    <!-- End of Order View -->

                    <div class="order-details-wrapper mb-5">
                        <h4 class="title text-uppercase ls-25 mb-5">Order Details</h4>
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th class="text-dark">Product</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->order_product as $product)
                                <tr>
                                    <td>
                                        {{ $product->product->title }}&nbsp;<strong>x {{ $product->qty }}</strong>
                                    </td>
                                    <td>{{ env('CURRENCY') }}{{ $product->price }} {{ env('UAE_CURRENCY') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Subtotal:</th>
                                    <td>{{ env('CURRENCY') }} {{ $order->price }} {{ env('UAE_CURRENCY') }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping:</th>
                                    <td>{{ $order->delivery_charge == NULL ? 0 : $order->delivery_charge }} {{ env('UAE_CURRENCY') }}</td>
                                </tr>
                                <tr>
                                    <th>Payment method:</th>
                                    <td>{{ $order->payment_method }}</td>
                                </tr>
                                <tr class="total">
                                    <th class="border-no">Total:</th>
                                    <td class="border-no">{{ env('CURRENCY') }} {{ $order->price + $order->shipping_charge }} {{ env('UAE_CURRENCY') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- End of Order Details -->
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->
	

@endsection

        