@extends('layouts.master')

@section('title')
	{{ 'About' . ' | '. env('APP_NAME') }}
@endsection

@section('style')
 <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

    <style type="text/css">
        #demo {
  height:100%;
  position:relative;
  overflow:hidden;
}


.green{
  background-color:#6fb936;
}
        .thumb{
            margin-bottom: 30px;
        }
        
        .page-top{
            margin-top:85px;
        }

   
img.zoom {
    width: 100%;
    height: 200px;
    border-radius:5px;
    object-fit:cover;
    -webkit-transition: all .3s ease-in-out;
    -moz-transition: all .3s ease-in-out;
    -o-transition: all .3s ease-in-out;
    -ms-transition: all .3s ease-in-out;
}
        
 
.transition {
    -webkit-transform: scale(1.2); 
    -moz-transform: scale(1.2);
    -o-transform: scale(1.2);
    transform: scale(1.2);
}
    .modal-header {
   
     border-bottom: none;
}
    .modal-title {
        color:#000;
    }
    .modal-footer{
      display:none;  
    }
    </style>
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
                                <li>About Us</li>
                            </ul>
                        </div>
                    </nav>
                    <!-- End of Breadcrumb -->
                    <!-- Start of Shop Banner -->
                    <div class="shop-default-banner shop-boxed-banner banner d-flex align-items-center mb-6"
                    style="background-image: url({{ asset('images/website/'.$page->product_banner)  }}); background-color: #FFC74E;">
                        <div class="container banner-content" style="height: 150px;">
                            
                        </div>
                    </div>
                    <!-- End of Shop Banner -->
                	<div class="row">
                		
                    	<div class="col-md-6">
                            <div style="padding: 15px;border: 1px solid #336699;">
                                <h2 class="pt-4 pb-4">ABOUT US</h2>
                                {!! $page->description !!}
                            </div>
                                
                    	</div>
                        <div class="col-md-6">
                            <div style="padding: 15px;border: 1px solid #336699;">
                                <img src="{{ asset('images/website/'.$page->image)  }}">
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div style="padding: 15px;border: 1px solid #336699;">
                                <h2 class="pt-4 pb-4">OUR VISION</h2>
                                {!! $page->description1 !!}
                            </div>
                                
                        </div>
                        <div class="col-md-6">
                            <div style="padding: 15px;border: 1px solid #336699;">
                                <h2 class="pt-4 pb-4">OUR MISSION</h2>
                                {!! $page->description2 !!}
                            </div>
                                
                        </div>
                    </div>
                    <div class="row mt-4">

                        <h2 class="text-center p-4">GALLERY</h2>

                        @foreach($galleries as $gallery)
                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                            <a href="{{ asset('images/gallery/'.$gallery->image) }}?auto=compress&cs=tinysrgb&h=650&w=940" class="fancybox" rel="ligthbox">
                                <img  src="{{ asset('images/gallery/'.$gallery->image) }}?auto=compress&cs=tinysrgb&h=650&w=940" class="zoom img-fluid "  alt="">
                               
                            </a>
                        </div>
                        @endforeach
                       
                   </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->

@endsection