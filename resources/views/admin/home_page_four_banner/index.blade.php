@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Home Page 4 Banners</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Home Page 4 Banners</li>
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
                <form action="{{ route('f.banner.update') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Select Banner image To be change</label>
                        <select name="position" class="form-control @error('position') is-invalid @enderror" required>
                          <option value="">Chose</option>
                          <option value="1">1st Banner [ Image Size: 510 X 565 px ]</option>
                          <option value="2">2nd Banner [ Image Size: 350 X 275 px ]</option>
                          <option value="3">3rd Banner [ Image Size: 350 X 275 px ]</option>
                          <option value="4">4th Banner [ Image Size: 725 X 265 px ]</option>
                        </select>
                        @error('position')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Change Banner Images</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" >
                        @error('image')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror">
                        @error('title')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="" name="description" rows="3"></textarea>
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
                        <input type="text" name="link" class="form-control @error('link') is-invalid @enderror">
                        @error('link')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Change Slide</button>
                      </div>
                    </div>
                    
                  </div>
                </form>
              </div>
                <div class="row p-2">
                  @foreach($banners as $banner)
                    <div class="col-md-4 p-2">
                        <div class="shadow rounded border p-2 text-center">
                            <img src="{{ asset('images/slider/'.$banner->image) }}" class="mb-2" width="100%">
                            <h4>{{$banner->title}}</h4>
                            <span>{!!$banner->description!!}</span>
                            <span><b>Link: </b>{{$banner->link}}</span>
                        </div>
                    </div>
                  @endforeach
                </div>
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