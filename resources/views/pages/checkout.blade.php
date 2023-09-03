@extends('layouts.master')

@section('title')
	{{ 'Checkout' . ' | '. env('APP_NAME') }}
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
        .checkout select.form-control {
            border: 0.5px solid #000;
        }
    </style>
@endsection


@section('content')

        <!-- Start of Main -->
        <main class="main checkout">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb shop-breadcrumb bb-no">
                        <li class="passed">Shopping Cart</li>
                        <li class="active">Checkout</li>
                        <li>Order Complete</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

        

            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <div class="">
                        Returning customer? <a href="{{ route('login') }}"
                            class="show-login font-weight-bold text-uppercase text-dark">Login</a>
                    </div>
                    <form class="form checkout-form" action="{{ route('order.create') }}" method="post">
                        @csrf
                        <div class="row mb-9">
                            <div class="col-lg-7 pr-lg-4 mb-4">
                                <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
                                    Shipping Details
                                </h3>
                                <div class="row gutter-sm">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Name *</label>
                                            <input type="text" class="form-control form-control-md" name="name" value="{{ optional(Auth::user())->name . ' ' . optional(Auth::user())->last_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>Phone *</label>
                                            <input type="text" class="form-control form-control-md" name="phone" value="{{ optional(Auth::user())->phone }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- <div class="form-group">
                                    <label>Country *</label>
                                    <div class="select-box">
                                        <select name="country" class="form-control form-control-md">
                                            <option value="default" selected="selected">United States
                                                (US)
                                            </option>
                                            <option value="uk">United Kingdom (UK)</option>
                                            <option value="us">United States</option>
                                            <option value="fr">France</option>
                                            <option value="aus">Australia</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="row gutter-sm">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control form-control-md" name="email" value="{{ optional(Auth::user())->email }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row gutter-sm">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>District</label>
                                            <select name="district_id" id="district_id" class="form-control @error('district_id') is-invalid @enderror" required>
                                            <option value="">Please Chose a District</option>
                                            @foreach($districts as $district)
                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                            @endforeach
                                          </select>
                                          @error('district_id')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Area *</label>
                                            <select name="area_id" id="areas" class="form-control @error('area_id') is-invalid @enderror" required>
                                            <option value="">Please Chose an Area</option>
                                            
                                          </select>
                                          @error('area_id')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address *</label>
                                    <input type="text" placeholder="House number and street name"
                                        class="form-control form-control-md mb-2" name="shipping_address" value="{{ optional(Auth::user())->address }}" required>
                                </div>
                                

                                <div class="form-group mt-3">
                                    <label for="order-notes">Order notes (optional)</label>
                                    <textarea class="form-control mb-0" id="order-notes" name="order-notes" cols="30"
                                        rows="4"
                                        placeholder="Notes about your order, e.g special notes for delivery"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
                                <div class="order-summary-wrapper sticky-sidebar">
                                    <h3 class="title text-uppercase ls-10">Your Order</h3>
                                    <div class="order-summary">
                                        <table class="order-table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">
                                                        <b>Product</b>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($carts as $cart)
                                                
                                                <tr class="bb-no">
                                                    <td class="product-name">{{ $cart->name }} <i
                                                            class="fas fa-times"></i> <span
                                                            class="product-quantity">{{ $cart->qty }}</span></td>
                                                    <td class="product-total">{{ env('CURRENCY') }}{{ $cart->qty * $cart->price }} {{ env('UAE_CURRENCY') }}</td>
                                                </tr>
                                                @endforeach
                                                <tr class="cart-subtotal bb-no">
                                                    <td>
                                                        <b>Subtotal</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ env('CURRENCY') }}{{ Cart::subtotal() - $discount }} {{ env('UAE_CURRENCY') }}</b>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            
                                        </table>

                                        <div class="payment-methods" id="payment_method">
                                            <h4 class="title font-weight-bold ls-25 pb-0 mb-1">Payment Methods</h4>
                                            
                                            <div class="form-group">
                                                <select name="payment_method" id="payment_option" class="form-control">
                                                    <option value="Cash on Delivery">Cash on Delivery</option>
                                                    <option value="Bkash">Bkash</option>
                                                    <option value="Rocket">Rocket</option>
                                                </select>
                                            
                                            </div>
                                            
                                            <div  class="hidden" id="cod">
                                                
                                            </div>
                                            <div class="hidden" id="bkash">
                                                <h3 class="alert-success">Bkash (01xxxxxxxxx)</h3>
                                                <input type="text" placeholder="Transaction Id" name="bkash_transaction_id" class="form-control">
                                                <input type="text" placeholder="Phone" name="bkash_phone" class="form-control">
                                                <input type="text" placeholder="Amount" name="bkash_amount" class="form-control">
                                                
                                            </div>
                                            <div  class="hidden" id="rocket">
                                                <h3  class="alert-success">Rocket (01xxxxxxxxx)</h3>
                                                <input type="text" placeholder="Transaction Id" name="rocket_transaction_id" class="form-control" id="transaction_id">
                                                <input type="text" placeholder="Phone" name="rocket_phone" class="form-control">
                                                <input type="text" placeholder="Amount" name="rocket_amount" class="form-control">
                                            </div>

                                        </div>

                                        <div class="form-group place-order pt-6">
                                            <button type="submit" class="btn btn-dark btn-block btn-rounded">Place Order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->
	

@endsection

@section('scripts')

    <script>
        $('#district_id').change(function(){
            var district_id = $(this).val();
            if (district_id == ''){
                district_id = -1;
            }
            var option = "<option value=''>Please Chose an Area</option>";
            var url = "{{ url('/') }}";

            $.get( url + "/get-area/"+district_id, function( data ) {
                data = JSON.parse(data);
                data.forEach(function (element) {
                    option += "<option value='"+ element.id +"'>"+ element.name + "</option>";
                });
                //console.log(option);
                $('#areas').html(option);
            });

        });
    </script>
@endsection

        