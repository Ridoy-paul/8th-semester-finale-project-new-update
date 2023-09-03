@extends('layouts.master')

@section('title')
	{{ 'Shopping Cart' . ' | '. env('APP_NAME') }}
@endsection

@php
    $discount = 0;
    if(Session::has('coupon_discount')){
        $discount = Session::get('coupon_discount');
    }
@endphp
@section('style')
    <style type="text/css">
        input.form-control{
            border: 0.5px solid #000;
        }
    </style>
@endsection

@section('content')

    <!-- Start of Main -->
        <main class="main cart">
            @if(count($carts) > 0)
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="active">Shopping Cart</li>
                        <li>Checkout</li>
                        <li>Order Complete</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <div class="row gutter-lg mb-10">
                        <div class="col-lg-8 pr-lg-4 mb-6">
                            <table class="shop-table cart-table desktop_cart_table">
                                <thead>
                                    <tr>
                                        <th class="product-name"><span>Product</span></th>
                                        <th></th>
                                        <th class="product-price"><span>Price</span></th>
                                        <th class="product-quantity"><span>Quantity</span></th>
                                        <th class="product-subtotal"><span>Subtotal</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $cart)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <div class="p-relative">
                                                <a href="product-default.html">
                                                    <figure>
                                                        <img src="{{ asset('images/product/' . $cart->options->image) }}" alt="{{ $cart->name }}"
                                                            width="100">
                                                    </figure>
                                                </a>
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="rowId" value="{{ $cart->rowId }}">
                                                    <button type="submit" class="btn btn-close"><i
                                                        class="fas fa-times"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route('single.product', [$cart->id, Str::slug($cart->name)]) }}">
                                                {{ $cart->name }}
                                            </a>
                                        </td>
                                        <td class="product-price"><span class="amount">{{ env('CURRENCY') }}{{ $cart->price }} {{ env('UAE_CURRENCY') }}</span></td>
                                        <td class="product-quantity">
                                           
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="rowId" value="{{ $cart->rowId }}">
                                                <div class="d-table-cell w-100">
                                                    <input type="number" name="qty" value="{{ $cart->qty }}" class="form-control">
                                                </div>
                                                 <div class="d-table-cell align-middle">
                                                    <button type="submit" class="btn btn-dark">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount">{{ env('CURRENCY') }} {{ $cart->price * $cart->qty }} {{ env('UAE_CURRENCY') }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>

                            <table class="table-bordered table-responsive mobile_cart_table">
                                <thead>
                                    <tr>
                                        <th style="width: 100px;padding: 10px;">Image</th>
                                        <th style="width: 300px;padding: 10px;"><span>Product</span></th>
                                        <th style="width: 100px;padding: 10px;"><span>Price</span></th>
                                        <th style="padding: 10px;"><span>Quantity</span></th>
                                        <th style="width: 100px;padding: 10px;"><span>Subtotal</span></th>
                                        <th style="width: 100px;padding: 10px;"><span>Remove</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $cart)
                                    <tr>
                                        <td style="padding: 10px;">
                                            <img src="{{ asset('images/product/' . $cart->options->image) }}" alt="{{ $cart->name }}" width="200">
                                        </td>
                                        <td style="padding: 10px;">
                                            <a href="{{ route('single.product', [$cart->id, Str::slug($cart->name)]) }}">
                                                {{ $cart->name }}
                                            </a>
                                        </td>
                                        <td style="padding: 10px;"><span class="amount">{{ env('CURRENCY') }}{{ $cart->price }} {{ env('UAE_CURRENCY') }}</span></td>
                                        <td style="padding: 10px;">
                                           
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="rowId" value="{{ $cart->rowId }}">
                                                <div class="d-table-cell w-100">
                                                    <input type="number" name="qty" value="{{ $cart->qty }}" class="form-control" style="width: 150px;">
                                                </div>
                                                 <div class="d-table-cell align-middle">
                                                    <button type="submit" class="btn btn-dark">Update</button>
                                                </div>
                                            </form>
                                        </td>
                                        <td style="width: 300px;"> 
                                            <span class="amount">{{ env('CURRENCY') }} {{ $cart->price * $cart->qty }} {{ env('UAE_CURRENCY') }}</span>
                                        </td>
                                        <td style="padding: 10px;">
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="rowId" value="{{ $cart->rowId }}">
                                                <button type="submit" class="btn btn-close"><i
                                                    class="fas fa-times"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>

                            <div class="cart-action mb-6">
                                <a href="{{ route('products') }}" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i class="w-icon-long-arrow-left"></i>Continue Shopping</a>
                                <!-- <button type="submit" class="btn btn-rounded btn-default btn-clear" name="clear_cart" value="Clear Cart">Clear Cart</button> 
                                <button type="submit" class="btn btn-rounded btn-update disabled" name="update_cart" value="Update Cart">Update Cart</button> -->
                            </div>

                            <form class="coupon" action="{{ route('coupon.apply') }}" method="POST">
                                @csrf
                                <h5 class="title coupon-title font-weight-bold text-uppercase">Coupon Discount</h5>
                                <input type="text" name="code" class="form-control mb-4" placeholder="Enter coupon code here" style="border: 0.5px solid #000;" required />
                                @if(Session::has('success'))
                                <p class="alert alert-success">{{ Session::get('success') }} </p>
                                @endif
                                
                                @if(Session::has('invalid'))
                                <p class="alert alert-danger">{{ Session::get('invalid') }}</p>
                                @endif
                                @if(Session::has('coupon_discount'))
                                <a href="{{ route('coupon.remove') }}" class="btn btn-dark btn-outline btn-rounded">Remove Coupon</a>
                                @endif
                                <button type="submit" class="btn btn-dark btn-outline btn-rounded">Apply Coupon</button>
                            </form>
                            <!-- @if(Session::has('coupon_discount'))
                            <form action="{{ route('coupon.remove') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-dark btn-outline btn-rounded">Remove Coupon</button>
                            </form>
                            @endif -->
                        </div>
                        <div class="col-lg-4 sticky-sidebar-wrapper">
                            <div class="sticky-sidebar">
                                <div class="cart-summary mb-4">
                                    <h3 class="cart-title text-uppercase">Cart Totals</h3>
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Subtotal</label>
                                        <span>{{ env('CURRENCY') }}{{ Cart::subtotal() }} {{ env('UAE_CURRENCY') }}</span>
                                    </div>
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Shipping Charge</label>
                                        <span>{{ env('CURRENCY') }}0 {{ env('UAE_CURRENCY') }}</span>
                                    </div>
                                    @if(Session::has('coupon_discount'))
                                    <div class="cart-subtotal d-flex align-items-center justify-content-between">
                                        <label class="ls-25">Discount</label>
                                        <span>{{ env('CURRENCY') }}{{ Session::get('coupon_discount') }} {{ env('UAE_CURRENCY') }}</span>
                                    </div>
                                    @endif

                                    <hr class="divider">
                                    <div class="order-total d-flex justify-content-between align-items-center">
                                        <label>Total</label>
                                        <span class="ls-50">{{ env('CURRENCY') }}{{ Cart::subtotal() - $discount }} {{ env('UAE_CURRENCY') }}</span>
                                    </div>
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-block btn-dark btn-icon-right btn-rounded  btn-checkout">
                                        Proceed to checkout<i class="w-icon-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of PageContent -->
            @else
            <div class="page-content">
                <div class="container">
                    <div class="row gutter-lg mb-10">
                        <h3 class="mt-4 text-center">Your Cart is Empty</h3>
                    </div>
                </div>
            </div>
            @endif
        </main>
        <!-- End of Main -->
	

@endsection

        