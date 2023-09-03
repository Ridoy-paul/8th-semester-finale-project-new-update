@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Blog</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">edit-blog</li>
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
               <form action="{{ route('blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                 @csrf
                 <div class="row">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label>Blog Title</label>
                       <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $blog->title }}">
                       @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                       <label>Image(800x533 px)</label>
                       <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                       @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>

                   <div class="col-md-6">
                    <label>Old Image</label><br>
                    <img class="shadow rounded p-1 mt-2" src="{{ asset('images/blog/'.$blog->image) }}" width="200">
                   </div>
                   
                   <div class="col-md-12">
                     <div class="form-group">
                       <label>Descriotion*</label>
                       <textarea name="description" class="summernote form-control @error('description') is-invalid @enderror">
                         {{ $blog->description }}
                       </textarea> 
                       @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>
                   <div class="col-md-12 text-right">
                     <div class="form-group">
                       <button class="btn btn-primary">Save Changes</button>
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