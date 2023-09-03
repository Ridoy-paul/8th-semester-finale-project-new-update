@extends('admin.layouts.master')
@section('content')
  <!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Product</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('home') }}" target="_blank">Home</a></li>
          <li class="breadcrumb-item active">Product</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<style>
	#category_item {
		height: 200px;
		overflow: auto;
		overflow-x: hidden;
	}

	.list-group-item {
		padding: 0px !important;
		border:none !important;
	}
</style>

<section class="content">
  <div class="container-fluid">
	<div class="card">
		<div class="card-header">
			<form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
		      @csrf

				<div class="row">
					<div class="form-group col-md-12">
						<label class="col-form-label"><b>Title *</b></label>
						<div class="">
						<input type="text" name="title" value="{{$product->title}}" class="form-control @error('title') is-invalid @enderror" required>
							@error('title')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-8">
								<div class="row">
									<div class="form-group col-md-6">
										<label class="col-form-label"><b>Brand</b> {{$product->id}}</label>
										<div class="">
											<select name="brand_id" class="select2 form-control @error('brand_id') is-invalid @enderror">
												<option value="">Please Select a Brand</option>
												@foreach($brands as $brand)
												<option  @if($brand->id == $product->brand_id) selected class="text-light bg-success" @endif value="{{ $brand->id }}" {{ $brand->id == old('brand_id') ? 'selected' : '' }}>{{ $brand->title }}</option>
												@endforeach
											</select>
											@error('brand_id')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
				
									<div class="form-group col-md-6">
										<label class="col-form-label"><b>Unit Type *</b></label>
										<div class="">
										<input type="text" name="unit_type" required placeholder="Piece" value="{{ $product->unit_type }}" class="form-control @error('unit_type') is-invalid @enderror">
											@error('unit_type')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"><b>Thumbnail *</b></label>
											<div class="col-sm-10">
											  <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
												@error('image')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
												<img src="{{ asset('images/product/'.$product->thumbnail_image) }}" class="shadow rounded mt-2 p-1" width="150px">
											</div>
										</div>
						
										<div class="form-group row">
											<label class="col-sm-2 col-form-label"><b>Gallery *</b></label>
											<div class="col-sm-10">
											  <input type="file" name="gallery[]" class="form-control @error('gallery') is-invalid @enderror" multiple>
												@error('gallery')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
												@foreach($product->product_image as $image)
													<img src="{{ asset('images/product/'.$image->image) }}" class="shadow rounded mt-2 p-1" width="150px" style="margin-right: 15px;">
												@endforeach
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="col-md-4">
								<div class="shadow rounded p-2 border border-success mb-3">
									<h5 class="fw-bold border-bottom">Select Categories</h5>
									<div id="category_item">
										<ul class="list-group list-group-unbordered p-2" id="">
											@foreach($categories as $category)
											<?php
												$check_category = DB::table('product_with_categories')->where(['category_id'=>$category->id, 'product_id'=>$product->id])->first();
											?>
											<li class="list-group-item itemss">
												<label for="category_{{$category->id}}"><input type="checkbox" @if(!is_null($check_category)) checked @endif name="categories[]" value="{{$category->id}}" id="category_{{$category->id}}"> {{ $category->title }}</label>
											</li>
											@endforeach
										  </ul>
									</div>
								</div>
							</div>
						</div>
					</div>

					{{-- <div class="form-group col-md-4">
						<label class="col-form-label"><b>Category *</b></label>
						<div class="">
							<select id="category_id" required name="category_id" class="select2 js-example-basic-multiple form-control @error('category_id') is-invalid @enderror">
								<option value="">Please Select a Category</option>
								@foreach($categories as $category)
									<option @if($category->id == $product->category_id) selected class="text-light bg-success" @endif value="{{ $category->id }}">{{ $category->title }}</option>
									@foreach($category->child as $subcategory)
										<option @if($subcategory->id == $product->category_id) selected class="text-light bg-success" @endif value="{{ $subcategory->id }}">->{{ $subcategory->title }}</option>
										@foreach($subcategory->child as $sub_subcategory)
											<option @if($sub_subcategory->id == $product->category_id) selected class="text-light bg-success" @endif value="{{ $sub_subcategory->id }}">-->{{ $sub_subcategory->title }}</option>
										@endforeach
									@endforeach
								@endforeach
							</select>
							@error('category_id')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div> --}}

					<div class="col-md-12 my-3">
						<div class="row shadow rounded p-2">
							<div class="col-md-12 row">
								<label class="col-form-label"><b>Type</b></label>
								<div class="">
									<div class="form-group">
										<div class="form-check form-check-inline bg-primary ml-2 px-3 p-2 rounded-pill text-light">
											<input class="form-check-input" type="radio" name="type" {{ $product->type == 'single' ? 'checked' : '' }} id="for_single" value="single" required="">
											<label class="form-check-label" for="for_single">Single</label>
										</div>
										<div class="form-check form-check-inline bg-success px-3 ml-2 p-2 rounded-pill text-light">
											<input class="form-check-input" type="radio" name="type" {{ $product->type == 'variation' ? 'checked' : '' }} id="for_variation" value="variation">
											<label class="form-check-label" for="for_variation">Variation</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2"></div>
							<div class="col-md-10">
								<div id="variation" class="my-2" style="{{ $product->type == 'variation' ? '' : 'display: none;' }}">
									
									<div class="shadow p-2 rounded">
										<div id="variations_div" class=" p-2">
											@if(count($product->variation_stock) > 0)
											@foreach($product->variation_stock as $variation)
											<div class="row p-2 shadow rounded mb-4" id="variation_info_div_{{$variation->id}}">
												<input type="hidden" id="variation_parent{{$variation->id}}" name="variation_parent[]" value="{{$variation->id}}">
												<input type="hidden" name="colour_attribute[]" value="{{$variation->color}}">
												<input type="hidden" name="new_or_old[]" value="old">
												  <div class="col-md-6">
													<div>
														@if(!empty($variation->color))<div class="p-2 shadow rounded"><b>Colour: </b> <span style="background-color: {{optional($variation->color_info)->code}}; padding: 5px;">{{optional($variation->color_info)->name}}</span></div><br>@endif
														
														<div>
															<input type="hidden" name="attribute_id[]" value="{{$variation->variant}}">
															<input type="hidden" name="attribute_id{{$variation->id}}" value="{{$variation->variant}}">
															@if($variation->variant != '')	
																<label><span class="text-danger">*</span>{{optional($variation->attribute_info)->title}}</label>
																<input type="text" class="form-control" name="attribute_value[]" value="{{$variation->variant_output}}" required="">
															@else 
															<input type="hidden" name="attribute_value[]">
															@endif
														</div>
													</div>
													<div class="form-group">
														<label class="col-form-label"><span class="text-danger">*</span><b>Status</b></label>
														<select name="is_active[]" class="form-control" id="">
															<option @if($variation->is_active == 1) class="text-light bg-success" selected @endif value="1">Active</option>
															<option @if($variation->is_active == 0) class="text-light bg-success" selected @endif value="0">Deactive</option>
															<option value="2">Delete</option>
														</select>
													  </div>
												  </div>
												  <div class="col-md-6 shadow rounded border p-1 px-4">
													  <div class="form-group">
														<label class="col-form-label"><b>Image</b></label>
														<input type="file" name="variation_image{{$variation->id}}" class="form-control">
														<img src="{{ asset('images/product/'.$variation->image) }}" class="shadow rounded mt-2 p-1" width="150px" style="margin-right: 15px;">
													</div>
													  
													  <div class="form-group">
														<label class="col-form-label"><span class="text-danger">*</span><b>Variant Price</b></label>
														<input type="number" name="variant_price[]" value="{{$variation->price}}" class="form-control" step="any">
													  </div>
													  
													  <div class="form-group">
														<label class="col-form-label"><span class="text-danger">*</span><b>Stock Quantity</b></label>
														<input type="number" name="variation_stock_qty[]" value="{{$variation->qty}}" class="form-control">
													  </div>
													  
												  </div>
											  </div>
											  @endforeach
											  @endif
											
										</div>
										<div class="text-right">
											<button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#exampleModal">Add New Variation</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-12 my-3">
					<div id="single" class="shadow rounded p-2 border row" style="{{ $product->type == 'single' ? '' : 'display: none;' }}">
						<div class="form-group col-md-6">
							<label class=""><b>Price *</b></label>
							
							<input type="number" step="any" name="single_price" value="{{ optional($product->single_stock)->price }}" class="form-control @error('price') is-invalid @enderror">
								@error('price')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							
						</div>
					
						<div class="form-group col-md-6">
							<label class="col-form-label"><b>Stock Quantity *</b></label>
							
							<input type="number" step="any" name="single_qty" value="{{ optional($product->single_stock)->qty  }}" class="form-control @error('qty') is-invalid @enderror">
								@error('qty')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							
						</div>
					</div>
					</div>
					<div class="col-md-6 my-3">
						<div class="shadow p-2">
							<div class="form-group">
								
								<label for="is_featured" class="mr-3">
									<input type="checkbox" name="is_featured" value="1" {{ $product->is_featured == 1 ? 'checked' : '' }} id="is_featured">
									Featured Products
								</label>

								<label for="is_tranding" class="mr-3">
									<input type="checkbox" name="is_tranding" value="1" {{ $product->is_tranding == 1 ? 'checked' : '' }} id="is_tranding">
									Tranding Product
								</label>

								<label for="todays_deal" class="mr-3">
									<input type="checkbox" name="todays_deal" value="1" {{ $product->todays_deal == 1 ? 'checked' : '' }} id="todays_deal">
									Today's Deal
								</label>

							</div>

						</div>
					</div>
					<div class="col-md-12 my-3 mb-5">
						<div class="shadow row">
							<div class="form-group col-md-4">
								<label class="col-form-label"><b>Code</b></label>
								<div class="">
								<input type="text" name="code" value="{{ $product->code }}" class="form-control @error('code') is-invalid @enderror">
									@error('code')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
							<div class="form-group col-md-4">
								<label class="col-form-label"><b>Discount Type</b></label>
								<select name="discount_type" class="form-control" id="">
									<option @if($product->discount_type == 'no') selected class="text-light bg-success" @endif value="no">NO</option>
									<option @if($product->discount_type == 'flat') selected class="text-light bg-success" @endif value="flat">Flat</option>
									<option @if($product->discount_type == 'percentage') selected class="text-light bg-success" @endif value="percentage">Percentage</option>
								</select>
								
							</div>
							<div class="form-group col-md-4">
								<label class="col-form-label"><b>Discount Amount</b></label>
								<input type="number" name="discount_amount" value="{{ $product->discount_amount }}" class="form-control @error('discount_amount') is-invalid @enderror">
							</div>
							
						</div>
					</div>

					<div class="form-group col-md-12">
						<label class="col-form-label"><b>Features</b></label>
						<div class="">
							<textarea class="form-control @error('feature') is-invalid @enderror" name="feature">{{ $product->feature }}</textarea>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label class="col-form-label"><b>Description *</b></label>
						<div class="">
							<textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ $product->description }}</textarea>
							@error('description')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>
					</div>
				</div>

				<div class="col-md-12 p-2">
					<div class="row shadow rounded border p-2">
						<div class="col-md-12"><h3><b>Meta Info for SEO</b></h3></div>
						<div class="col-md-12">
							<div class="form-group">
							<label>Meta Title</label>
							<input type="text" name="meta_title" value="{{$product->meta_title}}" class="form-control @error('meta_title') is-invalid @enderror">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
							<label>Meta Keywords</label>
							<input type="text" name="meta_keywords" value="{{$product->meta_keywords}}" class="form-control @error('meta_keywords') is-invalid @enderror">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
							<label>Meta Tags</label>
							<input type="text" name="tags" value="{{$product->tags}}" class="form-control @error('tags') is-invalid @enderror">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
							<label>Meta Description</label>
							<textarea name="meta_description" class="form-control" id="" cols="30" rows="10">{{$product->meta_description}}</textarea>
							</div>
						</div>
					</div>
				</div>

				  <div class="form-group col-md-12 text-right">
					<button type="submit" class="btn btn-primary">Save Changes</button>
				  </div>

				</div>

		    </form>
		</div>	
	</div>
  </div>
</section>


<!-- Variation Modal -->
<div class="modal fade text-left" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		  <form action="" method="POST" id="variation_form">
			  @csrf
		<div class="modal-header bg-dark">
		  <h5 class="modal-title text-light" id="exampleModalLabel">Add New Variation</h5>
		  <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-6">
				<div class="form-group">
				  <label for="exampleFormControlSelect1">Colors</label>
				  <select class="form-control" name="colour" id="">
				  <option value="">Select Colour</option>
					@foreach($colors as $key => $color)
						<option style="background-color: {{$color->code}};" value="{{$color->code}}">{{$color->name}} </option>
					@endforeach
				  </select>
				</div>
			  </div>
			  <div class="col-md-6">
				<div class="form-group">
					<label class=""><b>Variation Attribute</b></label>
					<select name="attribute" class="select2 form-control">
						<option value=""> -- Select Attribute --</option>
						@foreach($variations as $variation)
						<option value="{{ $variation->id }}">{{ $variation->title }}</option>
						@endforeach
					</select>
				</div>
			  </div>
			</div>
			
		</div>
		<div class="modal-footer">
		   <span id="variation_loading" style="display: none;">Loading....</span>
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  <button type="button" id="add_variation_button" class="btn btn-primary">Generate Variation</button>
		</div>
		</form>
	  </div>
	</div>
  </div>



@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $("input[type='radio']").change(function() {
            if ($(this).val() == "variation") {
                $("#variation").show();
            } 
            else {
                $("#variation").hide();
            }

            if ($(this).val() == "single") {
                $("#single").show();
            } 
            else {
                $("#single").hide();
            }
        });

		$('#add_variation_button').click(function(e){
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $.ajax({
                url: "{{route('product.generate.variation')}}",
                method: 'post',
                data: $('#variation_form').serialize(),
                beforeSend: function() {
                    $('#variation_loading').show();
                },
                success: function(data){
                    $('#variation_loading').hide();
                    
                    if(data.status == 'not_selected') {
                        alert("No Variation Attribute Selected.");
                    }
                    else if(data.status == 'yes' && data.code != '') {
                        if($('#variation_parent'+data.code).val()) {
                            alert("This Variation is Alerady Exist!");
                        }
                        else {
                            $('#variations_div').append(data.output);
                        }
                    }
                    else {
                        alert("No Variation Attribute Selected.");
                    }
                    
                }
            });
        });

    });

	$('#choice_attributes').on('change', function() {
		$('#customer_choice_options').html(null);
		$.each($("#choice_attributes option:selected"), function(){
            add_more_customer_choice_option($(this).val(), $(this).text());
        });
	});

	function add_more_customer_choice_option(i, name){
        $('#customer_choice_options').append('<div class="form-group col-md-6"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="'+i+'"><input type="text" class="form-control" name="choice[]" value="'+name+'" placeholder="Choice Title" readonly></div><div class="col-md-8"><input type="text" class="form-control" data-role="tagsinput" name="choice_options_'+i+'[]" placeholder="Enter choice values"></div></div>');
    }

	function remove_variation_div(generated_id) {
        $('#variation_info_div_'+generated_id).remove();
    }

</script>
@endsection

