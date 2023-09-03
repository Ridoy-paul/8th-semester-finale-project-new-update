<div class="card">
    <div class="card-header bg-primary">
        <p style="color: #fff;font-size: 20px;margin: 0px;">Hello, {{ Auth::user()->name . ' ' . Auth::user()->last_name }}</p>
    </div>
  <ul class="list-group list-group-flush">
    <!-- <li class="list-group-item"><a href="">Dashboard</a></li> -->
    <li class="list-group-item"><a href="{{ route('customer.orders') }}">Orders</a></li>
    <li class="list-group-item"><a href="{{ route('customer.wishlist') }}">Wishlist</a></li>
    <li class="list-group-item"><a href="{{ route('customer.wallet') }}">My Wallet</a></li>
    <li class="list-group-item"><a href="{{ route('customer.account') }}">Account details</a></li>
    @if(Auth::user()->is_affiliate == 0)
    <li class="list-group-item"><a href="#affiliateModal" data-toggle="modal">Become an Affiliate</a></li>
    @endif
    @if(Auth::user()->is_affiliate == 1)
    <li class="list-group-item"><a href="{{ route('customer.affiliate.dashboard') }}">Affiliate Dashboard</a></li>
    @endif
    <li class="list-group-item">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-rounded">Logout</button>
        </form>
    </li>
  </ul>
</div>