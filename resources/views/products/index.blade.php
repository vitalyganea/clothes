@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Products</h1>

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
                                            <input type="number" id="min-price" name="min_price"
                                                   class="form-control min-price" placeholder="Min Price"
                                                   value="{{$minPrice}}">
                                            <div class="divider"></div>
                                            <input type="number" id="max-price" name="max_price"
                                                   class="form-control max-price" placeholder="Max Price"
                                                   value="{{$maxPrice}}">
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
                <div class="col-md-3 col-sm-6 product-item">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category-select');
        const sizesSelect = document.getElementById('sizes-select');
        const filterForm = document.getElementById('filter-form');
        const productList = document.getElementById('product-list');
        const pagination = document.getElementById('pagination');
        const noProductsDiv = document.getElementById('no-products'); // Div to show when no products are found
        const resetButton = document.getElementById('reset-filters');
        const minPriceInput = document.getElementById('min-price');
        const maxPriceInput = document.getElementById('max-price');
        const sortSelect = document.getElementById('sort-select');
        let loadingMore = false;

        // Extract URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const previouslySelectedSize = urlParams.get('size') || '';
        const previouslySelectedCategory = urlParams.get('category') || '';

        // Initialize image navigation for image carousels
        const initializeImageNavigation = () => {
            document.querySelectorAll('.image-container').forEach(container => {
                const images = Array.from(container.querySelectorAll('img'));
                const leftButton = container.querySelector('.nav-button.left');
                const rightButton = container.querySelector('.nav-button.right');

                if (images.length === 0) {
                    return; // No images to display
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

        // Function to update size options based on selected category
        const updateSizes = (categoryId) => {
            if (categoryId === "") {
                // If "All Categories" is selected, reset sizes to "All Sizes"
                sizesSelect.innerHTML = '<option value="">All Sizes</option>';
                sizesSelect.value = ""; // Deselect any selected size
                sizesSelect.disabled = true; // Disable sizes select
            } else {
                // Fetch sizes for the selected category
                fetch(`/category/${categoryId}/sizes`)
                    .then(response => response.json())
                    .then(sizes => {
                        sizesSelect.innerHTML = '<option value="">All Sizes</option>';
                        sizesSelect.disabled = false; // Enable sizes select

                        let sizeFound = false;

                        sizes.forEach(size => {
                            const option = document.createElement('option');
                            option.value = size.id;
                            option.textContent = size.size_name;

                            if (size.id == previouslySelectedSize) {
                                option.selected = true;
                                sizeFound = true;
                            }

                            sizesSelect.appendChild(option);
                        });

                        if (!sizeFound) {
                            sizesSelect.value = "";
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching sizes:', error);
                    });
            }
        };

        // Function to update URL parameters without reloading the page
        const updateURL = (categoryId, sizeId, minPrice, maxPrice, sortBy) => {
            let url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);

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

            if (minPrice === "" && maxPrice === "") {
                params.delete('min_price');
                params.delete('max_price');
            } else {
                if (minPrice) params.set('min_price', minPrice);
                if (maxPrice) params.set('max_price', maxPrice);
            }

            if (sortBy === "") {
                params.delete('sort');
            } else {
                params.set('sort', sortBy);
            }

            // Remove URL parameters if no filters are applied
            if (!params.toString()) {
                history.replaceState({}, '', window.location.pathname);
            } else {
                window.history.replaceState({}, '', `${url.pathname}?${params.toString()}`);
            }
        };

        // Function to fetch and display products based on filters
        const fetchProducts = (formData, append = false) => {
            loadingMore = true;
            fetch(`/?${new URLSearchParams(formData).toString()}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newProducts = doc.querySelector('#product-list');
                    const newPagination = doc.querySelector('#pagination'); // The invisible div for pagination

                    if (newProducts && newProducts.innerHTML.trim()) {
                        if (append) {
                            productList.insertAdjacentHTML('beforeend', newProducts.innerHTML);
                        } else {
                            productList.innerHTML = newProducts.innerHTML;
                        }

                        initializeImageNavigation();
                        pagination.innerHTML = newPagination.innerHTML;
                        noProductsDiv.style.display = 'none'; // Hide "No products found" message
                    } else {
                        productList.innerHTML = ''; // Clear the product list
                        noProductsDiv.style.display = 'block'; // Show "No products found" message
                    }

                    loadingMore = false;
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                    loadingMore = false;
                });
        };

        // Initialize size select based on the category and previously selected size
        if (previouslySelectedCategory) {
            categorySelect.value = previouslySelectedCategory;
            updateSizes(previouslySelectedCategory);
        }

        // Set previously selected size
        sizesSelect.value = previouslySelectedSize;

        // Event listener for the "Apply" button
        filterForm.addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent normal form submission
            const formData = new FormData(filterForm);
            fetchProducts(formData);
            const categoryId = categorySelect.value;
            const sizeId = sizesSelect.value;
            const minPrice = minPriceInput.value;
            const maxPrice = maxPriceInput.value;
            const sortBy = sortSelect.value;
            updateURL(categoryId, sizeId, minPrice, maxPrice, sortBy);
        });

        // Event listener for filter changes
        categorySelect.addEventListener('change', function () {
            const categoryId = this.value;
            updateSizes(categoryId); // Update sizes for the selected category
            updateURL(categoryId, sizesSelect.value, minPriceInput.value, maxPriceInput.value, sortSelect.value); // Update the URL
        });

        sizesSelect.addEventListener('change', function () {
            updateURL(categorySelect.value, this.value, minPriceInput.value, maxPriceInput.value, sortSelect.value);
        });

        minPriceInput.addEventListener('input', function () {
            updateURL(categorySelect.value, sizesSelect.value, this.value, maxPriceInput.value, sortSelect.value);
        });

        maxPriceInput.addEventListener('input', function () {
            updateURL(categorySelect.value, sizesSelect.value, minPriceInput.value, this.value, sortSelect.value);
        });

        sortSelect.addEventListener('change', function () {
            updateURL(categorySelect.value, sizesSelect.value, minPriceInput.value, maxPriceInput.value, this.value);
        });

        // Reset filters functionality
        if (resetButton !== null) {
            resetButton.addEventListener('click', function () {
                filterForm.reset();
                updateURL('', '', '', '', '');
                fetchProducts(new FormData(filterForm)); // Fetch products with reset filters
            });
        }

        // Infinite Scroll
        window.addEventListener('scroll', function () {
            const scrollPosition = window.scrollY + window.innerHeight;
            const triggerPosition = document.documentElement.scrollHeight - 100;

            if (scrollPosition >= triggerPosition && !loadingMore) {
                const formData = new FormData(filterForm);
                const nextPage = pagination.querySelector('a[rel="next"]');

                if (nextPage) {
                    formData.set('page', nextPage.getAttribute('href').split('page=')[1]);
                    fetchProducts(formData, true); // Append new products
                }
            }
        });

        // Initial load
        // fetchProducts(new FormData(filterForm));

        // Initialize image navigation for initially loaded products
        initializeImageNavigation();
    });
</script>
