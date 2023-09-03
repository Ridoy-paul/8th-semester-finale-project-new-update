@extends('admin.layouts.master')
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Category</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active">edit-category</li>
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
              <div class="card-body">
                <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Category Title *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" value="{{ $category->title }}" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Parent Category</label>
                        <select name="parent_id" class="select2 form-control @error('parent_id') is-invalid @enderror">
                          <option value="0">Please Select a Parent Category</option>
                          @foreach($categories as $p_category)
                          <option value="{{ $p_category->id }}" {{ $category->parent_id == $p_category->id ? 'selected' : '' }}>{{ $p_category->title }}</option>
                            @foreach($p_category->child as $subcategory)
                                <option value="{{ $subcategory->id }}"  {{ $category->parent_id == $subcategory->id ? 'selected' : '' }}>->{{ $subcategory->title }}</option>
                            @endforeach
                          @endforeach
                        </select>
                        @error('parent_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Category Position *</label>
                        <input type="text" name="position" value="{{ $category->position }}" class="form-control @error('position') is-invalid @enderror" placeholder="Position" required>
                        @error('position')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-3 p-2">
                      <div class="form-group shadow rounded px-3">
                        <label for="">Is Featured</label>
                        <div class="">
                          <label for="yes" class=""><input class="" type="radio" id="yes" value="1" {{ $category->is_featured == 1 ? 'checked' : '' }} name="is_featured"> Yes</label>
                          <label for="no" class="ml-2"><input class="" type="radio" id="no" value="0" {{ $category->is_featured == 0 ? 'checked' : '' }} name="is_featured"> No</label>
                        </div>
                      </div>
                    </div>


                    <div class="col-md-3 p-1">
                      <div class="form-group shadow rounded px-3">
                        <label for="">Is Menu Active</label>
                        <div class="">
                          <label for="is_menu_yes" class=""><input class="" type="radio" id="is_menu_yes" {{ $category->is_menu_active == 1 ? 'checked' : '' }}  value="1" name="is_menu_active"> Active</label>
                          <label for="is_menu_no" class="ml-2"><input class="" type="radio" id="is_menu_no" {{ $category->is_menu_active == 0 ? 'checked' : '' }} value="0" name="is_menu_active"> Deactive</label>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Menu Positon</label>
                        <input type="text" name="menu_position" value="{{$category->menu_position}}" class="form-control @error('menu_position') is-invalid @enderror" placeholder="Menu Position">
                        @error('menu_position')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Thumbnail ( 160px X 160px )</label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="Image">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <img class="shadow rounded border p-1 mt-2" src="{{ asset('images/category/'.$category->image ) }}" width="70%">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Banner</label>
                        <input type="file" name="banner" class="form-control @error('banner') is-invalid @enderror" placeholder="banner">
                        @error('banner')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <img class="shadow rounded border p-1 mt-2" src="{{ asset('images/category/'.$category->banner ) }}" width="70%">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Active Status</label>
                        <select name="is_active" class="form-control" id="">
                          <option @if($category->is_active == 1) selected class="bg-success text-light" @endif value="1">Active</option>
                          <option @if($category->is_active == 0) selected class="bg-success text-light" @endif value="0">Deactive</option>
                        </select>
                      </div>
                    </div>
                   
                   
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Description *</label>
                        <textarea name="description" class="tinymce form-control @error('description') is-invalid @enderror" placeholder="Description">{{ $category->description }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-4">
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