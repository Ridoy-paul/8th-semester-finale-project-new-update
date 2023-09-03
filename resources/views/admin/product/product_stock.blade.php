@extends('admin.layouts.master')
@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Product Current Stock Info.</h1>
      </div>
     
    </div>
  </div>
</div>

<!-- /.content-header -->
<section class="content">
	<div class="container-fluid">
		<div class="card">
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
	                  <tr>
	                    <th width="5%">S.N</th>
	                    <th width="30%">Title</th>
                        <th>Price</th>
                        <th>Stock Qty</th>
	                    <th class="text-center">Action</th>
	                  </tr>
                  </thead>
                  <tbody>
	                  @foreach($stock_info as $stock_item)
                        <?php
                            $product_info = $stock_item->product_info;
                            $variation_info = '';
                            if($stock_item->color <> '') {
                                $variation_info .= '<span class="fw-bold text-danger">Color: '.optional($stock_item->color_info)->name.'</span>';
                            }

                            if($stock_item->variant <> '') {
                                $variation_info .= '<span class="fw-bold text-success">, '.optional($stock_item->attribute_info)->title.': '.optional($stock_item)->variant_output.'</span>';
                            }
                        ?>
                        @if(!is_null($product_info))
	                  	<tr>
		                    <td>{{ $loop->index + 1 }}</td>
		                    <td>
                                {{ optional($product_info)->title }} {!!$variation_info!!}
                            </td>
                            <td>{{number_format($stock_item->price, 2)}}</td>
                            <td>{{ $stock_item->qty }}</td>
		                    <td class="text-center">
		                    	<button type="button" class="btn btn-primary rounded-pill btn-sm" onclick="stock_change('{{$stock_item->id}}', '{{ $stock_item->qty }}', '{{ optional($product_info)->title }}')" data-toggle="modal" data-target="#exampleModal">Update Stock</button>
		                    </td>
		                </tr>
                        @endif
	                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- stock change Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="stock_change_modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('product.stock.qty.update')}}">
                            @csrf
                            <div class="form-group">
                              <label for="exampleInputEmail1">Stock quantity</label>
                              <input type="number" required min="0" class="form-control" name="stock_qty" id="modal_stock_qty">
                            </div>
                            <input type="hidden" name="stock_id" id="modal_stock_id" value="">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                    </div>
                    
                </div>
                </div>
            </div>

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
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  function stock_change(id, stock_qty, name) {
    $('#stock_change_modal_title').text(name);
    $('#modal_stock_id').val(id);
    $('#modal_stock_qty').val(stock_qty);

  }

</script>
@endsection