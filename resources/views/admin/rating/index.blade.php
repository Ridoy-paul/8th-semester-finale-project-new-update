@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Rating List</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Rating</li>
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
	                      <th>Course</th>
	                   	  <th>Student</th>
	                      <th>Rating</th>
	                      <th>Comment</th>
	                      <th>Status</th>
	                      <th>Date</th>
                        @if(Auth::user()->type == 1)
	                       <th>Action</th>
                        @endif
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($ratings as $rating)
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>{{ $rating->course->title }}</td>
		                    <td>
                          @if(!is_null($rating->student))
                          {{ $rating->student->name . ' '. $rating->student->last_name }}
                          @else
                            N/A
                          @endif
                        </td>
                        <td>{{ $rating->rating }}</td>
                        <td>{{ $rating->comment }}</td>
                        <td><span class="badge badge-{{ $rating->is_active == 1 ? 'success' :  'danger' }}">{{ $rating->is_active == 1 ? 'Active' :  'Inactive' }}</span></td>
                        <td>{{ $rating->created_at }}</td>
                        @if(Auth::user()->type == 1)
                        <td>
	                    	<a href="#editModal{{ $rating->id }}" class="btn btn-primary" data-toggle="modal" title="Edit"><i class="fas fa-edit"></i></a>
	                    	<a href="#deleteModal{{ $rating->id }}" class="btn btn-danger" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
		                   </td>
                       @endif
		                    
		                </tr>
		                <!-- Rating Delete Modal -->
            <div class="modal fade" id="deleteModal{{ $rating->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are tou sure you want to delete ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('rating.destroy', $rating->id) }}" method="POST">
                                {{ csrf_field() }}
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Permanent Delete</button>
                            </form>

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rating Update Modal -->
            <div class="modal fade" id="editModal{{ $rating->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                	<form action="{{ route('rating.update', $rating->id) }}" method="POST">
                      @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Edit Rating - {{ $rating->id }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div>
                            	<p>Course - {{ $rating->course->title }}</p>
                            <p>
                              Student - 
                              @if(!is_null($rating->student))
                              {{ $rating->student->name . ' '. $rating->student->last_name }}
                              @else
                                N/A
                              @endif
                            </p>
                            </div>
                            
                                
                                <div class="col-md-12">
						          <div class="form-group">
						            <label class="float-sm-left">Status</label>
						            <select class="form-control" name="is_active">
						              <option value="1" {{ ($rating->is_active == 1) ? 'selected' : '' }}>Active</option>
						              <option value="0" {{ ($rating->is_active == 0) ? 'selected' : '' }}>Inactive</option>
						            </select>
						          </div>
						        </div>

                        </div>
                        <div class="modal-footer">
                        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>

                   </form>
                </div>
            </div>
	                  @endforeach
                  </tbody>
                  <tfoot>
                  	<tr>
	                    <th>S.N</th>
                      	<th>Course</th>
                      	<th>Student</th>
                      	<th>Rating</th>
                      	<th>Comment</th>
                      	<th>Status</th>
                      	<th>Date</th>
                        @if(Auth::user()->type == 1)
                         <th>Action</th>
                        @endif
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