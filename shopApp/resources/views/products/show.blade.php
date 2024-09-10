@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>

        <div class="row">
            <div class="col-md-6">
                <!-- Display all images of the product -->
                @if ($product->images->count() > 0)
                    @foreach ($product->images as $image)
                        <img src="{{ asset($image->path) }}" class="img-fluid mb-2" alt="{{ $product->name }}">
                    @endforeach
                @else
                    <img src="https://via.placeholder.com/150" class="img-fluid" alt="No image available">
                @endif
            </div>
            <div class="col-md-6">
                <p>{{ $product->description }}</p>
                <!-- Add other product details here if needed -->
            </div>
        </div>
    </div>
@endsection
