@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Products for {{ $shop->name }}</h1>
        <a href="{{ route('products.create', $shop->id) }}" class="btn btn-primary mb-3">Add New Product</a>

        @if(session('success'))
            <div class="alert alert-success" id="success-message" style="display:none;">
                {{ session('success') }}
            </div>
        @endif

        <div class="row" id="product-list">
            @forelse ($shop->products as $product)
                <div class="col-md-3 col-sm-6 product-item">
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="card mb-4 product-card">
                            <!-- If the product has an image -->
                            @if ($product->images->count() > 0)
                                <div class="image-container">
                                    <img src="{{ asset($product->images->first()->path) }}" class="card-img" alt="{{ $product->name }}">
                                </div>
                            @else
                                <div class="image-container">
                                    {{-- <img src="https://via.placeholder.com/150" class="card-img" alt="No image available"> --}}
                                </div>
                            @endif
                            <div class="card-body title-container">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $product->id }})">Delete</button>
                                </form>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
{{--                <p>No products available.</p>--}}
            @endforelse
        </div>
    </div>
@endsection

<!-- Styles -->
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

    .card-body {
        text-align: center;
    }

    .title-container {
        height: 120px; /* Adjusted height to accommodate buttons */
    }

    .card-body .btn {
        margin: 5px; /* Space between buttons */
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
</style>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.2/sweetalert2.all.min.js"></script>
<script>
    function confirmDelete(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + productId).submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
        });
        @endif
    });
</script>
