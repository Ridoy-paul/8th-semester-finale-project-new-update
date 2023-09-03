 <!-- <section class="intro-section d-none">
                <div class="owl-carousel owl-theme owl-nav-inner owl-dot-inner owl-nav-lg animation-slider gutter-no row cols-1"
                    data-owl-options="{
                    'nav': false,
                    'dots': true,
                    'autoplay': true,
                    'loop': true,
                    'items': 1,
                    'responsive': {
                        '1600': {
                            'nav': true,
                            'dots': false
                        }   
                    }
                }">
                    @foreach($sliders as $slider)
                    <a href="{{ $slider->link }}">
                    <div class="banner banner-fixed intro-slide intro-slide1"
                        style="background-image: url({{ asset('images/slider/'. $slider->image)  }}); background-color: #ebeef2;">
                        <div class="container">
                            
                        </div>
                        
                    </div>
                    
                    </a>
                    @endforeach
                    

                    
                </div>
            </section> -->
            <!-- End of .intro-section -->

          <section class="intro-section">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  @foreach($sliders as $slider)
                  <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                    <a href="{{ $slider->link }}"><img class="d-block w-100" src="{{ asset('images/slider/'. $slider->image)  }}" alt="First slide"></a>
                  </div>
                  @endforeach
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
          </section>