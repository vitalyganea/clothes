@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Products</h1>

        <div class="accordion" id="filterAccordion">
            <div class="accordion-item mb-4">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="{{ $filterIsEmpty ? 'false' : 'true' }}" aria-controls="collapseOne">
                        Filter Products
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse {{ $filterIsEmpty ? '' : 'show' }}" aria-labelledby="headingOne" data-bs-parent="#filterAccordion">
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
                                            <input type="number" id="min-price" name="min_price" class="form-control min-price" placeholder="Min Price" value="{{$minPrice}}">
                                            <div class="divider"></div>
                                            <input type="number" id="max-price" name="max_price" class="form-control max-price" placeholder="Max Price" value="{{$maxPrice}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-6">
                                    <label for="sort">Sort By</label>
                                    <select id="sort-select" name="sort" class="form-control">
                                        <option value="">Default</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                        <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Date: Oldest First</option>
                                        <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Date: Newest First</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-4">
                                    <button type="submit" class="btn btn-primary">Apply</button>
                                    @if(!$filterIsEmpty)
                                        <button type="button" id="reset-filters" class="btn btn-secondary ms-2">Reset</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" id="product-list">
            @forelse ($products as $product)
                <div class="col-md-3 col-sm-6 product-item">
                    <div class="card mb-4 product-card">
                        <!-- If the product has images -->
                        @if ($product->images->count() > 0)
                            <div class="image-container">
                                @foreach ($product->images as $index => $image)
                                    <img src="{{ asset($image->path) }}" class="card-img" alt="{{ $product->name }}" data-index="{{ $index }}">
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
                        <a href="{{ route('products.show', $product->id) }}">
                            <div class="card-body title-container">
                                <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                            </div>
                            <div class="container">
                                <div class="row text-center mb-4">
                                    <div class="col-md-3">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        {{count($product->uniqueViews)}}
                                    </div>
                                    <div class="col-md-6">
                                        <p>
                                            {{$product->productCategory['name']}}
                                        </p>
                                    </div>
                                    <div class="col-md-3">
                                        <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                        {{$product->productSize['size_name']}}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                {{--                <p>No products available.</p>--}}
            @endforelse
        </div>

        <!-- Invisible div for pagination -->
        <div id="pagination" style="display: none;">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category-select');
        const sizesSelect = document.getElementById('sizes-select');
        const previouslySelectedSize = "{{ request('size') }}"; // Fetch previously selected size from the server

        const updateSizes = (categoryId) => {
            fetch(`/category/${categoryId}/sizes`)
                .then(response => response.json())
                .then(sizes => {
                    sizesSelect.innerHTML = '<option value="">All Sizes</option>';

                    let sizeFound = false;

                    sizes.forEach(size => {
                        const option = document.createElement('option');
                        option.value = size.id;
                        option.textContent = size.size_name;

                        // Set the previously selected size as selected if it exists in the new category
                        if (size.id == previouslySelectedSize) {
                            option.selected = true;
                            sizeFound = true;
                        }

                        sizesSelect.appendChild(option);
                    });

                    // If the previously selected size is not found, ensure "All Sizes" is selected
                    if (!sizeFound) {
                        sizesSelect.value = "";
                    }
                })
                .catch(error => {
                    console.error('Error fetching sizes:', error);
                });
        };

        const updateURL = (categoryId, sizeId) => {
            let url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

            // Remove parameters if "All categories" or "All sizes" is selected
            if (categoryId === "") {
                params.delete('category');
            } else {
                params.set('category', categoryId);
            }

            if (sizeId === "") {
                params.delete('size');
            } else {
                params.set('size', sizeId);
            }

            // Update URL without reloading the page
            window.history.replaceState({}, '', `${url.pathname}?${params.toString()}`);
        };

        const initializeImageNavigation = () => {
            document.querySelectorAll('.image-container').forEach(container => {
                const images = Array.from(container.querySelectorAll('img'));
                const leftButton = container.querySelector('.nav-button.left');
                const rightButton = container.querySelector('.nav-button.right');

                if (images.length === 0) {
                    // No images to display
                    return;
                }

                let currentIndex = 0;

                // Show the first image by default
                images[currentIndex].classList.add('active');

                // Function to show image at given index
                const showImage = (index) => {
                    images.forEach((img, i) => {
                        img.classList.toggle('active', i === index);
                    });
                    currentIndex = index;
                };

                // Event listener for left button
                if (leftButton) {
                    leftButton.addEventListener('click', () => {
                        const newIndex = (currentIndex - 1 + images.length) % images.length;
                        showImage(newIndex);
                    });
                }

                // Event listener for right button
                if (rightButton) {
                    rightButton.addEventListener('click', () => {
                        const newIndex = (currentIndex + 1) % images.length;
                        showImage(newIndex);
                    });
                }
            });
        };

        categorySelect.addEventListener('change', function () {
            const categoryId = this.value;
            updateSizes(categoryId);
            updateURL(categoryId, sizesSelect.value);
        });

        sizesSelect.addEventListener('change', function () {
            const sizeId = this.value;
            updateURL(categorySelect.value, sizeId);
        });

        // Initialize size dropdown based on the current category
        const initialCategoryId = categorySelect.value;
        if (initialCategoryId) {
            updateSizes(initialCategoryId);
        }

        // Reset filters functionality
        const resetButton = document.getElementById('reset-filters');
        if(resetButton !== null) {
            resetButton.addEventListener('click', function () {
                const form = document.getElementById('filter-form');
                form.reset();
                // Clear URL parameters
                window.history.replaceState({}, '', window.location.pathname);
                location.reload();
            });
        }

        // Load more products on scroll
        let loading = false;
        let page = 1;
        let hasMoreProducts = true; // Flag to check if there are more products to load

        const loadMoreProducts = () => {
            if (loading || !hasMoreProducts) return;

            loading = true;
            page++;

            // Get the current filter values from the form
            const form = document.getElementById('filter-form');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);

            // Append the page number to the query parameters
            params.append('page', page);

            fetch(`/?${params.toString()}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newProducts = doc.querySelector('#product-list');
                    const newPagination = doc.querySelector('#pagination'); // The invisible div for pagination

                    if (!newProducts || !newProducts.innerHTML.trim()) {
                        hasMoreProducts = false; // No more products to load
                        window.removeEventListener('scroll', onScroll);
                        return;
                    }

                    document.querySelector('#product-list').insertAdjacentHTML('beforeend', newProducts.innerHTML);

                    // Initialize image navigation for newly added products
                    initializeImageNavigation();

                    if (newPagination && newPagination.innerHTML.trim()) {
                        document.querySelector('#pagination').innerHTML = newPagination.innerHTML;
                    } else {
                        hasMoreProducts = false;
                        window.removeEventListener('scroll', onScroll);
                    }

                    loading = false;
                })
                .catch(error => {
                    console.error('Error loading more products:', error);
                    loading = false;
                });
        };

        const onScroll = () => {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                loadMoreProducts();
            }
        };

        window.addEventListener('scroll', onScroll);

        // Initialize image navigation for initially loaded products
        initializeImageNavigation();
    });

</script>

<style>
    .product-card {
        width: 100%;
        height: 100%;
        overflow: hidden; /* Ensure that any overflow is hidden */
        position: relative; /* Position relative for positioning effects */
        transition: transform 0.3s ease; /* Smooth transition for hover effect */
    }

    .image-container {
        height: 200px; /* Default height */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative; /* Position relative for positioning effects */
    }

    .card-img {
        min-height: 100%;
        object-fit: cover;
        width: 100%;
        transition: transform 0.3s ease; /* Smooth transition for hover effect */
        display: none; /* Hide all images by default */
    }

    .card-img.active {
        display: block; /* Show only the active image */
    }

    .product-card:hover .card-img {
        transform: scale(1.1); /* Zoom out effect */
    }

    .card-body {
        text-align: center;
    }

    .image-navigation {
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .nav-button {
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 18px;
        transition: background 0.3s ease;
    }

    .nav-button:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .image-container:hover .image-navigation {
        opacity: 1; /* Show navigation on hover */
    }

    /* Media query for mobile devices */
    @media (max-width: 767px) {
        .image-container {
            height: 400px; /* Increase height for mobile devices */
        }
    }

    /* Remove underline from all links within product cards */
    .product-card a {
        text-decoration: none !important; /* Force remove underline */
        color: inherit; /* Ensure text color is consistent with parent element */
    }

    .product-card a:hover,
    .product-card a:focus {
        text-decoration: none !important; /* Remove underline on hover and focus */
    }

    .title-container {
        height: 50px;
    }

    .price-range-container {
        display: flex;
        align-items: center;
        border: 1px solid #ced4da;
        border-radius: 0.25rem; /* Adjust border radius as needed */
        overflow: hidden; /* Ensures that the inputs and divider stay within the border */
    }

    .price-range-container .form-control {
        border: none;
        border-radius: 0;
        border-right: 1px solid #ced4da; /* Divider line on the right of the first input */
        border-left: 0;
        border-top: 0;
        border-bottom: 0;
        box-shadow: none;
    }

    .price-range-container .form-control:last-child {
        border-right: 0; /* Removes the border on the right of the second input */
        border-left: 0;
    }

    .price-range-container .divider {
        width: 1px; /* Width of the divider line */
        background-color: #ced4da; /* Color of the divider line */
        height: 100%; /* Full height of the inputs */
    }

    .accordion-button:not(.collapsed) {
        color: var(--bs-accordion-active-color);
        background-color: transparent !important;
        box-shadow: inset 0 calc(-1* var(--bs-accordion-border-width)) 0 var(--bs-accordion-border-color);
    }

</style>