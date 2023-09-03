@extends('admin.layouts.master')
@section('content')
  <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Review Edit</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Review Edit</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
	<div class="container-fluid">
		<form class="card p-2" action="{{ route('product.review.update', $review->id) }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">
				
				<div class="col-md-12">
					<div class="form-group">
                        <h4><b>Product Name:</b></h4>
                        <input type="text" name="" readonly value="{{optional($review->product_info)->title}}" class="form-control">
                    </div>
				</div>
                <div class="col-md-6">
					<div class="form-group">
                        <label>Customer Name</label>
                        <input type="text" name="" readonly value="{{ optional($review->customer_info)->name }}" class="form-control">
                    </div>
				</div>
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label><span class="text-danger">*</span>Review Star (Max: 5, Min: 1)</label>
                        <input type="number" name="review_star" max="5" min="1" value="{{optional($review)->review_star}}" class="form-control @error('review_star') is-invalid @enderror" required>
                        @error('review_star')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><span class="text-danger">*</span>Review Status</label>
                        <select name="is_active" class="form-control" id="">
                            <option @if(optional($review)->is_active == 0) selected class="text-light bg-success" @endif value="0">Pending</option>
                            <option @if(optional($review)->is_active == 1) selected class="text-light bg-success" @endif value="1">Active</option>
                            <option @if(optional($review)->is_active == 2) selected class="text-light bg-success" @endif value="2">Canceled</option>
                        </select>
                    </div>
                </div>
				<div class="col-md-12">
				  <div class="form-group">
					<label>Description</label>
					<textarea name="review_text" class="form-control" id="" cols="30" rows="5">{{optional($review)->review_text}}</textarea>
					@error('review_text')
					  <span class="invalid-feedback" role="alert">
						  <strong>{{ $message }}</strong>
					  </span>
					@enderror
				  </div>
				</div>
				<div class="col-md-12">
				  <div class="form-group text-right">
					<button type="submit" class="btn btn-primary">Update</button>
				  </div>
				</div>
				
			  </div>
		</form>
	</div>
</section>
@endsection
