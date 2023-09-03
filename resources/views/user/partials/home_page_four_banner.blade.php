
@php

$banner = DB::table('home_page_four_banners')->get();
$first_banner = $banner->filter(function($item) { return $item->id == 1; })->first();
$second_banner = $banner->filter(function($item) { return $item->id == 2; })->first();
$third_banner = $banner->filter(function($item) { return $item->id == 3; })->first();
$fourth_banner = $banner->filter(function($item) { return $item->id == 4; })->first();

@endphp

<!-- Start banner section -->
<section class="banner__section py-5">
    <div class="container-fluid">
        <div class="row mb--n28">
            <div class="col-lg-5 col-md-order mb-28">
                <div class="banner__items">
                    <a class="banner__items--thumbnail position__relative" href="{{optional($first_banner)->link}}"><img class="banner__items--thumbnail__img" src="{{ asset('images/slider/'.optional($first_banner)->image) }}" alt="banner-img">
                        <div class="banner__items--content">
                            {{-- <span class="banner__items--content__subtitle">{!! optional($first_banner)->description !!}</span> --}}
                            {{-- <h2 class="banner__items--content__title h3">{{optional($first_banner)->title}}</h2>
                            <span class="banner__items--content__link">View Collections
                                <svg class="banner__items--content__arrow--icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                    <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                </svg>
                            </span> --}}
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-7 mb-28">
                <div class="row row-cols-lg-2 row-cols-sm-2 row-cols-1">
                    <div class="col mb-28">
                        <div class="banner__items">
                            <a class="banner__items--thumbnail position__relative" href="{{optional($second_banner)->link}}"><img class="banner__items--thumbnail__img" src="{{ asset('images/slider/'.optional($second_banner)->image) }}" alt="banner-img"> 
                                <div class="banner__items--content">
                                    {{-- <span class="banner__items--content__subtitle">{!! optional($second_banner)->description !!}</span>
                                    <h2 class="banner__items--content__title h3">{{optional($second_banner)->title}}</h2>
                                    <span class="banner__items--content__link">View Collections
                                        <svg class="banner__items--content__arrow--icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                            <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                        </svg>
                                    </span> --}}
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col mb-28">
                        <div class="banner__items">
                            <a class="banner__items--thumbnail position__relative" href="{{optional($third_banner)->link}}"><img class="banner__items--thumbnail__img" src="{{ asset('images/slider/'.optional($third_banner)->image) }}" alt="banner-img"> 
                                <div class="banner__items--content">
                                    {{-- <span class="banner__items--content__subtitle">{!! optional($third_banner)->description !!}</span>
                                    <h2 class="banner__items--content__title h3">{{optional($third_banner)->title}}</h2>
                                    <span class="banner__items--content__link">View Collections
                                        <svg class="banner__items--content__arrow--icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                            <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                        </svg>
                                    </span> --}}
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="banner__items">
                    <a class="banner__items--thumbnail position__relative" href="{{optional($fourth_banner)->link}}"><img class="banner__items--thumbnail__img banner__img--max__height" src="{{ asset('images/slider/'.optional($fourth_banner)->image) }}" alt="banner-img"> 
                        <div class="banner__items--content">
                            {{-- <span class="banner__items--content__subtitle">{!! optional($fourth_banner)->description !!}</span>
                            <h2 class="banner__items--content__title h3">{{optional($fourth_banner)->title}}</h2>
                            <span class="banner__items--content__link">View Collections
                                <svg class="banner__items--content__arrow--icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                                    <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                                </svg>
                            </span> --}}
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End banner section -->
