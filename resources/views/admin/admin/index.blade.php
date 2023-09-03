@extends('admin.layouts.master')
@section('content')

<!-- /.content-header -->
<section class="content ">
	<div class="container-fluid">
		<div class="card mt-4">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h3 class="m-0 fw-bold">Administrator List</h3>
          </div>
          <div class="col-md-6 text-right">
            <a href="{{ route('admin.create') }}" class="btn btn-primary">Add New Admin</a>
          </div>
        </div>
          
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
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($admins as $admin)
              <tr>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $admin->name . ' ' . $admin->last_name }}</td>
                  <td>{{ $admin->email }}</td>
                  <td>{{ $admin->phone }}</td>
                  <td><img src="{{ asset('images/admin/' . $admin->image) }}" class="rounded-pill shadow p-2" width="100px"></td>
                  <td>
                    {{-- <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a> --}}
                    <a href="#deleteModal{{ $admin->id }}" class="btn btn-danger" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
                  </td>
              </tr>
            <!-- admin Modal -->
                <div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Are tou sure you want to delete ?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" align="right">
                                <form action="{{ route('admin.destroy', $admin->id) }}" method="POST">
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

            @endforeach
          </tbody>
        </table>
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