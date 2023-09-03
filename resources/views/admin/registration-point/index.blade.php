@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Registration Point List</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Registration Point</li>
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
          <form action="{{ route('registration.point.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label>Point *</label>
                  <input type="number" name="point" class="form-control @error('point') is-invalid @enderror" required>
                  @error('point')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
              </div>

              <div class="col-md-5">
                <div class="form-group">
                  <label>Valid From*</label>
                  <input type="date" min="{{ date('Y-m-d') }}" name="valid_from" class="form-control @error('valid_from') is-invalid @enderror" required>
                  @error('valid_from')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-5">
                <div class="form-group">
                  <label>Valid To*</label>
                  <input type="date" min="{{ date('Y-m-d') }}" name="valid_to" class="form-control @error('valid_to') is-invalid @enderror" required>
                  @error('valid_to')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Status*</label>
                  <select name="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                  @error('is_active')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>
              </div>
              
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </div>
          </form>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive">
        <table id="example1" class="table table-bordered table-hover">
          <thead>
          <tr>
              <th>S.N</th>
              <th>Point</th>
              <th>Valid From</th>
              <th>Valid To</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($registration_points as $point)
              <tr>
                <td>{{ $loop->index + 1 }}</td>
                <td>{{ $point->point }}</td>
                  <td>{{ $point->valid_from }}</td>
                  <td>{{ $point->valid_to }}</td>
                  <td><span class="badge badge-{{ $point->is_active == 1 ? 'success' : 'danger' }}">{{ $point->is_active == 1 ? 'Active' : 'Inactive' }}</span></td>
                  <td>{{ $point->created_at }}</td>
                  <td>
                      <a href="#edit{{ $point->id }}" data-toggle="modal" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                      <a href="#delete{{ $point->id }}" data-toggle="modal" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                  </td>

                <!-- Edit Modal -->
                <div class="modal fade" id="edit{{ $point->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('registration.point.update', $point->id) }}" method="POST">
                        @csrf
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit - {{ $point->point }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Point*</label>
                              <input type="number" name="point" value="{{ $point->point }}" class="form-control @error('point') is-invalid @enderror" required>
                              @error('point')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Valid From*</label>
                              <input type="date" value="{{ $point->valid_from }}" name="valid_from" class="form-control @error('valid_from') is-invalid @enderror" required>
                              @error('valid_from')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Valid To*</label>
                              <input type="date" value="{{ $point->valid_to }}" min="{{ date('Y-m-d') }}" name="valid_to" class="form-control @error('valid_to') is-invalid @enderror" required>
                              @error('valid_to')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Status*</label>
                              <select name="is_active" class="form-control @error('is_active') is-invalid @enderror" required>
                                <option value="1" {{ $point->is_active == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $point->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                              </select>
                              @error('is_active')
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
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </div>
                    </div>

                      </form>
                  </div>
                </div>

                <!-- Delete Modal -->
                  <div class="modal fade" id="delete{{ $point->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete ?</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body" align="right">
                                  <form action="{{ route('registration.point.destroy', $point->id) }}" method="POST">
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
                
            </tr>
            
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
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
  });
</script>
@endsection