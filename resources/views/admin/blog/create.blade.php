@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Add Blog</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">add-blog</li>
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
               <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
                 @csrf
                 <div class="row">
                   <div class="col-md-12">
                     <div class="form-group">
                       <label>Blog Title</label>
                       <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror">
                       @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                       <label>Image(800x600 px)*</label>
                       <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required>
                       @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                       <label>Status</label>
                       <select name="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                         <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Publish</option>
                         <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Draft</option>
                       </select>
                       @error('is_active')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="form-group">
                       <label>Descriotion*</label>
                       <textarea name="description" class="summernote form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea> 
                       @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="form-group">
                       <button class="btn btn-primary">Save</button>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>
@endsection