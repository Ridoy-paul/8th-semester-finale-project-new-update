@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Flash Sale Offer</h1>
      </div><!-- /.col -->
      <div class="col-sm-6 text-right">
        <a href="{{ route('flash.sale.create') }}" class="btn btn-primary btn-rounded"><i class="fas fa-plus"></i> New Flash Sale Offer</a>
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
                        <th>Stand Time</th>
                        <th>Status</th>
	                    <th>Action</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($flash_sales as $offer)
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>{{ $offer->title }}</td>

                            <td><img src="{{ asset('/images/product/'.$offer->image) }}" width="100px" class="shadow rounded p-1"></td>
                            <td>
                              <b>Start Time: </b> {{date("d-m-Y, h:i:s", strtotime($offer->start_date_time))}} <br>
                              <b>End Time: </b> {{date("d-m-Y, h:i:s", strtotime($offer->end_date_time))}}
                            </td>
                            <td><span class="badge badge-{{ $offer->is_active == 1 ? 'success' : 'danger' }}">{{ $offer->is_active == 1 ? 'Active' : 'Inactive' }}</span></td>
		                    <td>
		                    	<a href="{{ route('flash.sale.edit', $offer->id) }}" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
		                    	<a href="#deleteModal{{ $offer->id }}" class="btn btn-danger" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
		                    </td>
		                </tr>

                  <!-- Delete product Modal -->
                      <div class="modal fade" id="deleteModal{{ $offer->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Are tou sure you want to delete ?</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <form action="{{ route('flash.sale.destroy', $offer->id) }}" method="POST">
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