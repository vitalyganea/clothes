@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">

            <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

            <div class="mb-4">
                <p class="text-lg">{{ $product->description }}</p>
            </div>


            @if ($product->images->count() > 0)
                @foreach ($product->images as $image)
                    <div class="rounded border col m-2">
                        <a href="{{ $image->path }}" data-lightbox="product-gallery" data-title="{{ $product->name }}">
                            <img src="{{ $image->path }}" class="center-cropped" alt="{{ $product->name }}">
                        </a>
                    </div>
                @endforeach
            @else
                <img src="https://via.placeholder.com/150" class="center-cropped object-cover w-full h-full"
                     alt="No image available">
            @endif

        </div>
    </div>


@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>

<style>
    .center-cropped {
        width: 100%; /* Adjust to the desired width */
        height: 150px; /* Adjust to the desired height */
        object-fit: cover; /* This will crop the image to fit the container */
        overflow: hidden; /* Ensure that the overflow is hidden */
    }
</style>

