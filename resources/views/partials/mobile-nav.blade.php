<div class="mobile-menu-wrapper">
        <div class="mobile-menu-overlay"></div>
        <!-- End of .mobile-menu-overlay -->

        <a href="#" class="mobile-menu-close"><i class="close-icon"></i></a>
        <!-- End of .mobile-menu-close -->

        <div class="mobile-menu-container scrollable">
           <!--  <form action="{{ route('search.result') }}" method="get" class="input-wrapper">
                <input type="text" class="form-control" name="search" autocomplete="off" placeholder="Search"
                    required />
                <button class="btn btn-search" type="submit">
                    <i class="w-icon-search"></i>
                </button>
            </form> -->
            <!-- End of Search Form -->
            <div class="tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a href="#categories" class="nav-link">Categories</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane active" id="categories">
                    <ul class="mobile-menu">
                    	@foreach($nav_categories as $category)
                    	@if(count($category->child) > 0)
                        <li>
                            <a href="{{ route('category.products', [$category->id, Str::slug($category->title)]) }}">
                                <img src="{{ asset('images/category/'. $category->image) }}" width="32" height="32" style="margin-right: 10px"> {{ $category->title }}
                            </a>
                            <ul>
                            	@foreach($category->child as $sub_category)
                                <li><a href="{{ route('category.products', [$sub_category->id, Str::slug($sub_category->title)]) }}"><i class="fa fa-angle-right"></i> {{ $sub_category->title }}</a>
	                            </li>
	                            @endforeach
                            </ul>
                        </li>
                        @else
			            <li>
			                <a href="{{ route('category.products', [$category->id, Str::slug($category->title)]) }}">
			                    <img src="{{ asset('images/category/'. $category->image) }}" width="32" height="32" style="margin-right: 10px"><!-- <i class="w-icon-gift"></i> -->{{ $category->title }}
			                </a>
			            </li>
			            @endif
			            @endforeach
                        <div>
                            <hr>
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>