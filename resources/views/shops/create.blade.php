@extends('layouts.app')

@section('content')
    <h1>Add Shop</h1>
    <form action="{{ route('shops.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Shop Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Create Shop</button>
    </form>
@endsection
