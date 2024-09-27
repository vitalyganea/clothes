@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-3">
                @if ($product->images->count() > 0)
                    @php
                        $mainImage = $product->images->first();
                        $remainingImages = $product->images->slice(1);
                    @endphp
                    <div class="relative mb-4">
                        <a href="{{ $mainImage->path }}" data-lightbox="product-gallery" data-title="{{ $product->name }}">
                        <img src="{{ $mainImage->path }}" class="rounded main-center-cropped" alt="{{ $product->name }}">
                        </a>
                    </div>
                @else

                    <a href="https://via.placeholder.com/600x400" data-lightbox="product-gallery" data-title="{{ $product->name }}">
                        <img src="https://via.placeholder.com/600x400" class="rounded main-center-cropped" alt="{{ $product->name }}">
                    </a>
                    @php
                        $remainingImages = null;
                    @endphp
                @endif
            </div>

            <div class="col-md-9">
            <h1 class="text-3xl font-bold mb-4"><b>Title:</b> {{ $product->name }}
                @if(auth()->id() === $product->user_id)
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                        <i class="fa fa-pencil" style="font-size:24px"></i>
                    </a>


                @endif
            </h1>

                <div class="mb-4">
                    <p class="text-lg"><b>Description:</b> {!! $product->description !!}</p>
                </div>


                <div class="mb-4">
                    <p class="text-lg"><b>Size:</b> {{$product->productSize->size_name }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-lg"><b>Price:</b> {{$product->price }} mdl</p>
                </div>
                <div class="mb-4">
                    <p class="text-lg"><b>Category:</b>
                        <a href="/?category={{$product->productCategory->id}}">
                            {{$product->productCategory->name }}
                        </a>
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-lg">
                        <b>Shop:</b>
                        <a href="{{ route('shop.show', $product->shop_id)}}">
                        {{$product->shop->name }}
                        </a>
                    </p>
                </div>

                <div class="mb-4">
                    <p class="text-lg">
                        <b>Posted:</b>
                        {{$product->created_at->diffForHumans()}}
                    </p>
                </div>

            </div>
            @if($remainingImages)
                @foreach ($remainingImages as $image)
                    <div class="col-lg-2 col-md-3 col-sm-4 mb-4">
                        <a href="{{ $image->path }}" data-lightbox="product-gallery" data-title="{{ $product->name }}">
                            <img src="{{ $image->path }}" class="border rounded center-cropped" alt="{{ $product->name }}">
                        </a>
                    </div>
                @endforeach
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
    .main-center-cropped {
        width: 100%; /* Adjust to the desired width */
        height: 450px; /* Adjust to the desired height */
        object-fit: cover; /* This will crop the image to fit the container */
        overflow: hidden; /* Ensure that the overflow is hidden */
    }
</style>

