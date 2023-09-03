@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Products</h1>
      </div><!-- /.col -->
      <div class="col-sm-6 text-right">
        <a href="{{ route('product.create') }}" class="btn btn-primary btn-rounded"><i class="fas fa-plus"></i> Add Product</a>
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
	                    <th width="5%">S.N</th>
	                    <th width="30%">Title</th>
                      <th>Image</th>
                      {{-- <th>Category</th> --}}
                      <th>Brand</th>
                      <th>Type</th>
                      <th>Status</th>
	                    <th>Action</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($products as $product)
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>{{ $product->title }}</td>
                        <td><img src="{{ asset('/images/product/'.$product->thumbnail_image) }}" width="100px" class="shadow rounded p-1"></td>
                        {{-- <td>{{ !is_null($product->category) ? $product->category->title : '' }}</td> --}}
                        <td>{{ !is_null($product->brand) ? $product->brand->title : '' }}</td>
                        <td>{{ $product->type }}</td>
                        <td><span class="badge badge-{{ $product->is_active == 1 ? 'success' : 'danger' }}">{{ $product->is_active == 1 ? 'Active' : 'Inactive' }}</span></td>
		                    <td>
		                    	<a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
		                    	<a href="#deleteModal{{ $product->id }}" class="btn btn-danger" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
		                    </td>
		                </tr>
                  <!-- Delete product Modal -->
                      <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Are tou sure you want to delete ?</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <form action="{{ route('product.destroy', $product->id) }}" method="POST">
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
                  </tbody>
                </table>
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