<nav class="main-nav">
    <ul class="menu active-underline">
        <li class="{{ Route::currentRouteName() == 'index' ? 'active' : '' }}">
            <a href="{{ route('index') }}">Home</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'products' ? 'active' : '' }}">
        	<a href="{{ route('products') }}">All Products</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'offer.products' ? 'active' : '' }}">
        	<a href="{{ route('offer.products') }}">Offer Products</a>
        </li>
        
        <li class="{{ Route::currentRouteName() == 'about' ? 'active' : '' }}">
        	<a href="{{ route('about') }}">About Us</a>
        </li>
        <li class="{{ Route::currentRouteName() == 'contact' ? 'active' : '' }}">
        	<a href="{{ route('contact') }}">Contact Us</a>
        </li>
    </ul>
</nav>