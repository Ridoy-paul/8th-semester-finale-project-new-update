@php
	$nav_categories = App\Models\Category::where('is_active', 1)->where('parent_id', 0)->orderBy('position', 'ASC')->limit(8)->get();
	$business = App\Models\Setting::find(1);
@endphp
@include('partials.home-header')

        <!-- Start of Main-->
        <main class="main">
            @yield('content')
        </main>
        <!-- End of Main -->

@include('partials.home-footer')        