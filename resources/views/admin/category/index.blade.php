@extends('admin.layouts.master')
@section('content')

<!-- /.content-header -->
<section class="content">
	<div class="container-fluid">
		<div class="card mt-4">
      <div class="card-header">
        <div class="row">
          <div class="col-md-6">
            <h2 class="m-0"><b>Category List</b></h2>
          </div>
          <div class="col-md-6 text-right">
            <a href="{{ route('category.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Category</a>
          </div>
        </div>
        
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive">
        <table id="example2" class="table table-bordered">
          <thead>
            <tr>
              <th>Title</th>
              <th>Position</th>
              <th width="5%">Action</th>
              <th width="60%">Sub Category</th>
            </tr>
          </thead>
          <tbody>
            
            
            @foreach($categories as $category)
              <tr>
                <td>
                  {{ $category->title }} <br><img class="shadow rounded p-1" src="{{ asset('images/category/'.$category->image ) }}" width="50px">
                  <br>
                  @if($category->is_featured == 1)
                    <span class="badge bg-success">Featured</span>
                  @else
                    <span class="badge bg-danger">Not Featured</span>
                  @endif

                  @if($category->is_menu_active == 1)
                    <br><span class="badge bg-success">Active Menu</span>
                  @else
                    <br><span class="badge bg-danger">Not Active Menu</span>
                  @endif
                  @if($category->is_active == 1)
                    <br><span class="badge bg-success">Active</span>
                  @else
                    <br><span class="badge bg-danger">Deactivated</span>
                  @endif
                  
                </td>
                <td>
                  {{ $category->position }}

                  
                </td>
                <td>
                  <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary btn-sm mb-2" title="Edit"><i class="fas fa-edit"></i></a>
                  <a href="#deleteModal{{ $category->id }}" class="btn btn-danger btn-sm mb-2" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
                </td>
                <td>
                  @if(count($category->child) > 0)
                  <table class="table">
                    <thead class="bg-dark text-light">
                      <tr>
                        <th width="30%">Name</th>
                        <th scope="col">Action</th>
                        <th width="63%" scope="col">Inner Sub Categories</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($category->child as $p_category)
                        <tr>
                          <td>
                            {{ $p_category->title }}
                            <br>
                            @if($p_category->is_featured == 1)
                              <span class="badge bg-success">Featured</span>
                            @else
                              <span class="badge bg-danger">Not Featured</span>
                            @endif
                            @if($p_category->is_menu_active == 1)
                              <br><span class="badge bg-success">Active Menu</span>
                            @else
                              <br><span class="badge bg-danger">Not Active Menu</span>
                            @endif
                            @if($p_category->is_active == 1)
                              <br><span class="badge bg-success">Active</span>
                            @else
                              <br><span class="badge bg-danger">Deactivated</span>
                            @endif
                          </td>
                          <td>
                            <a href="{{ route('category.edit', $p_category->id) }}" class="btn btn-primary btn-sm mb-2" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="#deleteModal{{ $p_category->id }}" class="btn btn-danger btn-sm mb-2" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
                            <!-- Delete Category Modal -->
                              <div class="modal fade" id="deleteModal{{ $p_category->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body" align="center">
                                          <h3 class="fw-bold my-5"><b>Are tou sure you want to delete?</b></h3>
                                            <form action="{{ route('category.destroy', $p_category->id) }}" method="POST">
                                                @csrf
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Permanent Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </td>
                          <td>
                            @if(count($p_category->child) > 0)
                              <table class="table">
                                <tbody>
                                  @foreach($p_category->child as $inner_sub_category)
                                    <tr>
                                      <td>
                                        {{ $inner_sub_category->title }}
                                        <br>
                                        @if($inner_sub_category->is_featured == 1)
                                          <span class="badge bg-success">Featured</span>
                                        @else
                                          <span class="badge bg-danger">Not Featured</span>
                                        @endif
                                        @if($inner_sub_category->is_menu_active == 1)
                                          <br><span class="badge bg-success">Active Menu</span>
                                        @else
                                          <br><span class="badge bg-danger">Not Active Menu</span>
                                        @endif
                                        @if($inner_sub_category->is_active == 1)
                                          <br><span class="badge bg-success">Active</span>
                                        @else
                                          <br><span class="badge bg-danger">Deactivated</span>
                                        @endif
                                        
                                      </td>
                                      <td>
                                        <a href="{{ route('category.edit', $inner_sub_category->id) }}" class="btn btn-primary btn-sm mb-2" title="Edit"><i class="fas fa-edit"></i></a>
                                        <a href="#deleteModal{{ $inner_sub_category->id }}" class="btn btn-danger btn-sm mb-2" data-toggle="modal" title="Delete"><i class="fas fa-trash"></i></a>
                                        <!-- Delete Category Modal -->
                                          <div class="modal fade" id="deleteModal{{ $inner_sub_category->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body" align="center">
                                                      <h3 class="fw-bold my-5"><b>Are tou sure you want to delete?</b></h3>
                                                        <form action="{{ route('category.destroy', $inner_sub_category->id) }}" method="POST">
                                                            @csrf
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger">Permanent Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                      </td>
                                     
                                    </tr>
                                    @endforeach
                                </tbody>
                              </table>
                            @else
                            <h6 class="text-center"><b>No Inner Sub Category Found</b></h6>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                  @else
                    <h4 class="text-center"><b>No Sub Category Found</b></h4>
                  @endif
                </td>
            </tr>

            <!-- Delete Category Modal -->
                <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body" align="center">
                              <h3 class="fw-bold my-5"><b>Are tou sure you want to delete?</b></h3>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Permanent Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
          </tbody>
          
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
  // $(function () {
  //   $("#example1").DataTable({
  //     "responsive": true, "lengthChange": false, "autoWidth": false,
  //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
  //   }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  //   $('#example2').DataTable({
  //     "paging": true,
  //     "lengthChange": false,
  //     "searching": true,
  //     "ordering": true,
  //     "info": true,
  //     "autoWidth": false,
  //     "responsive": true,
  //   });
  // });
</script>
@endsection