@extends('layouts.master')

@section('title')
	{{ ('All Products') . ' | '. env('APP_NAME') }}
@endsection

@section('content')

	<!-- Start of Main -->
        <main class="main">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <li><a href="{{ route('products') }}">Home</a></li>
                        <li>All Products</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <!-- Start of Shop Banner -->
                    <div class="shop-default-banner shop-boxed-banner banner d-flex align-items-center mb-6"
                    style="background-image: url({{ asset('images/website/'.$page->image)  }}); background-color: #FFC74E;">
                        <div class="container banner-content" style="height: 150px;">
                            
                        </div>
                    </div>
                    <!-- End of Shop Banner -->

                    

                    <!-- Start of Shop Content -->
                    <div class="shop-content row gutter-lg mb-10">
                        <!-- Start of Sidebar, Shop Sidebar -->
                        <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
                            <!-- Start of Sidebar Overlay -->
                            <div class="sidebar-overlay"></div>
                            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

                            <form action="" method="GET">
                                @csrf
                                <!-- Start of Sidebar Content -->
                                <div class="sidebar-content scrollable">
                                    <!-- Start of Sticky Sidebar -->
                                    <div class="sticky-sidebar">
                                        <div class="filter-actions">
                                            <label>Filter :</label>
                                            <!-- <a href="#" class="btn btn-dark btn-link filter-clean">Clean All</a> -->
                                        </div>
                                        <!-- Start of Collapsible widget -->
                                        <div class="widget widget-collapsible">
                                            <h3 class="widget-title"><span>Categories</span></h3>
                                            <ul class="widget-body filter-items item-check ">
                                                <li><label><input type="radio" name="category" value="all" checked> ALL</label></li>
                                                @foreach(App\Models\Category::where('is_active', 1)->where('parent_id', 0)->orderBy('position', 'ASC')->get() as $category)
                                                <li><label><input type="radio" name="category" value="{{ $category->id }}"> {{ $category->title }}</label></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- End of Collapsible Widget -->

                                        <!-- Start of Collapsible Widget -->
                                        <div class="widget widget-collapsible">
                                            <h3 class="widget-title"><span>Brand</span></h3>
                                            <ul class="widget-body filter-items item-check mt-1">
                                                <li><label><input type="radio" name="brand" value="all" checked> ALL</label></li>
                                                @foreach(App\Models\Brand::where('is_active', 1)->orderBy('id', 'DESC')->get() as $brand)
                                                <li><label><input type="radio" name="brand" value="{{ $brand->id }}"> {{ $brand->title }}</label></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- End of Collapsible Widget -->

                                        <!-- Start of Collapsible Widget -->
                                        <div class="widget widget-collapsible">
                                            <h3 class="widget-title"><span>Price</span></h3>
                                            <div class="widget-body">
                                                <ul class="filter-items search-ul">
                                                    <!-- <li><input type="range" name="range" min="0" max="5000"></li> -->
                                                    
                                                    <!-- <p>{{ env('CURRENCY') }}<span id="min_price">0</span> {{ env('UAE_CURRENCY') }} - {{ env('CURRENCY') }}<span id="max_price">5000</span> {{ env('UAE_CURRENCY') }}</p> -->
                                                   
  <fieldset class="filter-price">
   
    <div class="price-field">
      <input type="range"  min="{{ $min_price }}" max="{{ $max_price }}" value="{{ $min_price }}" id="lower">
      <input type="range"  min="{{ $min_price }}" max="{{ $max_price }}" value="{{ $max_price }}" id="upper">
    </div>
     <div class="price-wrap">
      <div class="price-wrap-1">
        <label for="one">{{ env('CURRENCY') }}</label>
        <input id="one">
        <label for="two">{{ env('UAE_CURRENCY') }}</label>
      </div>
      <div class="price-wrap_line">-</div>
      <div class="price-wrap-2">
        <label for="two">{{ env('CURRENCY') }}</label>
        <input id="two">
        <label for="two">{{ env('UAE_CURRENCY') }}</label>
      </div>
    </div>
    <a class="btn btn-primary" onclick="product_price_filter()" style="color: #fff;">FILTER</a>
  </fieldset> 

                                                </ul>
                                                
                                            </div>
                                        </div>
                                        <!-- End of Collapsible Widget -->

                                        
                                    </div>
                                    <!-- End of Sidebar Content -->
                                </div>
                                <!-- End of Sidebar Content -->
                            </form>
                        </aside>
                        <!-- End of Shop Sidebar -->

                        <!-- Start of Shop Main Content -->
                        <div class="main-content">
                            
                            <div class="product-wrapper row cols-lg-4 cols-md-3 cols-sm-2 cols-2" id="product_filtered">
                                @foreach($products as $product)
                                @include('partials.product')
                                @endforeach
                            </div>

                            <div class="toolbox toolbox-pagination justify-content-between">
                                <ul class="pagination">
                                    {{ $products->links('pagination::bootstrap-4') }}
                                </ul>
                            </div>
                        </div>
                        <!-- End of Shop Main Content -->
                    </div>
                    <!-- End of Shop Content -->
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("input[type='radio']").change(function() {
            
            var category_id = $("input[name='category']:checked").val();
            var brand_id = $("input[name='brand']:checked").val();
            var min_price = $('#lower').val();
            var max_price = $('#upper').val();
            url = "{{ route('product.filter') }}";
            $.ajax({
                url: url,
                type: "POST",
                data:{
                    category_id:category_id,brand_id:brand_id,min_price: min_price,max_price: max_price,_token: '{{csrf_token()}}',
                },
                success:function(response){
                    console.log(response.product_filtered);
                    $('#product_filtered').html(response.product_filtered);
                }
            });
            
        });
    });
</script>
<script>
    var lowerSlider = document.querySelector('#lower');
    var  upperSlider = document.querySelector('#upper');

    document.querySelector('#two').value=upperSlider.value;
    document.querySelector('#one').value=lowerSlider.value;

    var  lowerVal = parseInt(lowerSlider.value);
    var upperVal = parseInt(upperSlider.value);

    upperSlider.oninput = function () {
        lowerVal = parseInt(lowerSlider.value);
        upperVal = parseInt(upperSlider.value);

        if (upperVal < lowerVal + 4) {
            lowerSlider.value = upperVal - 4;
            if (lowerVal == lowerSlider.min) {
            upperSlider.value = 4;
            }
        }
        document.querySelector('#two').value=this.value
    };

    lowerSlider.oninput = function () {
        lowerVal = parseInt(lowerSlider.value);
        upperVal = parseInt(upperSlider.value);
        if (lowerVal > upperVal - 4) {
            upperSlider.value = lowerVal + 4;
            if (upperVal == upperSlider.max) {
                lowerSlider.value = parseInt(upperSlider.max) - 4;
            }
        }
        document.querySelector('#one').value=this.value
    };

    function product_price_filter() {
        var category_id = $("input[name='category']:checked").val();
        var brand_id = $("input[name='brand']:checked").val();
        var min_price = $('#lower').val();
        var max_price = $('#upper').val();
        url = "{{ route('product.filter') }}";
        $.ajax({
            url: url,
            type: "POST",
            data:{
                category_id:category_id,brand_id:brand_id,min_price: min_price,max_price: max_price,_token: '{{csrf_token()}}',
            },
            success:function(response){
                console.log(response.product_filtered);
                $('#product_filtered').html(response.product_filtered);
            }
        });
    }
</script>
@endsection

        