@extends('admin.layouts.master')
@section('content')
  <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Admin Edit</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Admin</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
	<div class="container-fluid">
		<form action="{{ route('admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Name *</b></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $admin->name }}" required>
            @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>

        <!-- <div class="col-md-4">
          <div class="form-group">
            <label><b>Last Name</b></label>
            <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $admin->last_name }}">
            @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div> -->

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Email *</b></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $admin->email }}" required>
            @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Phone *</b></label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $admin->phone }}" required>
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label><b>City *</b></label>
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ $admin->city }}" required>
            @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Country *</b></label>
            <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ $admin->country }}" required>
            @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Image *</b></label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <img src="{{ asset('images/admin/' . $admin->image) }}" width="100">
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label><b>E-Signature (375x171 px) *</b></label>
            <input type="file" name="signature" class="form-control @error('signature') is-invalid @enderror">
            @error('signature')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <img src="{{ asset('images/signature/' . $admin->signature) }}" width="100">
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Designation *</b></label>
            <label class="form-control"><input type="checkbox" name="is_president" {{ $admin->is_president == 1 ? 'checked' : '' }}> President</label>
            @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>

        <div class="col-md-12">
          <div class="form-group">
            <label><b>Description*</b></label>
            <textarea name="description" class="summernote form-control @error('description') is-invalid @enderror">{{ $admin->description }}</textarea>
            @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>
      
    </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
		</form>
	</div>
</section>
@endsection
