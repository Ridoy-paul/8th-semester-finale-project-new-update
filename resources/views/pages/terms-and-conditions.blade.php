@extends('layouts.master')

@section('title')
	{{ 'Terms & Conditions' . ' | '. env('APP_NAME') }}
@endsection



@section('content')

		<!-- Start of Main -->
        <main class="main contact">
            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                    <!-- Start of Breadcrumb -->
                    <nav class="breadcrumb-nav">
                        <div class="container">
                            <ul class="breadcrumb bb-no">
                                <li><a href="{{ route('products') }}">Home</a></li>
                                <li>Terms And Conditions</li>
                            </ul>
                        </div>
                    </nav>
                    <!-- End of Breadcrumb -->
                    
                	<div class="row">
                		
                    	<div class="col-md-12">
                            <div style="padding: 15px;border: 1px solid #336699;">
                                <h2 class="pt-4 pb-4">Terms & Conditions</h2>
                                {!! $page->description !!}
                            </div>
                                
                    	</div>
                        
                    </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->

@endsection