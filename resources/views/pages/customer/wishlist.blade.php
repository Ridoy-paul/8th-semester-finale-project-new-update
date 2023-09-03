@extends('layouts.master')

@section('title')
{{ 'My Account' . ' | '. env('APP_NAME') }}
@endsection

@section('content')
	<!-- Start of Main -->
    <main class="main">
        <!-- Start of Page Header -->
        <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">My Account</h1>
            </div>
        </div>
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>My account</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        <!-- Start of PageContent -->
        <!-- <div class="page-content pt-2">
            <div class="container">
                <div class="tab tab-vertical row gutter-lg">
                    <ul class="nav nav-tabs mb-6" role="tablist">
                        <li class="nav-item">
                            <a href="#account-dashboard" class="nav-link active">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="#account-orders" class="nav-link">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a href="#wishlist" class="nav-link">Wishlist</a>
                        </li>
                        <li class="nav-item">
                            <a href="#account-details" class="nav-link">Account details</a>
                        </li>
                        <div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-rounded">Logout</button>
                            </form>
                        </div>
                        
                    </ul>

                    <div class="tab-content mb-6">
                        <div class="tab-pane active in" id="account-dashboard">
                            <p class="greeting">
                                Hello
                                <span class="text-dark font-weight-bold">{{ Auth::user()->name }}</span>
                            </p>

                            <p class="mb-4">
                                From your account dashboard you can view your <a href="#account-orders"
                                    class="text-primary link-to-tab">recent orders</a> and
                                <a href="#account-details" class="text-primary link-to-tab">edit your password and
                                    account details.</a>
                            </p>

                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                    <a href="#account-orders" class="link-to-tab">
                                        <div class="icon-box text-center">
                                            <span class="icon-box-icon icon-orders">
                                                <i class="w-icon-orders"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <p class="text-uppercase mb-0">Orders</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                    <a href="#wishlist" class="link-to-tab">
                                        <div class="icon-box text-center">
                                            <span class="icon-box-icon icon-address">
                                                <i class="w-icon-map-marker"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <p class="text-uppercase mb-0">Wishlist</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                    <a href="#account-details" class="link-to-tab">
                                        <div class="icon-box text-center">
                                            <span class="icon-box-icon icon-account">
                                                <i class="w-icon-user"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                <p class="text-uppercase mb-0">Account Details</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                                    
                                        <div class="icon-box text-center">
                                            <span class="icon-box-icon icon-logout">
                                                <i class="w-icon-logout"></i>
                                            </span>
                                            <div class="icon-box-content">
                                                
                                                <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-rounded">Logout</button>
                            </form>
                                            </div>
                                        </div>
                                    
                                </div>
                            </div>
                        </div>

                        

                        <div class="tab-pane" id="wishlist">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-map-marker">
                                    <i class="w-icon-heart"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title mb-0 ls-normal">Wishlist</h4>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">S.N</th>
                                        <th style="width: 30%;">Product</th>
                                        <th style="width: 30%;">Image</th>
                                        <th style="width: 270px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlists as $wishlist)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $wishlist->product->title }}</td>
                                        <td><img src="{{ asset('images/product/'.$wishlist->product->image) }}" width="200"></td>
                                        <td>

                                            
                                        <form action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST">
                                            @csrf
                                            <a onclick="addToCart({{ $wishlist->product->id }})" class="btn btn-rounded btn-dark" style="color: #fff;">Add To Cart</a>
                                            <button class="btn btn-rounded btn-dark"><i class="fas fa-times"></i></button>
                                        </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="page-content container pt-2">
            <div class="row">
                <div class="col-md-3">
                    @include('pages.customer.nav')
                </div>
                <div class="col-md-9">
                    <div class="tab-pane mb-4" id="account-orders">
                            <div>
                               <h5>Wishlist</h5>
                            </div>
                            <table class="table table-hover table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">S.N</th>
                                        <th style="width: 30%">Product</th>
                                        <th style="width: 20%">Image</th>
                                        <th style="width: 40%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlists as $wishlist)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $wishlist->product->title }}</td>
                                        <td><img src="{{ asset('images/product/'.$wishlist->product->image) }}" width="200"></td>
                                        <td>

                                            
                                        <form action="{{ route('wishlist.remove', $wishlist->id) }}" method="POST">
                                            @csrf
                                            <a onclick="addToCart({{ $wishlist->product->id }})" class="btn btn-rounded btn-dark" style="color: #fff;">Add To Cart</a>
                                            <button class="btn btn-rounded btn-dark"><i class="fas fa-times"></i></button>
                                        </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection