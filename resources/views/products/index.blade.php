@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="title">All Products</h1>
        @include('products.partials.filter')
        <div class="row mt-4" id="product-list">
            @forelse ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 product-item">
                    <div class="card mb-4 product-card">
                        <!-- If the product has images -->
                        @if ($product->images->count() > 0)
                            <div class="image-container" >
                                @foreach ($product->images as $index => $image)
                                    <img src="{{ asset($image->path) }}" class="card-img" alt="{{ $product->name }}"
                                         data-index="{{ $index }}">
                                @endforeach
                                <div class="image-navigation">
                                    <button class="nav-button left">
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    </button>
                                    <button class="nav-button right">
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="image-container">
                                <img src="{{ asset('assets/images/150.png') }}" class="card-img" alt="No image available">
                            </div>
                        @endif
                        <div class="product-card-body">
                            <h4 class="product-card-title">{{$product->name}}</h4>
                            <p class="product-card-custom">
                                <a href="?category={{$product->productCategory['id']}}"> {{$product->productCategory['name']}}</a>
                                - {{$product->productSize->size_name}}</p>
                            <p class="product-card-custom"><span class="product-card-price">{{$product->price}} MDL</span>
                            <div class="row">
                                <div class="col-md-6 card-button">
                                    @if (Auth::check())
                                        <a id="wishlist-button-{{ $product->id }}" onclick="toggleWishlist({{ $product->id }}, {{ $product->isWishlist ? 'true' : 'false' }})">
                                            <div id="wishlist-button-inner-{{ $product->id }}" class="card-button-inner cursor-pointer {{ $product->isWishlist ? 'bag-button' : 'wish-button' }}">
                                                {{ $product->isWishlist ? 'IN WISHLIST' : 'ADD WISHLIST' }}
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}">
                                            <div class="card-button-inner cursor-pointer wish-button">
                                                ADD WISHLIST
                                            </div>
                                        </a>
                                    @endif
                                </div>
                                <div class="col-md-6 card-button">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <div class="card-button-inner wish-button">DETAILS</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{--                <p>No products available.</p>--}}
            @endforelse
        </div>
            <div class="container text-center mt-5" id="no-products" style="display:none;">
                    <div class="card-body p-5">
                        <i class="fa fa-box-open fa-4x mb-4" aria-hidden="true"></i>
                        <h3 class="card-title">No Products Found</h3>
                        <p class="card-text">Sorry, we couldn't find any products that match your search criteria. Try adjusting your filters or check back later!</p>
                    </div>
            </div>
        <!-- Invisible div for pagination -->
        <div id="pagination" style="display: none;">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

@push('scripts')
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
{{--    <script src="{{ asset('js/product/index.js') }}"></script>--}}

    <script src="{{ asset('js/product/image-navigation.js') }}"></script>
    <script src="{{ asset('js/product/filter-update.js') }}"></script>
    <script src="{{ asset('js/product/reset-filter.js') }}"></script>
    <script src="{{ asset('js/product/infinite-scroll.js') }}"></script>
    <script src="{{ asset('js/product/size-update.js') }}"></script>
    <script src="{{ asset('js/product/add-to-wishlist.js') }}"></script>
@endpush
