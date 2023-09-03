@extends('admin.layouts.master')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Admin Create</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Admin</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
	<div class="container-fluid">
		<form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="row">

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Name *</b></label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
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
            <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror">
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
            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
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
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" required>
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
            <input type="text" name="city" value="{{ old('city') }}" class="form-control @error('city') is-invalid @enderror" required>
            @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>

        <!-- <div class="col-md-4">
          <div class="form-group">
            <label><b>Country *</b></label>
            <input type="text" name="country" value="{{ old('country') }}" class="form-control @error('country') is-invalid @enderror" value="Philippines" required>
            @error('country')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div> -->

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Image</b></label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group">
            <label><b>Password *</b></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div>

        <!-- <div class="col-md-12">
          <div class="form-group">
            <label><b>Description*</b></label>
            <textarea name="description" class="summernote form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
          </div>
        </div> -->
      
    </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
		</form>
	</div>
</section>
@endsection
