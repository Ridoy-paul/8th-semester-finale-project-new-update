@extends('admin.layouts.master')
@section('content')
@php($business_info = DB::table('settings')->first())
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h3 class="mb-0 fw-bold">Order Info</h3>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-9">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-6 text-left">
                  <h4>
                  <img src="{{ asset('images/website/'.optional($business_info)->header_logo.'') }}" width="200">
                  </h4>
                  <address>
                    Name: <strong>{{ $order->name }}</strong><br>
                    Phone:  <strong>{{ $order->phone }}</strong><br>
                    Email: {{ $order->email }}<br>
                    City: {{ $order->city }}<br>
                    Shipping Address: {{ $order->shipping_address }}
                  </address>
                </div>
                <div class="col-md-6 text-right">
                  <address>
                    Date: {{\Carbon\Carbon::parse($order->created_at)->format('d M, Y g:iA')}}<br>
                    Order Code: <strong># {{ $order->code }}</strong><br>
                    Payment Satus: <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'danger' }}"> {{ $order->payment_status == 'paid' ? 'Paid' : 'Not Paid' }}</span><br>
                    Payment Method: <strong># {{ $order->payment_method }}</strong><br>
                    @if($order->payment_method == 'Manula MFS')
                      Received By: <strong> {{optional($order)->manual_mfs_account_name}}</strong><br>
                      Payment Number: <strong> {{optional($order)->manual_mfs_payment_number}}</strong><br>
                      Transacton ID: <strong> {{optional($order)->manual_mfs_transaction_id}}</strong><br>
                    @endif
                    @if($order->payment_method == 'online payment' && $order->order_transaction_info <> '')
                      <span class="text-success fw-bold">
                        Transaction ID: <strong> {{ $order->order_transaction_info->tran_id }}</strong><br>
                        Amount: <strong>{{ env('CURRENCY') }} {{ $order->order_transaction_info->amount }}</strong><br>
                        Store Amount: <strong>{{ env('CURRENCY') }} {{ $order->order_transaction_info->store_amount }}</strong><br>
                      </span>
                    @endif
                    <span class="h4">Satus: <span class="badge badge-primary">{{ $order->order_status }}</span></span><br>
                  </address>
                </div>
                
                <hr style="color: #800020;">
                <!-- /.col -->
              </div>
              
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>S.N</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($order->order_product as $product)
                        <?php
                            $variation_info = '';
                            if($product->variations <> 0) {
                                $stock_info = variation_stock_info($product->variations);
                                if(!is_null($stock_info)) {
                                    if($stock_info->color <> null){
                                        $color_attribute_info = color_info($stock_info->color);
                                        $color_info = '<b>Color: </b>'.optional($color_attribute_info)->name.', ';
                                    }
                                    else {
                                        $color_info = '';
                                    }

                                    if($stock_info->variant <> null){
                                        $variant_attribute_info = variation_info($stock_info->variant);
                                        $attribute_info = '<b>'.optional($variant_attribute_info)->title.': </b>'.optional($stock_info)->variant_output.'';
                                    }
                                    else {
                                        $attribute_info = '';
                                    }
                                    $variation_info = $color_info.$attribute_info;
                                }
                            }

                        ?>
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $product->product->title }}<br><span class="cart__content--variant">{!!$variation_info!!}</span></td>
                          <td>{{ env('CURRENCY') }}{{ $product->price }}</td>
                          <td>{{ $product->qty }}</td>
                          <td>{{ env('CURRENCY') }}{{ $product->price * $product->qty }}</td>
                        </tr>
                      @endforeach
                      <tr>
                        <td colspan="4" align="right">Delivery Charge:</td>
                        <td>{{ env('CURRENCY') }}{{ $order->delivery_charge == NULL ? 0 : $order->delivery_charge }}</td>
                      </tr>
                      <tr>
                        <td colspan="4" align="right">Total:</td>
                        <td>{{ env('CURRENCY') }}{{ $order->price + $order->delivery_charge }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
        </div>
        <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 shadow rounded p-2">
                    <form action="{{ route('order.payment.status.change', $order->id) }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label>Payment Status</label>
                        <select name="payment_status" class="form-control">
                          <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                          <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Not Paid</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form>
                  </div>
                  <div class="col-md-12 mt-3 shadow rounded p-2">
                    <form action="{{ route('order.status.change', $order->id) }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label>Order Status</label>
                        <select name="order_status_id" class="form-control">
                          <option @if($order->order_status == 'pending') selected class="bg-success text-light" @endif value="pending">Pending</option>
                          <option @if($order->order_status == 'processing') selected class="bg-success text-light" @endif value="processing">Processing</option>
                          <option @if($order->order_status == 'shipped') selected class="bg-success text-light" @endif value="shipped">Shipped</option>
                          <option @if($order->order_status == 'delivered') selected class="bg-success text-light" @endif value="delivered">Delivered</option>
                          <option @if($order->order_status == 'canceled') selected class="bg-success text-light" @endif value="canceled">Canceled</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form>
                  </div>
                  <div class="col-12 mt-3">
                    {{-- <a href="" class="btn btn-primary float-right" style="margin-right: 5px;"><i class="fas fa-download"></i> Download Invoice</a> --}}
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
	<script>
    //Date range picker
    $('#reservation').daterangepicker();
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection