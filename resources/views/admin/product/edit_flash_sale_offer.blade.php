@extends('admin.layouts.master')
@section('content')
<style>
    #result{height:600px;overflow:auto;overflow-x: hidden;}
    #product_text {font-size: 13px; text-align: left;}
    .my-custom-scrollbar {
        position: relative;
        height: 350px;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }

    .pd-name {
        font-size: 13px !important;
    }

    #product-item{
        border: 1px solid #2C2E3B;
        cursor: cell;
        border-radius: 5px;
    }

    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: hidden !important;
        
    }
    
    .list-group-item {
        position: relative;
        display: block;
        padding: 1px 1px !important;
        border: none !important;
    }
    
    .coursor_plus {
        cursor: cell;
    }
    .coursor_plus:hover {
        border: 2px solid #269E70;
    }
    
    i.fa.fa-plus.plus_icon {
        background-color: #30c78d;
        padding: 3px;
        color: #fff;
        border-radius: 50%;
        cursor: grab;
    }
</style>

 <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4 class="m-0 fw-bold"><b>Edit Flash Sale Offer</b></h4>
      </div><!-- /.col -->
      <div class="col-sm-6 text-right">
      </div>
    </div>
  </div>
</div>
<!-- /.content-header -->
<section class="content">
	<div class="container-fluid">
		<div class="card">
              <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="">
                            <div class="" id="products-tabs">
                                <div class="shadow p-2">
                                    <h5><b>Search Product</b></h5>
                                    <input type="text" class="form-control form-control-sm" placeholder="Search By Product Name" id="product_title">
                                    <div class="form-group row mt-2 d-none">
                                        <div class="input-group col-md-12">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            </div>
                                            <input type="text" class="form-control" placeholder="Barcode" autofocus="autofocus" id="product_barcode_search" name="">
                                        </div>
                                        <div id="barcode_spin_div" class="text-center p-2"></div>
                                    </div>
                                </div>
                                <div class="card card-primary card-outline" id="#mydiv">
                                    <div class="" id="result">
                                        <ul class="nav nav-pills flex-column push" id="myUL"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="">
                            <div class="">
                                <div class="table-responsive">
                                    <form action="{{route('flash.sale.update', optional($offer)->id)}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="table-wrapper-scroll-y my-custom-scrollbar shadow rounded">
                                            <table id="mainTable" class="table table-bordered table-sm">
                                                <thead>
                                                    <tr class="bg-success text-light">
                                                        <th style="padding: 10px 7px; width: 40%;">Product Info</th>
                                                        <th style=" width: 30%;padding: 10px 7px;">Discount Type</th>
                                                        <th style="padding: 10px 7px;">Discount Amount</th>
                                                        <th style="padding: 10px 7px; text-align: center;">X</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="demo" class="demo">
                                                    @if(count($offer->products) > 0)
                                                    @foreach($offer->products as $product)
                                                    <tr id="cart_tr{{$product->product_id}}">
                                                        <td>
                                                            <input type="hidden" name="pid[]" value="{{$product->product_id}}">
                                                            <input type="hidden" name="" id="check_id{{$product->product_id}}" value="{{$product->product_id}}">
                                                            
                                                            <h5 class="fw-bold mb-0">{{$product->product_info->title}}</h5>
                                                        </td>
                                                        <td>
                                                            <select name="discount_type[]" class="form-control" id="">
                                                                <option @if($product->product_info->discount_type == 'no') class="text-light bg-success" selected @endif  value="no">NO</option>
                                                                <option @if($product->product_info->discount_type == 'flat') class="text-light bg-success" selected @endif undefined="" value="flat">Flat</option>
                                                                <option @if($product->product_info->discount_type == 'percentage') class="text-light bg-success" selected @endif undefined="" value="percentage">Percentage</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number" value="{{optional($product->product_info)->discount_amount}}" required="" name="discount_amount[]" class="form-control" placeholder="Discount Amount" step="any">
                                                        </td>
                                                        <td class="text-center"><button type="button" onclick="remove_cart_tr({{$product->product_id}})" class="btn btn-danger btn-sm">X</button></td>
                                                    </tr>
                                                    @endforeach
                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="p-2">
                                            
                                        </div>
                                        
                                        <div class="p-1">
                                        <div class="shadow rounded p-2">
                                        
                                        <hr class="bg-warning">
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-check-label"><b><span class="text-danger">*</span>Title</b></label>
                                                    <input class="form-control" type="text" name="title" value="{{optional($offer)->title}}" required="">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-check-label"><b><span class="text-danger">*</span>Start Date & Time</b></label>
                                                    <input class="form-control" type="datetime-local" value="{{optional($offer)->start_date_time}}" name="start_date_time" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-check-label"><b><span class="text-danger">*</span>End Date & Time</b></label>
                                                    <input class="form-control" type="datetime-local" name="end_date_time" value="{{optional($offer)->end_date_time}}" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-check-label"><b>Image</b></label>
                                                    <input class="form-control" type="file" name="image">
                                                    <img src="{{ asset('/images/product/'.optional($offer)->image) }}" width="100%" class="shadow rounded p-1">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-check-label"><b><span class="text-danger">*</span>Active Status</b></label>
                                                    <select name="is_active" class="form-control" id="">
                                                        <option @if(optional($offer)->is_active == 0) class="text-light bg-success" selected @endif value="0">Inactive</option>
                                                        <option @if(optional($offer)->is_active == 1) class="text-light bg-success" selected @endif value="1">Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="place">Description</label>
                                                    <textarea name="description" id="" cols="30" class="form-control" rows="5">{{optional($offer)->description}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <a data-toggle="modal" data-target="#exampleModalForSell" class="btn btn-success text-right mr-3 btn-rounded">Submit</a>
                                        </div>
                                        
                                        </div>
                                        </div>
    
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalForSell" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div class="text-info" style="text-align:center;">
                                                            <i class="fas fa-shopping-cart" style="font-size: 60px;"></i>
                                                        </div>
                                                        <div>
                                                            <h2 class="text-center font-bold">Are You Sure?</h2>
                                                        </div>
                                                        <div>
                                                            <p class="text-center">You will not be able to recover this
                                                                content!</p>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 text-center">
                                                                <button type="submit" name="sellConfirm" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Confirm</button>
                                                                <button type="button" disabled="" class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                                            </div>
                                                            <div class="col-md-6 text-center"><button class="btn btn-danger" data-dismiss="modal">Cancel</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
	</div>
</section>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>


function myFunction(id, name, image, discount, discount_amount) {
    
    if($('#check_id'+id).val()) {
        alert("This Product is already added.");
    }
    else {
        var p, f, n = '';
        if(discount == 'percentage') {
            p = 'selected';
        }
        else if(discount == 'flat') {
            f = 'selected';
        }
        else {
            n = 'selected';
        }

        const cartDom = `<tr id="cart_tr`+id+`">
                            <td>
                                <input type="hidden" name="pid[]" value="`+id+`">
                                <input type="hidden" name="" id="check_id`+id+`" value="`+id+`">
                                
                                <h5 class="fw-bold mb-0">`+name+`</h5>
                            </td>
                            <td>
                                <select name="discount_type[]" class="form-control" id="">
                                    <option `+n+` value="no">NO</option>
                                    <option `+f+` value="flat">Flat</option>
                                    <option `+p+` value="percentage">Percentage</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" value="`+discount_amount+`" required name="discount_amount[]" class="form-control" placeholder="Discount Amount" step="any">
                            </td>
                            <td class="text-center"><button type="button" onclick="remove_cart_tr('`+id+`')" class="btn btn-danger btn-sm">X</button></td>
                        </tr>`;
                        
        $('#demo').prepend(cartDom);
    }
    
}

function remove_cart_tr(generated_id) {
    $('#cart_tr'+generated_id).remove();
}

//product search by product name
$('#product_title').keyup(function(){
    var title = $(this).val();
    $.ajax({
        type : 'get',
        url: '{{route('flash.sale.search.product')}}',
        data:{'title':title},
        success:function(data){
        $('#myUL').html(data);
        }
    });
});
//product search by product name



</script>
@endsection