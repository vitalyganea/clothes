@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Products</h1>

        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <!-- If the product has an image -->
{{--                        @if ($product->images->count() > 0)--}}
{{--                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="card-img-top" alt="{{ $product->name }}">--}}
{{--                        @else--}}
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="No image available">
{{--                        @endif--}}
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
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
