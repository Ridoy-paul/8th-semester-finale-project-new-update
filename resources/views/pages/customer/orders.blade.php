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
        
        <div class="page-content container pt-2">
            <div class="row">
                <div class="col-md-3">
                    @include('pages.customer.nav')
                </div>
                <div class="col-md-9">
                    <div class="tab-pane mb-4" id="account-orders">
                            <div>
                                 <h3>Orders</h3>
                            </div>

                            <table class="table table-hover table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th style="width: 30%;">Code</th>
                                        <th class="order-date" style="width: 30%;">Date</th>
                                        <th style="width: 20%;">Status</th>
                                        <th style="width: 20%;">Total</th>
                                        <th style="width: 30%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->code }}</td>
                                        <td>{{\Carbon\Carbon::parse($order->created_at)->format('d M, Y g:iA')}}</td>
                                        <td>{{ $order->status->title }}</td>
                                        <td>
                                            <span class="order-price">{{ env('CURRENCY') }}{{ $order->price }} {{ env('UAE_CURRENCY') }}</span> for
                                            <span class="order-quantity"> {{ $order->order_product->sum('qty') }}</span> item
                                        </td>
                                        <td>
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
                    
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection