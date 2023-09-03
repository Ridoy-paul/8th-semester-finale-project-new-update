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

                        <div class="tab-pane mb-4" id="account-orders">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-orders">
                                    <i class="w-icon-orders"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title text-capitalize ls-normal mb-0">Orders</h4>
                                </div>
                            </div>

                            <table class="shop-table account-orders-table mb-6 table table-hover table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th class="order-id">Code</th>
                                        <th class="order-date">Date</th>
                                        <th class="order-status">Status</th>
                                        <th class="order-total">Total</th>
                                        <th class="order-actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td class="order-id">{{ $order->code }}</td>
                                        <td class="order-date">{{\Carbon\Carbon::parse($order->created_at)->format('d M, Y g:iA')}}</td>
                                        <td class="order-status">{{ $order->status->title }}</td>
                                        <td class="order-total">
                                            <span class="order-price">{{ env('CURRENCY') }}{{ $order->price }} {{ env('UAE_CURRENCY') }}</span> for
                                            <span class="order-quantity"> {{ $order->order_product->sum('qty') }}</span> item
                                        </td>
                                        <td class="order-action">
                                            <a href="{{ route('order.invoice.generate', $order->id) }}"
                                                class="btn btn-outline btn-default btn-block btn-sm btn-rounded">Download Invoice</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <a href="{{ route('products') }}" class="btn btn-dark btn-rounded btn-icon-right">Go
                                Shop<i class="w-icon-long-arrow-right"></i></a>
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

                        <div class="tab-pane" id="account-details">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-account mr-2">
                                    <i class="w-icon-user"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title mb-0 ls-normal">Account Details</h4>
                                </div>
                            </div>
                            <form class="form account-details-form" action="{{ route('customer.account.update', Auth::id()) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name *</label>
                                            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                                class="form-control form-control-md">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Phone *</label>
                                            <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}"
                                                class="form-control form-control-md">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-6">
                                    <label for="email_1">Email address *</label>
                                    <input type="email" id="email_1" value="{{ Auth::user()->email }}" name="email" class="form-control form-control-md" readonly>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="display-name">Address *</label>
                                    <input type="text" id="display-name" name="address" value="{{ Auth::user()->address }}" class="form-control form-control-md mb-0">
                                </div>
                                <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4">Save Changes</button>
                            </form>
                            <form class="pt-4 form account-details-form" action="{{ route('customer.password.change') }}" method="post">
                                @csrf
                                <h4 class="title title-password ls-25 font-weight-bold">Password change</h4>
                                <div class="form-group">
                                    <label class="text-dark" for="cur-password">Current Password</label>
                                    <input type="password" class="form-control form-control-md"
                                        id="cur-password" name="c_password">
                                </div>
                                <div class="form-group">
                                    <label class="text-dark" for="new-password">New Password</label>
                                    <input type="password" class="form-control form-control-md"
                                        id="new-password" name="n_password">
                                </div>
                                <div class="form-group mb-10">
                                    <label class="text-dark" for="conf-password">Confirm Password</label>
                                    <input type="password" class="form-control form-control-md"
                                        id="conf-password" name="cf_password">
                                </div>
                                <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="page-content container pt-2">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <p style="color: #fff;font-size: 20px;margin: 0px;">Hello, {{ Auth::user()->name . ' ' . Auth::user()->last_name }}</p>
                        </div>
                      <ul class="list-group list-group-flush">
                        <!-- <li class="list-group-item"><a href="">Dashboard</a></li> -->
                        <li class="list-group-item"><a href="">Orders</a></li>
                        <li class="list-group-item"><a href="">Wishlist</a></li>
                        <li class="list-group-item"><a href="">My Wallet</a></li>
                        <li class="list-group-item"><a href="">Account details</a></li>
                        <li class="list-group-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-rounded">Logout</button>
                            </form>
                        </li>
                      </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div>
                        <h3>Account Details</h3>
                    </div>
                    <form class="form account-details-form" action="{{ route('customer.account.update', Auth::id()) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input type="text" id="name" name="name" value="{{ Auth::user()->name }}"
                                        class="form-control form-control-md">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone *</label>
                                    <input type="text" id="phone" name="phone" value="{{ Auth::user()->phone }}"
                                        class="form-control form-control-md">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-6">
                            <label for="email_1">Email address *</label>
                            <input type="email" id="email_1" value="{{ Auth::user()->email }}" name="email" class="form-control form-control-md" readonly>
                        </div>

                        <div class="form-group mb-3">
                            <label for="display-name">Address *</label>
                            <input type="text" id="display-name" name="address" value="{{ Auth::user()->address }}" class="form-control form-control-md mb-0">
                        </div>
                        <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4">Save Changes</button>
                    </form>
                    <form class="pt-4 form account-details-form" action="{{ route('customer.password.change') }}" method="post">
                        @csrf
                        <h4 class="title title-password ls-25 font-weight-bold">Password change</h4>
                        <div class="form-group">
                            <label class="text-dark" for="cur-password">Current Password</label>
                            <input type="password" class="form-control form-control-md"
                                id="cur-password" name="c_password">
                        </div>
                        <div class="form-group">
                            <label class="text-dark" for="new-password">New Password</label>
                            <input type="password" class="form-control form-control-md"
                                id="new-password" name="n_password">
                        </div>
                        <div class="form-group mb-10">
                            <label class="text-dark" for="conf-password">Confirm Password</label>
                            <input type="password" class="form-control form-control-md"
                                id="conf-password" name="cf_password">
                        </div>
                        <button type="submit" class="btn btn-dark btn-rounded btn-sm mb-4">Save Changes</button>
                    </form>
                    <div class="row">
                  
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>
                          {{ 
                            $wallet->entry->sum('cash_in') - $wallet->entry->sum('cash_out')
                          }}
                        </h3>

                        <p>Available Amount</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>
                      
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>
                          {{ 
                            $wallet->entry->sum('cash_out')
                          }}
                        </h3>

                        <p>Used Amount</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                    </div>
                  </div>
                  
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                      <div class="inner">
                        <h3>
                          {{ 
                            $wallet->entry->sum('point_in') - $wallet->entry->sum('point_out')
                          }}
                        </h3>

                        <p>Available Point</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3>
                          {{ 
                            $wallet->entry->sum('point_out')
                          }}
                        </h3>

                        <p>Used Point</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection