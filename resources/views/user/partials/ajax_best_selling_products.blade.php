<section class="product__section section--padding pt-0"  style="padding-bottom: 6rem !important;">
    <div class="container-fluid">
        <div class="section__heading mb-2 border-bottom d-flex">
            <h2 class="section__heading-- style2 flex-grow-1">Best Selling Products</h2>
            <div class="btn_custom mb-2">
                <a class="primary__btn rounded shop_more_btn" href="{{route('products.individual.group', ['slug'=>'best-selling'])}}">Shop More
                    <svg class="primary__btn--arrow__icon" xmlns="http://www.w3.org/2000/svg" width="20.2" height="12.2" viewBox="0 0 6.2 6.2">
                    <path d="M7.1,4l-.546.546L8.716,6.713H4v.775H8.716L6.554,9.654,7.1,10.2,9.233,8.067,10.2,7.1Z" transform="translate(-4 -4)" fill="currentColor"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="product__section--inner">
            <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 mb--n30">
                @if(count($best_selling_products) > 0)
                    @foreach($best_selling_products as $product)
                        @include('user.partials.product')
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>