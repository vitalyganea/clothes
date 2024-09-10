@extends('layouts.app')

@section('content')
    <h1>Edit Shop</h1>
    <form action="{{ route('shops.update', $shop->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Shop Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $shop->name) }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" required>{{ old('description', $shop->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            @if ($shop->image)
                <img src="{{ Storage::url($shop->image) }}" alt="Shop Image" width="150">
            @endif
            <input type="file" id="image" name="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Update Shop</button>
    </form>
@endsection
