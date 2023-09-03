@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Affiliate Configuration</h1>
      </div><!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">affiliate-configuration</li>
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
               <form action="{{ route('affiliate.config.update', 1) }}" method="POST">
                 @csrf
                 <div class="row">
                   <div class="col-md-12">
                     <div class="form-group">
                      <label>Commision (%)</label>
                      <input type="number" name="affiliate_commision" value="{{ $setting->affiliate_commision }}" class="form-control @error('affiliate_commision') is-invalid @enderror">
                      @error('affiliate_commision')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                     </div>
                   </div>
                   <div class="col-md-12">
                     <div class="form-group">
                      <button class="btn btn-primary">Save Changes</button>
                     </div>
                   </div>
                 </div>
               </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
	</div>
</section>
@endsection

@section('scripts')
	<script>
  
</script>
@endsection