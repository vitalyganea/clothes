@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Shops</h1>
        @auth
            <a href="{{ route('shops.create') }}" class="btn btn-primary mb-3">Add New Shop</a>
        @endauth
        <div class="row" id="shop-list">
            @forelse ($shops as $shop)

                <div class="col-lg-3 col-md-4 col-sm-6 shop-item"> <!-- Large screens: 4 items, Medium: 3, Small: 2 -->
                    <a href="{{ route('shop.show', $shop->id) }}">
                        <div class="card mb-4 shop-card">
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
                            </div>
                                @if($shop->products)
                                    {{count($shop->products)}} products for sale
                                @endif
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
