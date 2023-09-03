@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Page List</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Page</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-dark text-light">
        <h5 class="modal-title" id="exampleModalLabel">Add New Page</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('page.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label><span class="text-danger">*</span>Select Page</label>
                <select name="page_slug" class="form-control" id="" required>
                  <option value="">-- Select One --</option>
                  <option value="privacy_policy">Privacy Policy</option>
                  <option value="terms_and_condition">Terms and Conditions</option>
                  <option value="return_and_refund_policy">Return / Refund Policy</option>
                  <option value="mission_and_vission">Mission & Vission</option>
                  <option value="support_policy">Support Policy Page</option>
                </select>
              </div>

              <div class="form-group">
                <label><span class="text-danger">*</span>Title</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            {{--
            <div class="col-md-6">
              <div class="form-group">
                <label><span class="text-danger">*</span>Slide Images (1903x520 px)</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required>
                @error('image')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            --}}
            <div class="col-md-12">
              <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                @error('description')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- /.content-header -->
<section class="content">
	<div class="container-fluid">
		<div class="card">
              <div class="card-header text-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Add New Page</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
	                  <tr>
	                    <th width="10%">S.N</th>
	                    <th>Name</th>
                      <th width="50%">Description</th>
	                    <th>Action</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($pages as $page)
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>{{ $page->name }}</td>
                        <td>{{ substr(strip_tags($page->description), 0,  200) }} ....</td>
		                    <td>
		                    	<a href="{{ route('page.edit', $page->id) }}" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
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