@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Discount List</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Discount</li>
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
                  <form action="{{ route('discount.store') }}" method="POST">
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
                          <label>Discount(%) *</label>
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
                          <label>Start From*</label>
                          <input type="date" min="{{ date('Y-m-d') }}" name="from" class="form-control @error('from') is-invalid @enderror" required>
                          @error('from')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>End At*</label>
                          <input type="date" min="{{ date('Y-m-d') }}" name="to" class="form-control @error('to') is-invalid @enderror" required>
                          @error('to')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6">
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
	                   	  <th>Discount %</th>
	                      <th>Start From</th>
	                      <th>End At</th>
                        <th>Status</th>
	                      <th>Date</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($discounts as $discount)
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td><a href="#edit{{ $discount->id }}" data-toggle="modal">{{ $discount->name }}</a></td>
		                    <td>{{ $discount->discount }}</td>
                        <td>{{ $discount->from }}</td>
                        <td>{{ $discount->to }}</td>
                        <td><span class="badge badge-{{ $discount->is_active == 1 ? 'success' : 'danger' }}">{{ $discount->is_active == 1 ? 'Active' : 'Inactive' }}</span></td>
                        <td>{{ $discount->created_at }}</td>

                        <!-- Modal -->
                        <div class="modal fade" id="edit{{ $discount->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <form action="{{ route('discount.update', $discount->id) }}" method="POST">
                                @csrf
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit - {{ $discount->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                               
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Name*</label>
                                      <input type="text" name="name" value="{{ $discount->name }}" class="form-control @error('name') is-invalid @enderror" required>
                                      @error('name')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Discount(%) *</label>
                                      <input type="text" value="{{ $discount->discount }}" name="discount" class="form-control @error('discount') is-invalid @enderror" required>
                                      @error('discount')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>Start From*</label>
                                      <input type="date" value="{{ $discount->from }}" name="from" class="form-control @error('from') is-invalid @enderror" required>
                                      @error('from')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label>End At*</label>
                                      <input type="date" value="{{ $discount->to }}" min="{{ date('Y-m-d') }}" name="to" class="form-control @error('to') is-invalid @enderror" required>
                                      @error('to')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                      @enderror
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label>Status</label>
                                      <select name="is_active" class="form-control">
                                        <option value="1" {{ $discount->is_active == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $discount->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                                      </select>
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
		                    
		                </tr>
		                
	                  @endforeach
                  </tbody>
                  <tfoot>
                  	<tr>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Discount %</th>
                        <th>Start From</th>
                        <th>End At</th>
                        <th>Status</th>
                        <th>Date</th>
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