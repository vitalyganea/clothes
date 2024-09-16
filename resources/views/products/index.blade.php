@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Products</h1>
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
        let loading = false;
        let page = 1;
        let hasMoreProducts = true; // Flag to check if there are more products to load

        const loadMoreProducts = () => {
            if (loading || !hasMoreProducts) return;

            loading = true;
            page++;

            fetch(`/?page=${page}`)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newProducts = doc.querySelector('#product-list');
                    const newPagination = doc.querySelector('#pagination'); // The invisible div for pagination

                    // Check if newProducts is empty or if pagination links are not present
                    if (!newProducts || !newProducts.innerHTML.trim()) {
                        hasMoreProducts = false; // No more products to load
                        window.removeEventListener('scroll', onScroll);
                        return;
                    }

                    document.querySelector('#product-list').insertAdjacentHTML('beforeend', newProducts.innerHTML);

                    // Update pagination content
                    if (newPagination && newPagination.innerHTML.trim()) {
                        document.querySelector('#pagination').innerHTML = newPagination.innerHTML;
                    } else {
                        hasMoreProducts = false; // No more pagination links, stop loading
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

        document.querySelectorAll('.image-container').forEach(container => {
            const images = Array.from(container.querySelectorAll('img'));
            const leftButton = container.querySelector('.nav-button.left');
            const rightButton = container.querySelector('.nav-button.right');
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
            leftButton.addEventListener('click', () => {
                const newIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(newIndex);
            });

            // Event listener for right button
            rightButton.addEventListener('click', () => {
                const newIndex = (currentIndex + 1) % images.length;
                showImage(newIndex);
            });
        });

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

</style>