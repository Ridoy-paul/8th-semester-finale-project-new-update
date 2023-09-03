@extends('layouts.home-master')

@section('content')

           @include('partials.slider')

            <div class="shipping container">
                <div class="owl-carousel owl-theme row cols-md-4 cols-sm-3 cols-1icon-box-wrapper appear-animate br-sm mt-6 mb-6"
                    data-owl-options="{
                    'nav': false,
                    'dots': false,
                    'loop': false,
                    'responsive': {
                        '0': {
                            'items': 1
                        },
                        '576': {
                            'items': 2
                        },
                        '768': {
                            'items': 3
                        },
                        '992': {
                            'items': 3
                        },
                        '1200': {
                            'items': 4
                        }
                    }
                }">
                    <div class="icon-box icon-box-side icon-box-primary">
                        <span class="icon-box-icon icon-shipping">
                            <i class="w-icon-truck"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title font-weight-bold mb-1">Free Shipping & Returns</h4>
                            <p class="text-default">For all orders over $99</p>
                        </div>
                    </div>
                    <div class="icon-box icon-box-side icon-box-primary">
                        <span class="icon-box-icon icon-payment">
                            <i class="w-icon-bag"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title font-weight-bold mb-1">Secure Payment</h4>
                            <p class="text-default">We ensure secure payment</p>
                        </div>
                    </div>
                    <div class="icon-box icon-box-side icon-box-primary icon-box-money">
                        <span class="icon-box-icon icon-money">
                            <i class="w-icon-money"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title font-weight-bold mb-1">Money Back Guarantee</h4>
                            <p class="text-default">Any back within 30 days</p>
                        </div>
                    </div>
                    <div class="icon-box icon-box-side icon-box-primary icon-box-chat">
                        <span class="icon-box-icon icon-chat">
                            <i class="w-icon-chat"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title font-weight-bold mb-1">Customer Support</h4>
                            <p class="text-default">Call or email us 24/7</p>
                        </div>
                    </div>
                </div>
                

                
            </div>

            
            <section class="category-section top-category bg-grey pt-5 pb-10 appear-animate">
                <div class="container pb-2">
                    <h2 class="title justify-content-center pt-1 ls-normal mb-5">Category</h2>
                    <div class=" row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                        @foreach($categories as $category)
                            <div class="category category-classic category-absolute overlay-zoom br-xs mb-2">
                                <a href="{{ route('category.products', [$category->id, Str::slug($category->title)]) }}" class="category-media">
                                    <img src="{{ asset('images/category/'. $category->image) }}" alt="Category" width="130" height="130">
                                </a>
                                <div class="category-content">
                                    <h4 class="category-name">{{ $category->title }}</h4>
                                    <a href="{{ route('category.products', [$category->id, Str::slug($category->title)]) }}" class="btn btn-primary btn-link btn-underline">{{ $category->title }}</a>
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </section>
            <!-- End of .category-section top-category -->

            <div class="container">
                

                

                @foreach($featured_categories as $category)
                <div class="product-wrapper-1 appear-animate mb-7">
                    <div class="title-link-wrapper pb-1 mb-4">
                        <h2 class="title ls-normal mb-0">{{ $category->title }}</h2>
                        <a href="{{ route('products') }}" class="font-size-normal font-weight-bold ls-25 mb-0">More
                            Products<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-4 mb-4">
                            <div class="banner h-100 br-sm" style="background-image: url({{ asset('images/category/'. $category->banner)  }}); 
                            background-color: #EAEFF3;">
                                <!-- <div class="banner-content content-top">
                                    <h5 class="banner-subtitle font-weight-normal mb-2">Deals And Promotions</h5>
                                    <hr class="banner-divider bg-dark mb-2">
                                    <h3 class="banner-title font-weight-bolder text-uppercase ls-25">
                                        Trending <br> <span class="font-weight-normal text-capitalize">House
                                            Utensil</span>
                                    </h3>
                                    <a href="shop-banner-sidebar.html"
                                        class="btn btn-dark btn-outline btn-rounded btn-sm">shop now</a>
                                </div> -->
                            </div>
                        </div>
                        <!-- End of Banner -->
                        <div class="col-lg-9 col-sm-8">
                            <div class="owl-carousel owl-theme row cols-xl-4 cols-lg-3 cols-2" data-owl-options="{
                                'nav': false,
                                'dots': true,
                                'margin': 20,
                                'responsive': {
                                    '0': {
                                        'items': 2
                                    },
                                    '576': {
                                        'items': 2
                                    },
                                    '992': {
                                        'items': 3
                                    },
                                    '1200': {
                                        'items': 4
                                    }
                                }
                            }">
                                <div class="product-col">
                                    @foreach($category->product->take(8) as $product)
                                    @include('partials.product')
                                    @if((($loop->index + 1) > 0) && (($loop->index + 1) % 2 == 0))
                                </div>
                                <div class="product-col">
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <!-- End of Produts -->
                        </div>
                    </div>
                </div>
                @endforeach
                <!-- End of Product Wrapper 1 -->

                <div class="product-wrapper-1 appear-animate mb-8">
                    <div class="title-link-wrapper pb-1 mb-4">
                        <h2 class="title ls-normal mb-0">{{('Our Products')}}</h2>
                        <a href="{{ route('products') }}" class="font-size-normal font-weight-bold ls-25 mb-0">More
                            Products<i class="w-icon-long-arrow-right"></i></a>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-4 mb-4">
                            <div class="banner h-100 br-sm" style="background-image: url({{ asset('images/website/'. $page->product_banner)  }}); 
                            background-color: #252525;">
                                <!-- <div class="banner-content content-top">
                                    <h5 class="banner-subtitle text-white font-weight-normal mb-2">New Collection</h5>
                                    <hr class="banner-divider bg-white mb-2">
                                    <h3 class="banner-title text-white font-weight-bolder text-uppercase ls-25">
                                        Top Camera <br> <span
                                            class="font-weight-normal text-capitalize">Mirrorless</span>
                                    </h3>
                                    <a href="shop-banner-sidebar.html"
                                        class="btn btn-white btn-outline btn-rounded btn-sm">shop now</a>
                                </div> -->
                            </div>
                        </div>
                        <!-- End of Banner -->
                        <div class="col-lg-9 col-sm-8">
                            <div class="owl-carousel owl-theme row cols-xl-4 cols-lg-3 cols-2" data-owl-options="{
                                'nav': false,
                                'dots': true,
                                'margin': 20,
                                'responsive': {
                                    '0': {
                                        'items': 2
                                    },
                                    '576': {
                                        'items': 2
                                    },
                                    '992': {
                                        'items': 3
                                    },
                                    '1200': {
                                        'items': 4
                                    }
                                }
                            }">
                                <div class="product-col">
                                    @foreach($random_products as $product)
                                    @include('partials.product')
                                    @if((($loop->index + 1) > 0) && (($loop->index + 1) % 2 == 0))
                                </div>
                                <div class="product-col">
                                    @endif
                                    @endforeach
                                </div>
                                
                            </div>
                            <!-- End of Produts -->
                        </div>
                    </div>
                </div>
                <!-- End of Product Wrapper 1 -->

               
                <!-- End of Banner Fashion -->

                

                

                
            </div>
            <!--End of Catainer -->

@endsection