@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Invoice</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('index') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Invoice</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- <div class="callout callout-info">
              <h5><i class="fas fa-info"></i> Note:</h5>
              This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div> -->


            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                  <img src="{{ asset('images/website/logo.png') }}" width="200">
                    <small class="float-right" style="float: right;">Date: {{ $transaction->created_at }}</small>
                  </h4><br>
                </div><br>
                
                  <hr style="color: #800020;">
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  
                  <address>
                   From: <strong>{{ env('APP_NAME') }}</strong><br>
                    Country : Phillipines<br>
                    Phone:  +63 9458823769<br>
                    Email: 
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  
                  <address>
                    To: <strong>{{ $transaction->enrollment[0]->student->name }} {{ $transaction->enrollment[0]->student->last_name }}</strong><br>
                    Country : {{ $transaction->enrollment[0]->student->country }}<br>
                    Phone: {{ $transaction->enrollment[0]->student->phone }}<br>
                    Email: {{ $transaction->enrollment[0]->student->email }}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #teaca-{{ $transaction->id }}</b><br>
                  <b>Transaction ID:</b> {{ $transaction->transaction_id }}<br>
                  <b>Payment Method:</b> {{ $transaction->payment_method }}
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>S.N</th>
                        <th>Course</th>
                        <th>Instructor</th>
                        <th>Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($transaction->enrollment as $enrollment)
                        <tr>
                          <td>{{ $loop->index + 1 }}</td>
                          <td>{{ $enrollment->course->title }}</td>
                          <td>{{ $enrollment->course->instructor->name }} {{ $enrollment->course->instructor->last_name }}</td>
                          <td>₱{{ $enrollment->price }}</td>
                        </tr>
                      @endforeach
                      <tr>
                        <td colspan="3" align="right">VAT({{ env('VAT') }}%):</td>
                        <td>₱{{ $transaction->enrollment->sum('price') * (env('VAT') / 100 ) }}</td>
                      </tr>
                      <tr>
                        <td colspan="3" align="right">Total:</td>
                        <td>₱{{ $transaction->enrollment->sum('price') }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  
                  <a href="{{ route('admin.invoice.generate', $transaction->id) }}" class="btn btn-primary float-right" style="margin-right: 5px;"><i class="fas fa-download"></i> Generate PDF</a>
                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
	<script>
    //Date range picker
    $('#reservation').daterangepicker();
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection