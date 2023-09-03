@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Vouchers List</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Voucher</li>
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
                  <form action="{{ route('voucher.store') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Name*</label>
                          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
                          @error('name')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Code*</label>
                          <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" required>
                          @error('code')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Amount *</label>
                          <input type="text" name="discount" class="form-control @error('discount') is-invalid @enderror" required>
                          @error('discount')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Expire On*</label>
                          <input type="date" min="{{ date('Y-m-d') }}" name="expire_on" class="form-control @error('expire_on') is-invalid @enderror" required>
                          @error('expire_on')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label><input type="checkbox" name="single_use"> One Time Use Only</label>
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
                        <th>Name</th>
                        <th>Code</th>
                        <th>Amount</th>
                        <th>Expires On</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
	                  @foreach($vouchers as $voucher)
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>{{ $voucher->name }}</td>
                        <td>{{ $voucher->code }}</td>
		                    <td>{{ $voucher->discount }}</td>
                        <td>{{ $voucher->expire_on }}</td>
                        <td>{{ $voucher->created_at }}</td>
                        <td>
                          <a href="#edit{{ $voucher->id }}" data-toggle="modal" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                          <a href="#delete{{ $voucher->id }}" data-toggle="modal" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="edit{{ $voucher->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <form action="{{ route('voucher.update', $voucher->id) }}" method="POST">
                                @csrf
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit - {{ $voucher->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                               
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Name*</label>
                                      <input type="text" name="name" value="{{ $voucher->name }}" class="form-control @error('name') is-invalid @enderror" required>
                                      @error('name')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Code*</label>
                                      <input type="text" name="code" value="{{ $voucher->code }}" class="form-control @error('code') is-invalid @enderror" required>
                                      @error('code')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Amount *</label>
                                      <input type="text" value="{{ $voucher->discount }}" name="discount" class="form-control @error('discount') is-invalid @enderror" required>
                                      @error('discount')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Expire On*</label>
                                      <input type="date" value="{{ $voucher->expire_on }}" min="{{ date('Y-m-d') }}" name="expire_on" class="form-control @error('expire_on') is-invalid @enderror" required>
                                      @error('expire_on')
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
            <div class="modal fade" id="delete{{ $voucher->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are tou sure you want to delete ?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" align="right">
                            <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST">
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
                  <tfoot>
                  	<tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Amount</th>
                        <th>Expires On</th>
                        <th>Created At</th>
                        <th>action</th>
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
  });
</script>
@endsection