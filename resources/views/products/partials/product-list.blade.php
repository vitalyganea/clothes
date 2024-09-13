<div id="product-list">
    @foreach ($products as $product)
        <div class="col-md-3 col-sm-6 product-item">
            <a href="{{ route('products.show', $product->id) }}">
                <div class="card mb-4 product-card">
                    <!-- If the product has an image -->
                    @if ($product->images->count() > 0)
                        <div class="image-container">
                            <img src="{{ asset($product->images->first()->path) }}" class="card-img" alt="{{ $product->name }}">
                        </div>
                    @else
                        <div class="image-container">
{{--                            <img src="https://via.placeholder.com/150" class="card-img" alt="No image available">--}}
                        </div>
                    @endif
                    <div class="card-body title-container">
                        <h5 class="card-title">{{ $product->name }}</h5>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<!-- Invisible div for pagination -->
<div id="pagination" style="display: none;">
    {{ $products->links('pagination::bootstrap-4') }}
</div>
