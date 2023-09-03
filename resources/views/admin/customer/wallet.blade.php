@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">My Wallet</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">wallet</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
	<div class="container-fluid">
		<div class="card">
              <div class="card-header">
                  
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <!-- Small boxes (Stat box) -->
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
			    <!-- /.row -->

			    <form action="" method="POST">
			    	@csrf
				    <div class="row">
				    	<div class="col-md-12">
				    		<h4>Convert Point to TK</h4>
				    	</div>
				    	<div class="col-md-4">
				    		<div class="form-group">
				    			<input type="number" name="point" class="form-control">
				    			<span>Minimum </span>
				    		</div>
				    	</div>
				    	<div class="col-md-4">
				    		<div class="form-group">
				    			<button class="btn btn-primary form-control">Convert Now</button>
				    		</div>
				    	</div>
				    </div>
				</form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
	</div>
</section>
@endsection

@section('scripts')
	<script>
	  
	</script>
@endsection