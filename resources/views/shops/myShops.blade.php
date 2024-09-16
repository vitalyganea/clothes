@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Shops</h1>
        @auth
            <a href="{{ route('shops.create') }}" class="btn btn-primary mb-3">Add New Shop</a>
        @endauth

        @if(session('success'))
            <div id="success-message" data-success="{{ session('success') }}"></div>
        @endif

        <div class="row" id="shop-list">
            @forelse ($shops as $shop)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 shop-item"> <!-- Large screens: 4 items, Medium: 3, Small: 2 -->
                    <a href="{{ route('shop.show', $shop->id) }}">
                        <div class="card shop-card">
                            <!-- If the shop has an image -->
                            @if ($shop->image)
                                <div class="image-container">
                                    <img src="{{ Storage::url($shop->image) }}" class="card-img" alt="{{ $shop->name }}">
                                </div>
                            @else
                                <div class="image-container">
                                    {{-- <img src="https://via.placeholder.com/150" class="card-img" alt="No image available"> --}}
                                </div>
                            @endif
                            <div class="card-body title-container">
                                <h5 class="card-title">{{ $shop->name }}</h5>
                                @if($shop->products)
                                    <p>{{ count($shop->products) }} products for sale</p>
                                @endif
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('shops.products', $shop->id) }}" class="btn btn-info btn-sm">View Products</a>
                                <a href="{{ route('shops.edit', $shop->id) }}" class="btn btn-warning btn-sm">Edit Shop</a>
                                <form action="{{ route('shops.destroy', $shop->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete Shop</button>
                                </form>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p>No shops available.</p>
            @endforelse
        </div>
    </div>
@endsection

<style>
    .shop-card {
        width: 100%;
        height: 100%;
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease;
    }

    .image-container {
        height: 200px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .card-img {
        min-height: 100%;
        object-fit: cover;
        width: 100%;
        transition: transform 0.3s ease;
    }

    .shop-card:hover .card-img {
        transform: scale(1.1);
    }

    .shop-card:hover {
        transform: scale(1.05);
    }

    .card-body {
        text-align: center;
    }

    .title-container {
        height: 80px;
    }

    @media (max-width: 767px) {
        .image-container {
            height: 400px;
        }
    }

    .shop-card a {
        text-decoration: none !important;
        color: inherit;
    }

    .shop-card a:hover,
    .shop-card a:focus {
        text-decoration: none !important;
    }
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check for success message in session
        const successMessage = document.getElementById('success-message');
        if (successMessage) {
            Swal.fire({
                title: 'Success!',
                text: successMessage.getAttribute('data-success'),
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }

        // Add SweetAlert2 delete confirmation
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
