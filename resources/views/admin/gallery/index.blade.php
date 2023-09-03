@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Web Gallery</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">gallery</li>
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
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    
                   <div class="col-md-12">
                     <div class="form-group">
                       <label>Image*</label>
                       <input type="file" name="image[]" class="form-control @error('image') is-invalid @enderror" multiple required>
                       @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                       <button class="btn btn-primary">Save</button>
                     </div>
                   </div>
                  </div>

                </form>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                
                <div class="row">
                  @foreach($galleries as $gallery)
                    <div class="col-md-2 p-2">
                      <a href="#delete{{ $gallery->id }}" title="Delete Image" data-toggle="modal"><img src="{{ asset('images/gallery/'. $gallery->image) }}" width="100%"></a>
                    </div>
                    <!-- Delete Gallery Modal -->
            <div class="modal fade" id="delete{{ $gallery->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are tou sure you want to delete ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Permanent Delete</button>
                            </form>

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
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
<script src="{{ asset('plugins/filterizr/jquery.filterizr.min.js') }}"></script>
	<script>
  <script>
  $(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
      event.preventDefault();
      $(this).ekkoLightbox({
        alwaysShowClose: true
      });
    });

    $('.filter-container').filterizr({gutterPixels: 3});
    $('.btn[data-filter]').on('click', function() {
      $('.btn[data-filter]').removeClass('active');
      $(this).addClass('active');
    });
  })
</script>
</script>
@endsection