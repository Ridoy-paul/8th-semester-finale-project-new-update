@extends('layouts.master')

@section('title')
	{{ 'Offer Products' . ' | '. env('APP_NAME') }}
@endsection

@section('content')

	<!-- Start of Main -->
        <main class="main">
            <!-- Start of Breadcrumb -->
            <nav class="breadcrumb-nav">
                <div class="container">
                    <ul class="breadcrumb bb-no">
                        <li><a href="{{ route('products') }}">Home</a></li>
                        <li><a href="{{ route('offer.products') }}">Offer</a></li>
                        <li>Products</li>
                    </ul>
                </div>
            </nav>
            <!-- End of Breadcrumb -->
            <!-- Start of Shop Banner -->
                    <div class="shop-default-banner shop-boxed-banner banner d-flex align-items-center mb-6"
                    style="background-image: url({{ asset('images/website/'.$page->image)  }}); background-color: #FFC74E;">
                        <div class="container banner-content" style="height: 150px;">
                            
                        </div>
                    </div>
                    <!-- End of Shop Banner -->

            <!-- Start of Page Content -->
            <div class="page-content mb-10">
                
                <div class="container-fluid">
                    
                    <!-- Start of Shop Content -->
                    <div class="shop-content">
                        <h2 class="title justify-content-center ls-normal mb-5 pt-4">Offer Products</h2>
                        <!-- Start of Shop Main Content -->
                        <div class="main-content">
                            
                            <div class="product-wrapper row cols-xl-6 cols-lg-5 cols-md-4 cols-sm-3 cols-2">
                                
                                @foreach($products as $product)
                                @include('partials.product')
                                @endforeach
                            </div>

                            <div class="toolbox toolbox-pagination justify-content-between">
                                <!-- <p class="showing-info mb-2 mb-sm-0">
                                    Showing<span>1-12 of 60</span>Products
                                </p> -->
                                <ul class="pagination">
                                    
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

        