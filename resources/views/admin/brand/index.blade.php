@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Brand List</h1>
      </div><!-- /.col -->
      <div class="col-sm-6 text-right">
        <a href="#addModal" class="btn btn-primary" data-toggle="modal"><i class="fas fa-plus"></i> Create Brand</a>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
	<div class="container-fluid">
		<div class="card">
              
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
	                  <tr>
	                    <th>S.N</th>
	                    <th>Title</th>
                      <th>Image</th>
                      <th>Featured</th>
                      <th>Serial Number</th>
	                    <th>Action</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($brands as $brand)
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>{{ $brand->title }}</td>
                        <td>
                          <img class="shadow rounded p-1 border" src="{{ asset('images/brand/'. ($brand->image !=  Null ? $brand->image : 'default.png')) }}" width="70px">
                        </td>
                        <td>
                          @if($brand->is_featured == 1)
                            <span class="badge bg-success">Featured</span>
                          @else
                            <span class="badge bg-danger">Not Featured</span>
                          @endif
                        </td>
                        <td>{{$brand->position}}</td>
		                    <td>
		                    	<a href="#editModal{{ $brand->id }}" class="btn btn-primary" data-toggle="modal" title="Edit"><i class="fas fa-edit"></i></a>
		                    	<a href="#deleteModal{{ $brand->id }}" class="btn btn-danger" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
		                    </td>
		                </tr>

                    <!-- Edit brand Modal -->
                    <div class="modal fade" id="editModal{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">
                                      Edit - {{ $brand->title }}
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-group">
                                          <label>brand Title *</label>
                                          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" Value="{{ $brand->title }}" required>
                                          @error('title')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                        </div>

                                        <div class="form-group">
                                          <label>Serial Number</label>
                                          <input type="number" name="position" class="form-control @error('position') is-invalid @enderror" Value="{{ $brand->position }}" placeholder="Serial Number">                        
                                        </div>

                                        <div class="form-group shadow rounded px-3">
                                          <label for="">Is Featured</label>
                                          <div class="">
                                            <label for="is_featured_yes{{$brand->id}}" class=""><input class="" type="radio" id="is_featured_yes{{$brand->id}}" value="1" {{ $brand->is_featured == 1 ? 'checked' : '' }} name="is_featured"> Yes</label>
                                            <label for="is_featured_no{{$brand->id}}" class="ml-2"><input class="" type="radio" id="is_featured_no{{$brand->id}}" value="0" {{ $brand->is_featured == 0 ? 'checked' : '' }} name="is_featured"> No</label>
                                          </div>
                                        </div>

                                      </div> 
                                      <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                          <label>Brand Image *</label>
                                          <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" Value="{{ $brand->image }}">
                                          @error('image')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                          @enderror
                                        </div>
                                      </div>
                                        <div class="form-group text-right">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                          <button class="btn btn-primary">Save Changes</button>
                                        </div>
                                      </div>
                                    </div>
                                  </form>

                                </div>
                                
                            </div>
                        </div>
            </div>
                <!-- Delete brand Modal -->
                    <div class="modal fade" id="deleteModal{{ $brand->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-body" align="center">
                                <h3 class="fw-bold my-5"><b>Are tou sure you want to delete?</b></h3>
                                  <form action="{{ route('brand.destroy', $brand->id) }}" method="POST">
                                      @csrf
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-danger">Permanent Delete</button>
                                  </form>
                              </div>
                          </div>
                        </div>
                    </div>

	                  @endforeach
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- Add Modal -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Brand</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="modal-body">
                  
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Brand Title *</label>
                          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" required>
                          @error('title')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>

                        <div class="form-group">
                          <label>Serial Number</label>
                          <input type="number" name="position" class="form-control @error('position') is-invalid @enderror" placeholder="Serial Number">                        
                        </div>
                        
                        <div class="form-group shadow rounded px-3">
                          <label for="">Is Featured</label>
                          <div class="">
                            <label for="is_featured_yes" class=""><input class="" type="radio" id="is_featured_yes" value="1" name="is_featured"> Yes</label>
                            <label for="is_featured_no" class="ml-2"><input class="" type="radio" id="is_featured_no" value="0" checked name="is_featured"> No</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Brand Image *</label>
                          <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="image">
                          @error('image')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
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
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endsection