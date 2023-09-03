
@extends('user.inc.master')
@section('title')My Orders @endsection
@section('description')My Orders  @endsection
@section('keywords')My Orders @endsection
@section('content')

<section class="my__account--section py-5">
    <div class="container-fluid">

        <div class="my__account--section__inner border-radius-10 d-flex p-5">
            @include('user.pages.customer.account_sidebar')
            
            <div class="account__wrapper">
                <div class="account__content">
                    {{-- <h2 class="account__content--title h3 mb-20">Account Details</h2> --}}
                    <div class="account__table--area">
                        <div class="shadow mt-3 p-4 mb-3 rounded">
                            <h3 class="font-weight-bold mb-3 text-danger">Orders</h3>

                            <table class="table table-hover table-bordered table-responsive">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th class="order-date" style="width: 30%;">Date</th>
                                        <th style="width: 20%;">Status</th>
                                        <th style="width: 20%;">Total</th>
                                        <th style="width: 20%; text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->code }}</td>
                                        <td>{{\Carbon\Carbon::parse($order->created_at)->format('d M, Y g:iA')}}</td>
                                        <td>{{ $order->order_status }}</td>
                                        <td>
                                            <span class="order-price">{{ env('CURRENCY') }}{{ $order->price }} {{ env('UAE_CURRENCY') }}</span> for
                                            <span class="order-quantity"> {{ $order->order_product->sum('qty') }}</span> item
                                        </td>
                                        <td  style="width: 20%; text-align:center;">
                                            <a href="{{ route('order.view', $order->code) }}" class="border rounded p-1">View</a>
                                            {{-- <a href="{{ route('order.invoice.generate', $order->id) }}" class="border rounded p-1">Invoice</a> --}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
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