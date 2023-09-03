@php
    $wishlist_count = 0;
    $orders = 0;

    if(Auth::check()) {
        $wishlists = App\Models\Wishlist::where('customer_id', Auth::id())->count('id');
        $wishlist_count = $wishlists;

        $orders = App\Models\Order::where('customer_id', Auth::id())->count('id');
    }

@endphp
@extends('user.inc.master')
@section('title')My Account @endsection
@section('description')My Account  @endsection
@section('keywords')My Account @endsection
@section('content')

<section class="my__account--section py-5">
    <div class="container-fluid">

        <div class="my__account--section__inner border-radius-10 d-flex p-5">
            @include('user.pages.customer.account_sidebar')
            
            <div class="account__wrapper">
                <div class="account__content">
                    <h2 class="account__content--title h3 mb-20">My Dashboard</h2>
                    <div class="row">
                        <div class="col-md-3 col-6">
                            <div class="shipping__items2 d-flex align-items-center shadow border">
                                <div class="shipping__items2--content py-3">
                                    <h2 class="my-3">0.00</h2>
                                    <h6>Wallet Balance</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="shipping__items2 d-flex align-items-center shadow border">
                                <div class="shipping__items2--content py-3">
                                    <h2 class="my-3">0.00</h2>
                                    <h6>Wallet Point</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="shipping__items2 d-flex align-items-center shadow border">
                                <div class="shipping__items2--content py-3">
                                    <h2 class="my-3">{{$orders}}</h2>
                                    <h6>Orders</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="shipping__items2 d-flex align-items-center shadow border">
                                <div class="shipping__items2--content py-3">
                                    <h2 class="my-3">{{$wishlist_count}}</h2>
                                    <h6>Wishlist</h6>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    
</script>
@endsection