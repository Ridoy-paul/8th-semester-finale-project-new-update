<div class="dropdown category-dropdown has-border" data-visible="true">
    <a href="#" class="category-toggle" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="true" data-display="static"
        title="Browse Categories">
        <i class="w-icon-category"></i>
        <span>Browse Categories</span>
    </a>

    <div class="dropdown-box">
        <ul class="menu vertical-menu category-menu">
            @foreach($nav_categories as $category)
            @if(count($category->child) > 0)
            <li>
                <a href="{{ route('category.products', [$category->id, Str::slug($category->title)]) }}">
                    <img src="{{ asset('images/category/'. $category->image) }}" width="32" height="32" style="margin-right: 10px"><!-- <i class="w-icon-tshirt2"></i> -->{{ $category->title }}
                </a>
                <ul class="megamenu">
                    <li>
                        <!-- <h4 class="menu-title">Women</h4>
                        <hr class="divider"> -->
                        <ul>
                            @foreach($category->child as $sub_category)
                            <li><a href="{{ route('category.products', [$sub_category->id, Str::slug($sub_category->title)]) }}"><i class="fa fa-angle-right"></i> {{ $sub_category->title }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
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
            <li>
                <a href="{{ route('categories') }}"
                    class="font-weight-bold text-primary text-uppercase ls-25">
                    View All Categories<i class="w-icon-angle-right"></i>
                </a>
            </li>
        </ul>
    </div>
</div>