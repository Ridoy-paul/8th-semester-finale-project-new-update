@extends('layouts.master')

@section('title')
{{ 'Affiliate Dashboard' . ' | '. env('APP_NAME') }}
@endsection

@section('style')
    <style type="text/css">
        .small-box{
            padding: 10px;
            color: #fff;
        }
        .inner h3{
            color: #fff;
        }
        .btn-primary{
            background-color: #336699;
            color: #fff;
        }
        input{
            border: 1px solid #000 !important;
            margin-bottom: 10px;
        }
    </style>
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
                    <div>
                        <h5>Affiliate Dashboard</h5>
                    </div>
                    <div id="exTab1" class="container"> 
                        <ul  class="nav nav-pills pt-4 pb-4">
                            <li class="active">
                                <a  href="#1a" data-toggle="tab" class="p-2">Dashboard</a>
                            </li>
                            <li><a href="#2a" data-toggle="tab" class="p-2">My Referrals</a>
                            </li>
                            <li><a href="#3a" data-toggle="tab" class="p-2">Earning List</a>
                            </li>
                            <li><a href="#4a" data-toggle="tab" class="p-2">Payment History</a>
                            </li>
                            <li><a href="#5a" data-toggle="tab" class="p-2">Coupone</a>
                            </li>
                        </ul>

                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a">
                                    <div class="row">
                  
                                      <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-success">
                                          <div class="inner">
                                            <h3>
                                              {{ $orders->sum('referral_amount') }}
                                            </h3>

                                            <p>Total Earned Amount</p>
                                          </div>
                                          <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                          </div>
                                          
                                        </div>
                                      </div>
                                      <!-- ./col -->
                                      <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-danger">
                                          <div class="inner">
                                            <h3>
                                              {{
                                                $payments->filter(function($payment){
                                                    return $payment->paid_amount != NULL;
                                                })->sum('paid_amount')
                                              }}
                                            </h3>

                                            <p>Withdrawal Amount</p>
                                          </div>
                                          <div class="icon">
                                            <i class="ion ion-person-add"></i>
                                          </div>
                                        </div>
                                      </div>
                                      
                                      <!-- ./col -->
                                      <div class="col-lg-4 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-secondary">
                                          <div class="inner">
                                            <h3>
                                              {{
                                                $orders->sum('referral_amount') - $payments->filter(function($payment){
                                                    return $payment->paid_amount != NULL;
                                                })->sum('paid_amount')
                                              }}
                                            </h3>

                                            <p>Available Amount</p>
                                          </div>
                                          <div class="icon">
                                            <i class="ion ion-pie-graph"></i>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- ./col -->
                                    </div>
                                    <form action="{{ route('customer.payment.request') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 mt-4">
                                                <h4>Make Payment Request</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="number" name="request_amount" class="form-control" placeholder="Amount">
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <button class="btn btn-primary form-control">Request Now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="2a">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">S.N</th>
                                                <th style="width: 65%;">Name</th>
                                                <th style="width: 55%;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($referrals as $referral)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $referral->name . ' ' . $referral->last_name }}</td>
                                                <td>{{ $referral->created_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="3a">
                                    <table class="table table-hover table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">S.N</th>
                                                <th style="width: 45%;">Customer</th>
                                                <th style="width: 35%;">Order Total</th>
                                                <th style="width: 35%;">Commision</th>
                                                <th style="width: 35%;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>{{ $order->price }}</td>
                                                <td>{{ $order->referral_amount }}</td>
                                                <td>{{ $referral->created_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                              <div class="tab-pane" id="4a">
                                    <table class="p-2 table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10%;">S.N</th>
                                                <th style="width: 35%;">Requested Payment</th>
                                                <th style="width: 35%;">Received Payment</th>
                                                <th style="width: 55%;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $payment->request_amount }}</td>
                                                <td>{{ $payment->paid_amount }}</td>
                                                <td>{{ $payment->created_at }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                              </div>

                              <div class="tab-pane" id="5a">
                                <div class="row">
                                    <form action="{{ route('customer.coupon.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Name*</label>
                                              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="Affiliate" required readonly>
                                              @error('name')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label>Code*</label>
                                              <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" required>
                                              @error('code')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                            </div>
                                          </div>

                                          

                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Discount *</label>
                                              <input type="text" name="discount" class="form-control @error('discount') is-invalid @enderror" required>
                                              @error('discount')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Coupon Type *</label>
                                              <select name="coupon_type" class="form-control @error('coupon_type') is-invalid @enderror" required>
                                                <option value="percent">Percent Discount</option>
                                                <option value="flat">Flat Discount</option>
                                              </select>
                                              @error('coupon_type')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                            </div>
                                          </div>
                                          <div class="col-md-4">
                                            <div class="form-group">
                                              <label>Valid To*</label>
                                              <input type="date" min="{{ date('Y-m-d') }}" name="valid_to" class="form-control @error('valid_to') is-invalid @enderror" required>
                                              @error('valid_to')
                                                  <span class="invalid-feedback" role="alert">
                                                      <strong>{{ $message }}</strong>
                                                  </span>
                                              @enderror
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                            <div class="form-group">
                                              <label><input type="checkbox" name="single_use"> One Time Use Only</label>
                                            </div>
                                          </div>
                                          <div class="col-md-12">
                                            <div class="form-group">
                                              <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                          </div>
                                        </div>
                                      </form>
                                </div>
                                <div>
                                  <table id="example1" class="mt-4 table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Type</th>
                        <th>Valid To</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($coupons as $coupon)
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $coupon->name }}</td>
                        <td>{{ $coupon->code }}</td>
                        <td>{{ $coupon->discount == NULL ? $coupon->amount : $coupon->discount }}</td>
                        <td>{{ $coupon->amount == NULL ? 'Percentage' : 'Flat' }}</td>
                        
                        <td>{{ $coupon->valid_to }}</td>
                        <td>{{ $coupon->created_at }}</td>
                        <td>
                          <a href="#edit{{ $coupon->id }}" data-toggle="modal" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                          <a href="#delete{{ $coupon->id }}" data-toggle="modal" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit{{ $coupon->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <form action="{{ route('customer.coupon.update', $coupon->id) }}" method="POST">
                                @csrf
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit - {{ $coupon->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                               
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Name*</label>
                                      <input type="text" name="name" value="{{ $coupon->name }}" class="form-control @error('name') is-invalid @enderror" required readonly>
                                      @error('name')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Code*</label>
                                      <input type="text" name="code" value="{{ $coupon->code }}" class="form-control @error('code') is-invalid @enderror" required>
                                      @error('code')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Discount *</label>
                                      <input type="text" value="{{ $coupon->discount == NULL ? $coupon->amount : $coupon->discount }}" name="discount" class="form-control @error('discount') is-invalid @enderror" required>
                                      @error('discount')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Coupon Type *</label>
                                      <select name="coupon_type" class="form-control @error('coupon_type') is-invalid @enderror" required>
                                        <option value="percent" {{ $coupon->amount == NULL ? 'selected' : '' }}>Percent Discount</option>
                                        <option value="flat" {{ $coupon->discount == NULL ? 'selected' : '' }}>Flat Discount</option>
                                      </select>
                                      @error('coupon_type')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <label>Valid To*</label>
                                      <input type="date" value="{{ $coupon->valid_to }}" min="{{ date('Y-m-d') }}" name="valid_to" class="form-control @error('valid_to') is-invalid @enderror" required>
                                      @error('valid_to')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>

                              </form>
                          </div>
                        </div>

                        <!-- Delete Modal -->
            <div class="modal fade" id="delete{{ $coupon->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" align="right">
                            <form action="{{ route('customer.coupon.destroy', $coupon->id) }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Permanent Delete</button>
                            </form>

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
                        
                    </tr>
                    
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Discount</th>
                        <th>Type</th>
                        <th>Expires On</th>
                        <th>Created At</th>
                        <th>action</th>
                    </tr>
                  </tfoot>
                </table>
                                </div>
                                    
                              </div>
                            </div>
                    </div>

                    
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection