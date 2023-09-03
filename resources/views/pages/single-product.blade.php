@extends('layouts.master')

@section('title'){{ optional($product)->title }}@endsection
@section('description'){{optional($product)->meta_description}}@endsection
@section('keywords'){{optional($product)->meta_keywords}}@endsection

@section('content')

	<!-- Start of Breadcrumb -->
    <nav class="breadcrumb-nav container">
        <ul class="breadcrumb bb-no">
            <li><a href="demo1.html">Home</a></li>
            <li>Products</li>
        </ul>
        <!-- <ul class="product-nav list-style-none">
            <li class="product-nav-prev">
                <a href="#">
                    <i class="w-icon-angle-left"></i>
                </a>
                <span class="product-nav-popup">
                    <img src="{{ asset('') }}assets/images/products/product-nav-prev.jpg" alt="Product" width="110"
                        height="110" />
                    <span class="product-name">Soft Sound Maker</span>
                </span>
            </li>
            <li class="product-nav-next">
                <a href="#">
                    <i class="w-icon-angle-right"></i>
                </a>
                <span class="product-nav-popup">
                    <img src="{{ asset('') }}assets/images/products/product-nav-next.jpg" alt="Product" width="110"
                        height="110" />
                    <span class="product-name">Fabulous Sound Speaker</span>
                </span>
            </li>
        </ul> -->
    </nav>
    <!-- End of Breadcrumb -->

    <!-- Start of Page Content -->
    <div class="page-content">
        <div class="container">
            <div class="row gutter-lg">
                <div class="main-content">
                    <div class="product product-single row mb-2">
                        <div class="col-md-6 mb-4 mb-md-8">
                            <div class="product-gallery product-gallery-sticky">
                                <div
                                    class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">
                                    @foreach($product->product_image as $image)
                                    <figure class="product-image">
                                        <img src="{{ asset('images/product/'. $image->image) }}"
                                            data-zoom-image="{{ asset('images/product/'. $image->image) }}"
                                            alt="{{ $product->title }}" width="800" height="900">
                                    </figure>
                                    @endforeach
                                </div>
                                <div class="product-thumbs-wrap">
                                    <div class="product-thumbs row cols-4 gutter-sm">
                                    	@foreach($product->product_image as $image)
                                        <div class="product-thumb active">
                                            <img src="{{ asset('images/product/'. $image->image) }}"
                                                alt="{{ $product->title }}" width="800" height="900">
                                        </div>
                                        @endforeach
                                    </div>
                                    <button class="thumb-up disabled"><i class="w-icon-angle-left"></i></button>
                                    <button class="thumb-down disabled"><i
                                            class="w-icon-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-6 mb-md-8">
                            <div class="product-details" data-sticky-options="{'minWidth': 767}">
                                <h1 class="product-title">{{ $product->title }}</h1>
                                <div class="product-bm-wrapper">
                                    <figure class="brand">
                                    	@if(!is_null($product->brand))
                                        <a href="{{ route('brand.products', [$product->brand->id, Str::slug($product->brand->title)]) }}"><img src="{{ asset('images/brand/' . $product->brand->image) }}" alt="Brand" width="106" height="48" /></a>
                                        @endif
                                    </figure>
                                    <div class="product-meta">
                                    	@if(!is_null($product->category))
                                        <div class="product-categories">
                                            Category:
                                            <span class="product-category"><a href="#">{{ $product->category->title }}</a></span>
                                        </div>
                                        @endif
                                        <div class="product-sku">
                                            CODE: <span>{{ $product->code }}</span>
                                        </div>
                                    </div>
                                </div>

                                <hr class="product-divider">

                                <div class="product-price">
                                    @if($product->type == 'single')
                                        <ins class="new-price">{{ env('CURRENCY') }} {{ $product->price }} {{ env('UAE_CURRENCY') }}</ins>
                                    @else
                                        @if(count($product->variation) == 1)
                                            <ins class="new-price">{{ env('CURRENCY') }} {{ $product->variation->first()->price }} {{ env('UAE_CURRENCY') }}</ins>
                                        @else
                                            <ins class="new-price">{{ env('CURRENCY') }} {{ $product->variation->where('price', $product->variation->min('price'))->first()->price }} {{ env('UAE_CURRENCY') }} - {{ env('CURRENCY') }} {{ $product->variation->where('price', $product->variation->max('price'))->first()->price }} {{ env('UAE_CURRENCY') }}</ins>
                                        @endif
                                    @endif
                                </div>

                                <!-- <div class="ratings-container">
                                    <div class="ratings-full">
                                        <span class="ratings" style="width: 80%;"></span>
                                        <span class="tooltiptext tooltip-top"></span>
                                    </div>
                                    <a href="#product-tab-reviews" class="rating-reviews">(3 Reviews)</a>
                                </div> -->

                                <hr class="product-divider">

                                @if($product->type == 'variation')
                                @foreach(json_decode($product->choice_options, true) as $option)
                                <div class="product-form product-variation-form product-size-swatch">
                                    <label class="mb-1">{{ !is_null(App\Models\Variation::find($option['variation_id'])) ? App\Models\Variation::findOrFail($option['variation_id'])->title : 'N/A' }}:</label>
                                    <div class="flex-wrap d-flex align-items-center product-variations">
                                    	@foreach($option['values'] as $value)
                                        <a href="#" class="size">{{ $value }}</a>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                                @endif

                                <!-- <div class="fix-bottom product-sticky-content sticky-content">
                                    <div class="product-form container">
                                        <div class="product-qty-form">
                                            
                                        </div>
                                        <a onclick="addToCart({{ $product->id }})" class="btn btn-primary" style="color: #fff;"><i class="w-icon-cart"></i> Add to Cart</a>
                                    </div>
                                </div> -->
                                <div class="fix-bottom product-sticky-content">
                                    <div class="product-form container">
                                        
                                        <a onclick="addToCart({{ $product->id }})" class="btn btn-primary" style="color: #fff;"><i class="w-icon-cart"></i> Add to Cart</a>
                                    </div>
                                </div>

                                <div class="social-links-wrapper">
                                    
                                    <span class="divider d-xs-show"></span>
                                    <div class="product-link-wrapper d-flex">
                                    <a onclick="addToWishlist({{ $product->id }})" class="btn-product-icon w-icon-heart" title="Add to Wishlist"><span></span></a>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <section class="description-section">
                        <div class="title-link-wrapper no-link">
                            <h2 class="title title-link">Description</h2>
                        </div>
                        <div class="pt-4 pb-1" id="product-tab-description">
                            {!! $product->description !!}
                        </div>
                    </section>

                    <!-- <section class="review-section">
                        <div class="title-link-wrapper no-link">
                            <h2 class="title title-link">Customer Reviews</h2>
                        </div>
                        <div class="pt-4 pb-1" id="product-tab-reviews">
                            <div class="row mb-4">
                                <div class="col-xl-4 col-lg-5 mb-4">
                                    <div class="ratings-wrapper">
                                        <div class="avg-rating-container">
                                            <h4 class="avg-mark font-weight-bolder ls-50">3.3</h4>
                                            <div class="avg-rating">
                                                <p class="text-dark mb-1">Average Rating</p>
                                                <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 60%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                    <a href="#" class="rating-reviews">(3 Reviews)</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ratings-value d-flex align-items-center text-dark ls-25">
                                            <span
                                                class="text-dark font-weight-bold">66.7%</span>Recommended<span
                                                class="count">(2 of 3)</span>
                                        </div>
                                        <div class="ratings-list">
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>70%</mark>
                                                </div>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 80%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>30%</mark>
                                                </div>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 60%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>40%</mark>
                                                </div>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 40%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>0%</mark>
                                                </div>
                                            </div>
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 20%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <div class="progress-bar progress-bar-sm ">
                                                    <span></span>
                                                </div>
                                                <div class="progress-value">
                                                    <mark>0%</mark>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-lg-7 mb-4">
                                    <div class="review-form-wrapper">
                                        <h3 class="title tab-pane-title font-weight-bold mb-1">Submit Your
                                            Review</h3>
                                        <p class="mb-3">Your email address will not be published. Required
                                            fields are marked *</p>
                                        <form action="#" method="POST" class="review-form">
                                            <div class="rating-form">
                                                <label for="rating">Your Rating Of This Product :</label>
                                                <span class="rating-stars">
                                                    <a class="star-1" href="#">1</a>
                                                    <a class="star-2" href="#">2</a>
                                                    <a class="star-3" href="#">3</a>
                                                    <a class="star-4" href="#">4</a>
                                                    <a class="star-5" href="#">5</a>
                                                </span>
                                                <select name="rating" id="rating" required=""
                                                    style="display: none;">
                                                    <option value="">Rate…</option>
                                                    <option value="5">Perfect</option>
                                                    <option value="4">Good</option>
                                                    <option value="3">Average</option>
                                                    <option value="2">Not that bad</option>
                                                    <option value="1">Very poor</option>
                                                </select>
                                            </div>
                                            <textarea cols="30" rows="6" placeholder="Write Your Review Here..."
                                                class="form-control" id="review"></textarea>
                                            <div class="row gutter-md">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        placeholder="Your Name" id="author">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        placeholder="Your Email" id="email_1">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" class="custom-checkbox"
                                                    id="save-checkbox">
                                                <label for="save-checkbox">Save my name, email, and website in
                                                    this browser for the next time I comment.</label>
                                            </div>
                                            <button type="submit" class="btn btn-dark">Submit Review</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section> -->


                    
                    
                </div>
                <!-- End of Main Content -->
                <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
                    <div class="sidebar-overlay"></div>
                    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
                    <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
                    <div class="sidebar-content scrollable">
                        <div class="sticky-sidebar">
                            <H3>Similar Products</H3>
                            <div class="product-widget-wrap">
                                        @foreach($similar_products as $product)
                                        <div class="product product-widget bb-no">
                                            <figure class="product-media">
                                                <a href="{{ route('single.product', [$product->id, Str::slug($product->title)]) }}">
                                                    <img src="{{ asset('images/product/'.$product->image) }}" alt="Product"
                                                        width="105" height="118" />
                                                </a>
                                            </figure>
                                            <div class="product-details">
                                                <h4 class="product-name">
                                                    <a href="{{ route('single.product', [$product->id, Str::slug($product->title)]) }}">{{ $product->title }}</a>
                                                </h4>
                                                <!-- <div class="ratings-container">
                                                    <div class="ratings-full">
                                                        <span class="ratings" style="width: 60%;"></span>
                                                        <span class="tooltiptext tooltip-top"></span>
                                                    </div>
                                                </div> -->
                                                <div class="product-price">
                                                    <ins class="new-price">{{ env('CURRENCY') }}{{ $product->price }} {{ env('UAE_CURRENCY') }}</ins>
                                                </div>
                                            </div>
                                        </div>
                                       @endforeach
                                    </div>
                            <!-- <div class="widget widget-icon-box mb-6">
                                <div class="icon-box icon-box-side">
                                    <span class="icon-box-icon text-dark">
                                        <i class="w-icon-truck"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title">Free Shipping & Returns</h4>
                                        <p>For all orders over $99</p>
                                    </div>
                                </div>
                                <div class="icon-box icon-box-side">
                                    <span class="icon-box-icon text-dark">
                                        <i class="w-icon-bag"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title">Secure Payment</h4>
                                        <p>We ensure secure payment</p>
                                    </div>
                                </div>
                                <div class="icon-box icon-box-side">
                                    <span class="icon-box-icon text-dark">
                                        <i class="w-icon-money"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <h4 class="icon-box-title">Money Back Guarantee</h4>
                                        <p>Any back within 30 days</p>
                                    </div>
                                </div>
                            </div> -->
                            <!-- End of Widget Icon Box -->

                            <!-- <div class="widget widget-banner mb-9">
                                <div class="banner banner-fixed br-sm">
                                    <figure>
                                        <img src="{{ asset('') }}assets/images/shop/banner3.jpg" alt="Banner" width="266"
                                            height="220" style="background-color: #1D2D44;" />
                                    </figure>
                                    <div class="banner-content">
                                        <div class="banner-price-info font-weight-bolder text-white lh-1 ls-25">
                                            40<sup class="font-weight-bold">%</sup><sub
                                                class="font-weight-bold text-uppercase ls-25">Off</sub>
                                        </div>
                                        <h4
                                            class="banner-subtitle text-white font-weight-bolder text-uppercase mb-0">
                                            Ultimate Sale</h4>
                                    </div>
                                </div>
                            </div> -->
                            <!-- End of Widget Banner -->

                            
                        </div>
                    </div>
                </aside>
                <!-- End of Sidebar -->
            </div>
        </div>
    </div>
    <!-- End of Page Content -->
	

@endsection

        