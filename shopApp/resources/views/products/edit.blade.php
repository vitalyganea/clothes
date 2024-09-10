@extends('layouts.app')

@section('content')
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="images">Images</label>
{{--            @foreach ($product->images as $image)--}}
{{--                <img src="{{ Storage::url($image->path) }}" alt="Product Image" width="150">--}}
{{--            @endforeach--}}
            <input type="file" id="images" name="images[]" class="form-control-file" multiple>
        </div>
        <button type="submit" class="btn btn-primary">Update Product</button>
    </form>
@endsection
