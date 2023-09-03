@extends('layouts.master')

@section('title')
	{{ 'Categories' . ' | '. env('APP_NAME') }}
@endsection

@section('content')

	<!-- Start of Main -->
        <main class="main">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <li><a href="demo1.html">Home</a></li>
                        <li>Categories</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->

            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    
                    <section class="category-section top-category bg-grey pt-10 pb-10 appear-animate">
                <div class="container pb-2">
                    <h2 class="title justify-content-center pt-1 ls-normal mb-5">Category</h2>
                    <div class=" row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                        @foreach($categories as $category)
                            <div class="category category-classic category-absolute overlay-zoom br-xs mb-2">
                                <a href="{{ route('category.products', [$category->id, Str::slug($category->title)]) }}" class="category-media">
                                    <img src="{{ asset('images/category/'. $category->image) }}" alt="Category" width="130"
                                        height="130">
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
                    
                     <!-- <section class="category-section top-category bg-grey pt-10 pb-10 appear-animate">
                        <div class="container pb-2">
                            <h2 class="title justify-content-center pt-1 ls-normal mb-5">Category</h2>
                            <div class="owl-carousel owl-theme row cols-lg-6 cols-md-5 cols-sm-3 cols-2" data-owl-options="{
                                'nav': false,
                                'dots': false,
                                'autoplay': true,
                                'loop': true,
                                'margin': 20,
                                'responsive': {
                                    '0': {
                                        'items': 2
                                    },
                                    '576': {
                                        'items': 3
                                    },
                                    '768': {
                                        'items': 5
                                    },
                                    '992': {
                                        'items': 6
                                    }
                                }
                            }">
                                @foreach($categories as $category)
                                <div class="category category-classic category-absolute overlay-zoom br-xs">
                                    <a href="{{ route('category.products', [$category->id, Str::slug($category->title)]) }}" class="category-media">
                                        <img src="{{ asset('images/category/'. $category->image) }}" alt="Category" width="130"
                                            height="130">
                                    </a>
                                    <div class="category-content">
                                        <h4 class="category-name">{{ $category->title }}</h4>
                                        <a href="{{ route('category.products', [$category->id, Str::slug($category->title)]) }}" class="btn btn-primary btn-link btn-underline">{{ $category->title }}</a>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                        </div>
                    </section> -->

                    
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->

@endsection

        