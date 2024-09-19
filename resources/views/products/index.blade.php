@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Products</h1>
        <button id="scrollToTopBtn" class="btn" style="font-size:25px; display: none; position: fixed; bottom: 20px; right: 20px; z-index: 1000; background-color: black; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);">
            <i class="fa fa-arrow-up" aria-hidden="true"></i>
        </button>
        <div class="accordion sticky-filter" id="filterAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="{{ $filterIsEmpty ? 'false' : 'true' }}"
                            aria-controls="collapseOne">
                        Filter Products
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse {{ $filterIsEmpty ? '' : 'show' }}"
                     aria-labelledby="headingOne" data-bs-parent="#filterAccordion">
                    <div class="accordion-body">
                        <form id="filter-form" action="{{ url()->current() }}" method="GET">
                            <div class="row">
                                <div class="col-md-2 col-sm-6">
                                    <label for="category">Category</label>
                                    <select id="category-select" name="category" class="form-control">
                                        <option value="">All Categories</option>
                                        @foreach ($productCategories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-6">
                                    <label for="size">Size</label>
                                    <select id="sizes-select" name="size" class="form-control">
                                        <option value="">All Sizes</option>
                                        <!-- This will be populated dynamically by JavaScript -->
                                    </select>
                                </div>

                                <div class="col-md-2 col-sm-6">
                                    <div class="form-group">
                                        <label for="price-range" class="d-block">Price Range</label>
                                        <div class="price-range-container">
                                            <input type="text" id="min-price" name="min_price"
                                                   class="form-control min-price" placeholder="Min Price"
                                                   value="{{$minPrice}}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            <div class="divider"></div>
                                            <input type="text" id="max-price" name="max_price"
                                                   class="form-control max-price" placeholder="Max Price"
                                                   value="{{$maxPrice}}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-6">
                                    <label for="sort">Sort By</label>
                                    <select id="sort-select" name="sort" class="form-control">
                                        <option value="">Default</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                            Price: Low to High
                                        </option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                            Price: High to Low
                                        </option>
                                        <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>
                                            Date: Oldest First
                                        </option>
                                        <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>
                                            Date: Newest First
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-4">
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                    <button type="button" id="reset-filters" class="btn btn-secondary ms-2">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4" id="product-list">
            @forelse ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 product-item">
                    <div class="card mb-4 product-card">
                        <!-- If the product has images -->
                        @if ($product->images->count() > 0)
                            <div class="image-container">
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
                                <img src="https://via.placeholder.com/150" class="card-img" alt="No image available">
                            </div>
                        @endif
                        <div class="card-body title-container">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                        </div>
                        <div class="container">
                            <div class="row text-center mb-4 d-flex justify-content-between align-items-center"> <!-- Flexbox container -->
                                <div class="col-md-4 text-left"> <!-- Left aligned category -->
                                    {{$product->productCategory['name']}}
                                </div>
                                <div class="col-md-4 text-center"> <!-- Center aligned size -->
                                    {{$product->productSize['size_name']}}
                                </div>
                                <div class="col-md-4 text-right circle-counter-container">
                                    <!-- Right aligned views inside a circle -->
                                    <div class="circle-counter">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        {{count($product->uniqueViews)}}
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center mb-4 d-flex align-items-center"> <!-- Flex container -->
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <!-- Price and details in one flex container -->
                                    <span class="custom-label"> <!-- Using custom label class -->
                {{$product->price}} MDL
            </span>
                                    <a href="{{ route('products.show', $product->id) }}" class="hover-reverse">
                                        <!-- Hover-reverse button -->
                                        Details
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
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <i class="fa fa-box-open fa-4x mb-4" aria-hidden="true"></i>
                        <h3 class="card-title">No Products Found</h3>
                        <p class="card-text">Sorry, we couldn't find any products that match your search criteria. Try adjusting your filters or check back later!</p>
                        <a href="/" class="btn btn-primary mt-3">Go Back to Shop</a>
                    </div>
                </div>
            </div>
        <!-- Invisible div for pagination -->
        <div id="pagination" style="display: none;">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/product/index.js') }}"></script>
@endpush

<style>
    #scrollToTopBtn {
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.5s ease; /* Add this line if not set via JS */
    }
</style>