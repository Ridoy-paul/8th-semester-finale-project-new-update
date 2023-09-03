@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="m-0">Reward Point</h1>
      </div><!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">reward-point</li>
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
               <form action="{{ route('setting.reward.point.update', 1) }}" method="POST">
                 @csrf
                 <div class="row">
                   <div class="col-md-6">
                     <div class="form-group">
                      <label>Minimum Conversion Point</label>
                      <input type="number" name="minimum_point" value="{{ $setting->minimum_point }}" class="form-control @error('minimum_point') is-invalid @enderror">
                      @error('minimum_point')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="form-group">
                      <label>1 Tk Equivalent Point</label>
                      <input type="number" name="equivalent_point" value="{{ $setting->equivalent_point }}" class="form-control @error('equivalent_point') is-invalid @enderror">
                      @error('equivalent_point')
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