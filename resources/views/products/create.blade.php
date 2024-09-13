@extends('layouts.app')

@section('content')
    <h1>Add Product to {{ $shop->name }}</h1>
    <form action="{{ route('products.store', $shop->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" id="price" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="images">Images</label>
            <input type="file" id="images" name="images[]" class="form-control-file" multiple>
        </div>
        <div class="form-group">
            <label for="category_id" class="form-label">Select Category:</label>
            <select class="form-select" id="category_id" name="category_id" required>
                @foreach($productCategories as $productCategory)
                    <option value="{{$productCategory->id}}">{{$productCategory->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="size_id" class="form-label">Select Category:</label>
            <select class="form-select" id="size_id" name="size_id" required>
                @foreach($productSizes as $productSizes)
                    <option value="{{$productSizes->id}}">{{$productSizes->size_name}}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
@endsection
