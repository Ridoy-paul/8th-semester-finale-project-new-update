@extends('admin.layouts.master')
@section('content')
  <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Page Edit</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Page</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
	<div class="container-fluid">
		<form action="{{ route('page.update', $page->id) }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row card p-2">
				
				<div class="col-md-12">
					{{--
				  <div class="form-group">
					<label><span class="text-danger">*</span>Select Page</label>
					<select name="page_slug" class="form-control" id="" required>
					  <option value="">-- Select One --</option>
					  <option value="privacy_policy">Privacy Policy</option>
					  <option value="terms_and_condition">Terms and Conditions</option>
					  <option value="return_and_refund_policy">Return / Refund Policy</option>
					  <option value="mission_and_vission">Mission & Vission</option>
					  <option value="support_policy">Support Policy Page</option>
					</select>
				  </div>
				  --}}
				  <div class="form-group">
					<label><span class="text-danger">*</span>Title</label>
					<input type="text" name="name" value="{{optional($page)->name}}" class="form-control @error('name') is-invalid @enderror" required>
					@error('name')
					  <span class="invalid-feedback" role="alert">
						  <strong>{{ $message }}</strong>
					  </span>
					@enderror
				  </div>
				</div>
				{{--
				<div class="col-md-6">
				  <div class="form-group">
					<label><span class="text-danger">*</span>Slide Images (1903x520 px)</label>
					<input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required>
					@error('image')
					  <span class="invalid-feedback" role="alert">
						  <strong>{{ $message }}</strong>
					  </span>
					@enderror
				  </div>
				</div>
				--}}
				<div class="col-md-12">
				  <div class="form-group">
					<label>Description</label>
					<textarea name="description" class="form-control" id="" cols="30" rows="5">{{optional($page)->description}}</textarea>
					@error('description')
					  <span class="invalid-feedback" role="alert">
						  <strong>{{ $message }}</strong>
					  </span>
					@enderror
				  </div>
				</div>
				<div class="col-md-12">
				  <div class="form-group text-right">
					<button type="submit" class="btn btn-primary">Save</button>
				  </div>
				</div>
				
			  </div>
		</form>
	</div>
</section>
@endsection
