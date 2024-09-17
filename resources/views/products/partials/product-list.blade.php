<div id="product-list">
    @foreach ($products as $product)
        <div class="col-md-3 col-sm-6 product-item">
            <a href="{{ route('products.show', $product->id) }}">
                <div class="card mb-4 product-card">
                    <!-- If the product has images -->
                    @if ($product->images->count() > 0)
                        <div class="image-container">
                            @foreach ($product->images as $index => $image)
                                <img src="{{ asset($image->path) }}" class="card-img" alt="{{ $product->name }}" data-index="{{ $index }}">
                            @endforeach
                            <div class="image-navigation">
                                <button class="nav-button left">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </button>
                                <button class="nav-button right">
                                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="image-container">
                            <img src="https://via.placeholder.com/150" class="card-img" alt="No image available">
                        </div>
                    @endif
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="card-body title-container">
                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                        </div>
                        <div class="container">
                            <div class="row text-center mb-4">
                                <div class="col-md-3">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    {{count($product->uniqueViews)}}
                                </div>
                                <div class="col-md-6">
                                    <p>
                                        {{$product->productCategory['name']}}
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                    {{$product->productSize['size_name']}}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </a>
        </div>
    @endforeach
</div>

<!-- Invisible div for pagination -->
<div id="pagination" style="display: none;">
    {{ $products->links('pagination::bootstrap-4') }}
</div>
