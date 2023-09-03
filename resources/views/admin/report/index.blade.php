@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Reports</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Report</li>
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
                @if(Auth::user()->type == 1 || Auth::user()->type == 2)
                  <h3>Total Courses Sold : {{ count($enrollments) }}</h3>
                  <h3>Total Sales : ₱{{ $enrollments->sum('price') }}</h3>
                @endif
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <form action="{{ route('admin.report.search') }}" method="POST" class="p-2">
                  @csrf
                <div class="row">
                  @if(Auth::user()->type == 1)
                  <div class="col-md-6">
                      <div class="form-group">
                        <label>Instructor</label>
                        <select name="instructor_id" class="select2 form-control">
                          <option value="">Select an Instructor</option>
                          @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name . ' ' . $instructor->last_name }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                  @endif
                  <div class="col-md-{{ Auth::user()->type == 1 ? '6' : '4' }}">
                      <div class="form-group">
                        <label>Course</label>
                        <select name="course_id" class="select2 form-control">
                          <option value="">Select a Course</option>
                          @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                          @endforeach
                        </select>
                      </div>
                  </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Date From</label>
                        <input type="date" name="from" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Date To</label>
                        <input type="date" name="to" class="form-control">
                      </div>
                    </div>
                  <div>
                    
                  <div class="col-md-4">
                    <div class="form-group">
                      <label style="color: #fff;">..</label>
                      <button type="submit" class="btn btn-success">Search</button>
                    </div>
                  </div>
                  </div>
                </div>

                </form>
                <hr>
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
	                  <tr>
	                      <th>S.N</th>
	                      <th>Course</th>
	                   	  <th>Student</th>
	                      @if(Auth::user()->type == 1)
                          <th>Instructor</th>
                        @endif
                        
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
	                      <th>Date</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($enrollments as $enrollment)
                      @php
                        $referral_amount =  $enrollment->referral_id == NULL ? 0 : $enrollment->referral_amount;
                        
                      @endphp
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>{{ $enrollment->course->title }}</td>
		                    <td>{{ $enrollment->student->name . ' ' . $enrollment->student->last_name }}</td>
                        @if(Auth::user()->type == 1)
                          <td>{{ $enrollment->course->instructor->name . ' ' . $enrollment->course->instructor->last_name }}</td>
                        @endif
                        
                        <td>{{ $enrollment->transaction->payment_method }}</td>
                        <td>
                          <a href="{{ route('admin.invoice.show', $enrollment->transaction->id) }}" title="View Invoice">{{ $enrollment->transaction->transaction_id }}</a>
                        </td>
                        <td>{{ $enrollment->created_at }}</td>
		                    
		                </tr>
		                
	                  @endforeach
                  </tbody>
                  <tfoot>
                  	<tr>
                        <th>S.N</th>
                        <th>Course</th>
                        <th>Student</th>
                        @if(Auth::user()->type == 1)
                          <th>Instructor</th>
                        @endif
                        
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
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
    //Date range picker
    $('#reservation').daterangepicker();
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection