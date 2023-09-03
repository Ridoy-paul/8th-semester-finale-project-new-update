@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Slider</h1>
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
              <div class="card-body">
                <form action="{{ route('slider.update', optional($slider)->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label><span class="text-danger">*</span>Title</label>
                        <input type="text" name="title" value="{{optional($slider)->title}}" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label><span class="text-danger">*</span>Serial Number</label>
                        <input type="text" name="serial_number" value="{{optional($slider)->serial_number}}" class="form-control" required>
                        @error('serial_number')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label>Change Slide Images (1903x520 px)</label>
                          <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                          @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <img class="shadow rounded border p-2" src="{{ asset('images/slider/'.optional($slider)->image ) }}" width="100%">
                        </div>
                      </div>
                        
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control" id="" cols="30" rows="5">{{optional($slider)->description}}</textarea>
                        @error('description')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
        
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" value="{{optional($slider)->link}}" class="form-control @error('link') is-invalid @enderror">
                        @error('link')
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
	</div>
</section>
@endsection
