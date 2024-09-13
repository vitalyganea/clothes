@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Products</h1>

        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('products.show', $product->id) }}">
                    <div class="card mb-4 product-card">
                        <!-- If the product has an image -->
                        @if ($product->images->count() > 0)
                            <div class="image-container">
                                <img src="{{ asset($product->images->first()->path) }}" class="card-img" alt="{{ $product->name }}">
                            </div>
                        @else
                            <div class="image-container">
                                <img src="https://via.placeholder.com/150" class="card-img" alt="No image available">
                            </div>
                        @endif
                        <div class="card-body title-container">
                            <h5 class="card-title">{{ $product->name }}</h5>
                        </div>
                    </div>
                    </a>
                </div>
            @empty
                <p>No products available.</p>
            @endforelse
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
@endsection

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
    }

    .product-card:hover .card-img {
        transform: scale(1.1); /* Zoom out effect */
    }

    .product-card:hover {
        transform: scale(1.05); /* Optional: Zoom out the entire card slightly */
    }

    .card-body {
        text-align: center;
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

    .title-container{
        height: 80px;
    }
</style>