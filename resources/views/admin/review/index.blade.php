@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Review List</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Review List</li>
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
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
	                  <tr>
	                    <th>Date</th>
                        <th>Customer Name</th>
                        <th>Product Name</th>
                        <th>Status</th>
                        <th>Action</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($reviews as $review)
	                  	<tr>
		                    <td>{{ date('d-m-Y', strtotime($review->created_at)) }}</td>
		                    <td>{{ optional($review->customer_info)->name }}</td>
                            <td>{{ optional($review->product_info)->title }}</td>
                            <td>
                                @if(optional($review)->is_active == 0)
                                    <span class="badge badge-warning">Pending</span>
                                @elseif(optional($review)->is_active == 1)
                                    <span class="badge badge-success">Active</span>
                                @elseif(optional($review)->is_active == 2)
                                    <span class="badge badge-danger">Canceled</span>
                                @endif
                            </td>
                            
                            <td>
                                <a href="{{route('product.review.edit', optional($review)->id)}}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            </td>
		                </tr>

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
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection