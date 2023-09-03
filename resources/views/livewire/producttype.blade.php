<div>
    <div class="form-group row">
    	
	    <label class="col-sm-2 col-form-label"><b>Variations * </b></label>
	    <div class="col-sm-10">
	    	<!-- <select wire:model="selected_variations" name="variation_id[]" class="select2 form-control @error('variation_id') is-invalid @enderror" multiple>
	    		<option value="">Please Select Variations</option>
	    		@foreach($variations as $variation)
	    		<option value="{{ $variation->id }}" {{ $variation->id == old('variation_id') ? 'selected' : '' }}>{{ $variation->title }}</option>
	    		@endforeach
	    	</select> -->
	    	@foreach($variations as $variation)
		       <label class="inline-flex items-center">
				      <input type="checkbox" name="variation_id[]" value="{{ $variation->id }}" wire:model="selected_variations"  class="form-checkbox">
		                   <span class="mr-3 text-sm">{{ $variation->title }}</span>
		               </label>
			@endforeach
            @error('variation_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

	            <!-- <div class="mt-4 form-group row">
				    <label class="col-sm-2 col-form-label"><b>Size *</b></label>
				    <div class="col-sm-10">
				      <input type="text" class="form-control" data-role="tagsinput" name="size" required>
				    </div>
				</div> -->
	            @foreach($selected_variations as $variation)
	            <div class="mt-4 form-group row">
				    <label class="col-sm-2 col-form-label"><b>{{ App\Models\Variation::find($variation)->title }} *</b></label>
				    <div class="col-sm-10">
				      <input type="text" wire:model="options{{$loop->index}}" class="form-control" data-role="tagsinput" name="variation[{{ $loop->index }}]" required>
				    </div>
				    
				    {{ ${"options" . $loop->index} }}
				</div>
				@endforeach
				<div class="mt-4 form-group row">
				    <div class="table-responsive">
				    	<table class="table table-bordered table-hover">
				    		<thead>
				    			<tr>
				    				<th>Variant</th>
				    				<th>Price</th>
				    				<th>Wholesale Price</th>
				    				<th>Qty</th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			<tr>
				    				<td>
				    					<label>s-Green</label>
				    					<input type="hidden" name="variant[]" class="form-control" value="s-green">
				    				</td>
				    				<td>
				    					<input type="text" name="v_price[]" class="form-control">
				    				</td>
				    				<td>
				    					<input type="text" name="v_wholesale_price[]" class="form-control">
				    				</td>
				    				<td>
				    					<input type="text" name="v_qty[]" class="form-control">
				    				</td>
				    			</tr>
				    			<tr>
				    				<td>
				    					<label>m-Green</label>
				    					<input type="hidden" name="variant[]" class="form-control" value="m-green">
				    				</td>
				    				<td>
				    					<input type="text" name="v_price[]" class="form-control">
				    				</td>
				    				<td>
				    					<input type="text" name="v_wholesale_price[]" class="form-control">
				    				</td>
				    				<td>
				    					<input type="text" name="v_qty[]" class="form-control">
				    				</td>
				    			</tr>
				    		</tbody>
				    	</table>
				    </div>
				</div>
			</div>
	    </div>
	</div>
</div>
