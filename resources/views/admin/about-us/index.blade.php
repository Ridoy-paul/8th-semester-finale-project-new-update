@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">About Us Settings</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">About Us settings</li>
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
               <form action="{{ route('about_us.store')}}" method="POST" enctype="multipart/form-data">
                 @csrf
                 <div class="row">
                   <div class="col-md-6">
                    <div class="form-group">
                      <label>Image</label>
                      <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                      @error('image')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                       </div>
                  </div>
                  <div class="col-md-6">
                    <img class="mt-2 shadow rounded border p-1" width="100%" src="{{ asset('images/website/'. optional($info)->image) }}">
                  </div>

                   
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>About Us Details</label>
                      <textarea name="about_us_text" id="" cols="30" rows="10">{!! optional($info)->about_us_text !!}</textarea>
                      @error('about_us_text')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Our Mission</label>
                      <textarea name="mission" id="" cols="30" rows="10">{!! optional($info)->mission !!}</textarea>
                      @error('mission')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Our Vision</label>
                      <textarea name="vission" id="" cols="30" rows="10">{!! optional($info)->vission !!}</textarea>
                      @error('vission')
                           <span class="invalid-feedback" role="alert">
                               <strong>{{ $message }}</strong>
                           </span>
                       @enderror
                    </div>
                  </div>
                  

                   <div class="col-md-12 p-2">
                    <div class="row shadow rounded border p-2">
                        <div class="col-md-12"><h3><b>Custom Information</b></h3></div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Custom Information Title</label>
                            <input type="text" name="custom_block_title" value="{{ optional($info)->custom_block_title }}" class="form-control @error('meta_title') is-invalid @enderror">
                            @error('custom_block_title')
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                             @enderror
                          </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                              <label>Custom Information Details</label>
                              <textarea name="custom_block_details" id="" cols="30" rows="10">{!! optional($info)->custom_block_details !!}</textarea>
                              @error('custom_block_details')
                                   <span class="invalid-feedback" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                               @enderror
                            </div>
                          </div>
                        
                    </div>
                   </div>

                   <div class="col-md-12 text-right mt-2">
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
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>
@endsection