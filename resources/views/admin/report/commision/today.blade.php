@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">TAP Commission Report</h1>
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
                  <!-- <h3>Total Sale : {{ count($enrollments) }}</h3>
                  <h3>Total Sale Amount : ₱{{ $enrollments->sum('price') }}</h3>
                  <h4>Total VAT Amount : ₱{{ ($enrollments->sum('price') * (env('VAT')/100)) }}</h4> -->
                  @php
                    $today_tap = App\Enrollment::whereDate('created_at', Carbon\Carbon::today())->where('referral_id', Auth::id())->get();
                    $total_tap = App\Enrollment::where('referral_id', Auth::id())->get();
                  @endphp
                  <h3>Total Accumulated TAP Commission : ₱{{ $total_tap->sum('referral_amount') }}</h3>
                  <h3>Today's TAP Commision : ₱{{ $today_tap->sum('referral_amount') }}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <form action="{{ route('instructor.tap.search') }}" method="POST" class="p-2">
                  @csrf
                <div class="row">
                  
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Date From</label>
                        <input type="date" name="from" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Date To</label>
                        <input type="date" name="to" class="form-control" >
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
                <div class="table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Date Confirmed</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Payment</th>
                        <th>REF #</th>
                        <th>Instructor</th>
                        <th>Referral</th>
                        <th>Referral Commission</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($enrollments as $enrollment)
                      @php
                        $referral_amount =  $enrollment->referral_id == NULL ? 0 : $enrollment->referral_amount;
                        
                      @endphp
                      <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $enrollment->created_at }}</td>
                        <td>{{ $enrollment->user->name . ' ' . $enrollment->user->last_name }}</td>
                        <td>{{ $enrollment->course->title }}</td>
                        <td>PayPal</td>
                        <td>
                          {{ $enrollment->transaction->transaction_id }}
                        </td>
                        <td>{{ $enrollment->course->user->name . ' ' . $enrollment->course->user->last_name }}</td>
                        <td>{{ $enrollment->refer->email }}</td>
                        <td>{{ $enrollment->referral_amount }}</td>
                        
                    </tr>
                    
                    @endforeach
                  </tbody>
                </table>
              </div>
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