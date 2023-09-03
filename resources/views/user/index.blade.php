
@extends('user.inc.master')
@php( $business_info = business_info() )

@section('title')Home @endsection
@section('description'){{optional($business_info)->meta_description}}@endsection
@section('keywords'){{optional($business_info)->meta_keywords}}@endsection

@section('content')

@include('user.partials.slider')

<section class="team__section py-4 mt-10">
    <div class="container-fluid">
        {{-- <div class="section__heading text-center mb-50">
            <h2 class="section__heading--maintitle">Featured Categories</h2>
        </div> --}}
        <div class="team__container">
            <div class="row my-5">
                @foreach($featured_categories as $category)
                <div class="col-lg-2 col-md-2 col-sm-6 col-6">
                    <a href="{{route('products', ['category_id'=>$category->id])}}">
                        <div class="team__items text-center shadow hover-zoom">
                            <div class="p-2">
                                <img class="" title="{{$category->title}}" style="max-height: 160px !important; height: 160px !important; width: 160px !important;" src="{{ asset('images/category/'.$category->image ) }}" alt="{{$category->title}}">
                            </div>
                            {{--
                            <div class="team__content pb-3">
                                <h5 class="fw-bold"></h5>                        
                            </div>{{$category->title}}
                            --}}
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<div id="flash_sale_offer"></div>

@include('user.partials.home_page_four_banner')

<section class="product__section section--padding pt-0" style="padding-bottom: 6rem !important;">
    <div class="container-fluid">
        <div class="section__heading mb-2 border-bottom d-flex">
            <h2 class="section__heading-- style2 flex-grow-1">Trending Now</h2>
            <div class="btn_custom mb-2">
                <a class="primary__btn rounded shop_more_btn" href="{{route('products.individual.group', ['slug'=>'traending-now'])}}">Shop More
                    <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                    <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="product__section--inner">
            <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                @foreach($trending_products as $product)
                    @include('user.partials.product')
                @endforeach
            </div>
        </div>
    </div>
</section>

{{--
<section class="product__section section--padding pt-0"  style="padding-bottom: 6rem !important;">
    <div class="container-fluid">
        <div class="section__heading mb-2 border-bottom d-flex">
            <h2 class="section__heading-- style2 flex-grow-1">Today's Deal</h2>
            <div class="btn_custom mb-2">
                <a class="primary__btn rounded shop_more_btn" href="shop.html">Shop More
                    <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                    <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="product__section--inner">
            <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                @foreach($todays_deals as $product)
                    @include('user.partials.product')
                @endforeach
            </div>
        </div>
    </div>
</section>

--}}

<div id="featured_products"></div>

<div id="best_selling_products"></div>

{{-- 
<!-- Start product section -->
<section class="product__section section--padding pt-0">
    <div class="container-fluid">
        <div class="section__heading text-center mb-35">
            <h2 class="section__heading--maintitle">Products</h2>
        </div>
        <ul class="product__tab--one product__tab--primary__btn d-flex justify-content-center mb-50">
            <li class="product__tab--primary__btn__list active" data-toggle="tab" data-target="#todays_deal">Today's Deal</li>
            <li class="product__tab--primary__btn__list" data-toggle="tab" data-target="#featured">Featured </li>
            <li class="product__tab--primary__btn__list" data-toggle="tab" data-target="#trending">Trending </li>
            
        </ul>
        
        <div class="tab_content">
            <div id="todays_deal" class="tab_pane active show">
                <div class="product__section--inner">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                        @foreach($todays_deals as $product)
                            @include('user.partials.product')
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="featured" class="tab_pane">
                <div class="product__section--inner">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                        @foreach($featured_products as $product)
                            @include('user.partials.product')
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="trending" class="tab_pane">
                <div class="product__section--inner">
                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                        @foreach($trending_products as $product)
                            @include('user.partials.product')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End product section --> --}}


{{-- featured brands section --}}
{{--
<section class="team__section py-4 my-10">
    <div class="container-fluid mb-5">
        <div class="section__heading text-center mb-50">
            <h2 class="section__heading--maintitle">Featured Brands</h2>
        </div>
        <div class="team__container">
            <div class="row">
                @foreach($featured_brands as $brand)
                <div class="col-lg-2 col-md-2 col-sm-6 col-6">
                    <a href="{{route('products', ['brand_id'=>$brand->id])}}">
                        <div class="team__items text-center shadow rounded border-radius-10 hover-zoom">
                            <div class="p-2">
                                <img class="border-radius-10" style="max-height: 160px !important; height: 160px !important; width: 160px !important;" src="{{ asset('images/brand/'.$brand->image ) }}" alt="">
                            </div>
                            <div class="team__content pb-3">
                                <h5 class="fw-bold">{{$brand->title}}</h5>                        
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
--}}

@if(count($blogs) > 0)
<section class="blog__section section--padding pt-0">
    <div class="container-fluid">
        <div class="section__heading mb-2 border-bottom d-flex">
            <h2 class="section__heading-- style2 flex-grow-1">Latest News</h2>
            <div class="btn_custom mb-2">
                <a class="primary__btn rounded shop_more_btn" href="{{route('user.blog')}}">View All
                    <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                    <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="swiper-wrapper row">
            @foreach($blogs as $blog)
            <div class="swiper-slide col-md-3 swiper-slide-duplicate product_col py-3">
                <div class="blog__items">
                    <div class="blog__thumbnail">
                        <a class="blog__thumbnail--link" href="{{ route('user.blog.details', [$blog->id, Str::slug($blog->title)]) }}"><img class="blog__thumbnail--img" src="{{asset('images/blog/'.optional($blog)->image)}}" alt="{{optional($blog)->title}}"></a>
                    </div>
                    <div class="blog__content">
                        <span class="blog__content--meta">{{date("M d, Y", strtotime(optional($blog)->created_at))}}</span>
                        <h3 class="blog__content--title"><a href="{{ route('user.blog.details', [$blog->id, Str::slug($blog->title)]) }}">{{optional($blog)->title}}</a></h3>
                        <div class="text-center">
                            <a class="blog__content--btn primary__btn rounded shop_more_btn" href="{{ route('user.blog.details', [$blog->id, Str::slug($blog->title)]) }}">Read more </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $( window ).on('load', function () {
        //featured_products();
        best_selling_products();
        flash_sale_offer();
    });
</script>
@endsection

