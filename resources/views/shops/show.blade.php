@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center my-5">
            <!-- Left Side: Title and Description -->
            <div class="col-md-6">
                <h1 class="display-4">{{$shop->name}}</h1>
                <p class="lead">
                    {{$shop->description}}
                </p>
            </div>

            <!-- Right Side: Image -->
            <div class="col-md-6">
                <img src="{{ Storage::url($shop->image) }}" class="img-fluid" alt="Shop Image">
            </div>
        </div>

        <!-- Products Section -->
        <h1 class="my-4">Products: <i>{{count($shop->products)}} </i></h1>

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
{{--                <p>No products available.</p>--}}
            @endforelse
        </div>
    </div>
@endsection

<style>
    .product-card {
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

    .product-card:hover .card-img {
        transform: scale(1.1);
    }

    .card-body {
        text-align: center;
    }

    @media (max-width: 767px) {
        .image-container {
            height: 400px;
        }
    }

    .product-card a {
        text-decoration: none !important;
        color: inherit;
    }

    .product-card a:hover,
    .product-card a:focus {
        text-decoration: none !important;
    }

    .title-container {
        height: 80px;
    }
</style>
