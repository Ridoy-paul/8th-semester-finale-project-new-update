@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Seller Request</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">seller-request</li>
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
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
	                  <tr>
	                    <th>S.N</th>
	                    <th>Name</th>
	                    <th>Email</th>
	                    <th>Phone</th>
	                    <th>Action</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($affiliates as $affiliate)
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>{{ $affiliate->name . ' ' . $affiliate->last_name }}</td>
		                    <td>{{ $affiliate->email }}</td>
		                    <td>{{ $affiliate->phone }}</td>
		                    <td>
		                    	<a href="#editModal{{ $affiliate->id }}" class="btn btn-primary" data-toggle="modal" title="Applicant Details"><i class="fas fa-eye"></i></a>
		                    </td>
		                </tr>

                    <!-- Edit affiliate Modal -->
            <div class="modal fade" id="editModal{{ $affiliate->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                              Applicant Details - {{ $affiliate->name . ' ' . $affiliate->last_name }}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                              <div class="col-md-4">
                                <p>Name : {{ $affiliate->name . ' ' . $affiliate->last_name }}</p>
                              </div>

                              <div class="col-md-4">
                                <p>Email : {{ $affiliate->name }}</p>
                              </div> 

                              <div class="col-md-4">
                                <p>Phone : {{ $affiliate->name }}</p>
                              </div>  

                              <div class="col-md-6">
                                <p>Image</p>
                                <img src="{{ asset('images/customer/'.$affiliate->image) }}">
                              </div>

                              <div class="col-md-6">
                                <p>NID</p>
                                <img src="{{ asset('images/customer/nid/'.$affiliate->nid) }}" width="100%">
                              </div>
                              
                                <div class="form-group">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                  <a href="{{ route('affiliate.status', [$affiliate->id, 'reject']) }}" class="btn btn-danger">Reject</a>
                                  <a href="{{ route('affiliate.status', [$affiliate->id, 'approve']) }}" class="btn btn-primary">Approve</a>
                                  <!-- <button class="btn btn-danger">Reject</button>
                                  <button class="btn btn-primary">Accept</button> -->
                                </div>
                              </div>
                            </div>
                          </form>

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

	                  @endforeach
                  </tbody>
                  <tfoot>
                  	<tr>
	                    <th>S.N</th>
	                    <th>Name</th>
	                    <th>Email</th>
	                    <th>Phone</th>
	                    <th>Action</th>
	                  </tr>
                  </tfoot>
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