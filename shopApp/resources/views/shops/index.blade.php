@extends('layouts.app')

@section('content')
    <h1>Shops</h1>
    <a href="{{ route('shops.create') }}" class="btn btn-primary mb-3">Add New Shop</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach ($shops as $shop)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if ($shop->image)
                        <img src="{{ Storage::url($shop->image) }}" class="card-img-top" alt="{{ $shop->name }}">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $shop->name }}</h5>
                        <p class="card-text">{{ $shop->description }}</p>
                        <a href="{{ route('shops.products', $shop->id) }}" class="btn btn-info">View Products</a>
                        <a href="{{ route('shops.edit', $shop->id) }}" class="btn btn-warning">Edit Shop</a>
                        <form action="{{ route('shops.destroy', $shop->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this shop?')">Delete Shop</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
