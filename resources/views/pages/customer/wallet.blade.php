@extends('layouts.master')

@section('title')
{{ 'My Account' . ' | '. env('APP_NAME') }}
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
        <!-- <div class="page-header">
            <div class="container">
                <h1 class="page-title mb-0">My Account</h1>
            </div>
        </div> -->
        <!-- End of Page Header -->

        <!-- Start of Breadcrumb -->
        <nav class="breadcrumb-nav pt-4">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li>My account</li>
                </ul>
            </div>
        </nav>
        <!-- End of Breadcrumb -->

        
        <div class="page-content container pt-2">
            <div class="row">
                <div class="col-md-3">
                    @include('pages.customer.nav')
                </div>
                <div class="col-md-9">
                    
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
                	@php
                		$setting = App\Models\Setting::find(1);
                	@endphp
                	<form action="{{ route('customer.point.convert') }}" method="POST">
				    	@csrf
					    <div class="row">
					    	<div class="col-md-12 mt-4">
					    		<h4>Convert Point to TK({{ $setting->equivalent_point }} Point = 1 TK)</h4>
					    	</div>
					    	<div class="col-md-4">
					    		<div class="form-group">
					    			<input type="number" name="point" class="form-control" placeholder="Point" min="{{ $setting->minimum_point }}">
					    			<span class="pt-2 text-danger">Minimum Point Required for Conversion is {{ $setting->minimum_point }}</span>
					    		</div>
					    	</div>
					    	<input type="hidden" name="minimum_point" value="{{ $setting->minimum_point }}">
					    	<div class="col-md-4">
					    		<div class="form-group">
					    			<button class="btn btn-primary form-control">Convert Now</button>
					    		</div>
					    	</div>
					    </div>
					</form>


                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
@endsection