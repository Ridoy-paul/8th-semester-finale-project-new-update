<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  {{-- <a href="" class="brand-link" target="_blank" style="background-color: #fff">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image">
    <span class="brand-text font-weight-bold" style="color: #000;">{{ env('APP_NAME') }}</span>
  </a>  --}}

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('images/user-avatar-icon.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>
    

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <a href="{{ route('home') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        @if(Auth::user()->type == 1)
        
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Settings & Others
              <i class="fas fa-angle-right right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{ route('setting.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Shop Settings</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('about_us.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>About us Settings</p>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="{{ route('setting.reward.point') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Reward Point Settings</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('slider.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Slider Option</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('f.banner.show') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>4 Banner into Home Page</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('page.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Pages</p>
              </a>
            </li>
            {{--
            <li class="nav-item">
              <a href="{{ route('gallery.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Gallery</p>
              </a>
            </li>
          
            <li class="nav-item">
              <a href="{{ route('referral.link.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Referral Link</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Sponsors</p>
              </a>
            </li> 
            --}}
          </ul>
        </li>
        
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              User Management
              <i class="fas fa-angle-right right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Adminstrators</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('customer.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Customers</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Product
              <i class="fas fa-angle-right right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('product.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Products List</p>
              </a>
            </li>
            
            <li class="nav-item">
              <a href="{{ route('product.create') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Add Product</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('product.stock') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Product Stock List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('category.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('brand.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Brand</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('color.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Colors</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('variation.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Variation</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('flash.sale.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Flash Sale</p>
              </a>
            </li>
            
          </ul>
        </li>

        
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-plus-square"></i>
            <p>
              Orders
              <i class="fas fa-angle-right right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('order.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>All Orders</p>
              </a>
            </li>
            @php( $order_status = DB::table('orders')->select('order_status', DB::raw('count(*) as total'))->groupBy('order_status')->get() )
            @foreach($order_status as $status)
            <li class="nav-item">
              <a href="{{ route('order.status.filter', $status->order_status) }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>{{ $status->order_status }}</p>
              </a>
            </li>
            @endforeach
          </ul>
        </li>

        @php( $review_count = DB::table('products_reviews')->where(['is_active'=>0])->count('id') )
        <li class="nav-item">
          <a href="{{ route('product.review.index') }}" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Product Reviews
            </p> @if($review_count > 0)<span class="bg-primary px-2 p-1 rounded-pill text-light">{{$review_count}}</span>@endif
          </a>
        </li>
       
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-percent"></i>
            <p>
              Campaign
              <i class="fas fa-angle-right right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{ route('coupon.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Coupone</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('registration.point.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Registration Point</p>
              </a>
            </li>
            
          </ul>
        </li>
        {{--
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-certificate"></i>
            <p>
              Affiliate
              <i class="fas fa-angle-right right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{ route('affiliate.request') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Seller Requests</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('affiliate.payment.request') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Payment Requests</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('affiliate.config') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Configuration</p>
              </a>
            </li>
            
          </ul>
        </li>
        --}}
        
        <li class="nav-item">
          <a href="{{ route('admin.subscribers') }}" class="nav-link">
            <i class="nav-icon fas fa-bell-slash"></i>
            <p>
              Subscribers
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-map-marker-alt"></i>
            <p>
              Location
              <i class="fas fa-angle-right right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{ route('district.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>District List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('area.index') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Area List</p>
              </a>
            </li>
            
            
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-tablets"></i>
            <p>
              Blog
              <i class="fas fa-angle-right right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            
            <li class="nav-item">
              <a href="{{ route('blog.create') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Create Blog </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('blog.list') }}" class="nav-link">
                <i class="fas fa-angle-right"></i>
                <p>Blog List</p>
              </a>
            </li>
            
          </ul>
        </li>


        <li class="nav-item">
          <a href="{{ route('user.profile') }}" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Profile
            </p>
          </a>
        </li>
        @endif

        @if(Auth::user()->type == 2)
        
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-plus-square"></i>
            <p>
              My Orders
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-heart"></i>
            <p>
              My Wishlist
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('customer.dashboard.wallet') }}" class="nav-link">
            <i class="nav-icon fas fa-money-bill-alt"></i>
            <p>
              My Wallet
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('user.profile') }}" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Profile
            </p>
          </a>
        </li>
        @endif
        <div class="p-2"></div>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
