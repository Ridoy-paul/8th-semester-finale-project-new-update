<div class="account__left--sidebar pe-2 me-4">
    <h2 class="account__content--title h3 mb-20">Hello, Riody Paul</h2>
    <ul class="account__menu">
        <li class="account__menu--list @if(Request::url() === route('customer.account')) active @endif"><a href="{{route('customer.account')}}">Dashboard</a></li>
        <li class="account__menu--list @if(Request::url() === route('customer.profile')) active @endif"><a href="{{route('customer.profile')}}">Profile</a></li>
        <li class="account__menu--list @if(Request::url() === route('customer.orders')) active @endif"><a href="{{route('customer.orders')}}">Orders</a></li>
        <li class="account__menu--list @if(Request::url() === route('customer.reviews')) active @endif"><a href="{{route('customer.reviews')}}">Reviews</a></li>
        
        {{-- <li class="account__menu--list"><a href="my-account.html">Wallet</a></li> --}}
        <li class="account__menu--list @if(Request::url() === route('customer.wishlist')) active @endif"><a href="{{route('customer.wishlist')}}">Wishlist</a></li>
        <li class="account__menu--list">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </li>
    </ul>
</div>