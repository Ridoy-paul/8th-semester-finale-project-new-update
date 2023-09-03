@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Sliders</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header text-light bg-dark">
        <h5 class="modal-title" id="exampleModalLabel">Add New Slider</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label><span class="text-danger">*</span>Title</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
                @error('title')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label><span class="text-danger">*</span>Serial Number</label>
                <input type="text" name="serial_number" class="form-control" required>
                @error('serial_number')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
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
              <div class="form-group">
                <label>Link</label>
                <input type="text" name="link" class="form-control @error('link') is-invalid @enderror">
                @error('link')
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
        <button type="button" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Create New Slider</button>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive">
        <table id="example2" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th width="5%">S.N</th>
              <th width="30%">Title</th>
              <th width="7%">Image</th>
              <th width="5%">Status</th>
              <th width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
            
            @foreach($sliders as $slider)
              <tr>
                <td>{{ $slider->serial_number }}</td>
                <td>{{ $slider->title }}</td>
                <td><img class="shadow rounded border p-1" src="{{ asset('images/slider/'.$slider->image ) }}" width="100%"></td>
                <td>
                  @if($slider->is_active == 1)
                  <span class="badge badge-success">Active</span>
                  @else
                  <span class="badge badge-danger">Deactive</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                  <a href="#deleteModal{{ $slider->id }}" class="btn btn-danger" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            @endforeach
          </tbody>
          
        </table>
      </div>
      <!-- /.card-body -->
    </div>

    </div>
    <!-- /.card -->
	</div>
</section>
@endsection

@section('scripts')
	<script>
  
</script>
@endsection