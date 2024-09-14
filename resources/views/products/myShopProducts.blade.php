@extends('layouts.app')

@section('content')
    <h1>Products for {{ $shop->name }}</h1>
    <a href="{{ route('products.create', $shop->id) }}" class="btn btn-primary mb-3">Add New Product</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach ($shop->products as $product)
            <div class="col-md-4 mb-4">
                <div class="card">
{{--                    @if ($product->images->isNotEmpty())--}}
{{--                        <img src="{{ Storage::url($product->images->first()->path) }}" class="card-img-top" alt="{{ $product->name }}">--}}
{{--                    @endif--}}
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit Product</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
