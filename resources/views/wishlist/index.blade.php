@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Wishlist</h1>
        <div class="row mt-4" id="product-list">
            @forelse ($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 product-item">
                    <div class="card mb-4 product-card">
                        <!-- If the product has images -->
                        @if ($product->images->count() > 0)
                            <div class="image-container" >
                                @foreach ($product->images as $index => $image)
                                    <img src="{{ asset($image->path) }}" class="card-img" alt="{{ $product->name }}"
                                         data-index="{{ $index }}">
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
                                <img src="{{ asset('assets/images/150.png') }}" class="card-img" alt="No image available">
                            </div>
                        @endif
                        <div class="product-card-body">
                            <h4 class="product-card-title">{{$product->name}}</h4>
                            <p class="product-card-custom">
                                <a href="?category={{$product->productCategory['id']}}"> {{$product->productCategory['name']}}</a>
                                - {{$product->productSize->size_name}}</p>
                            <p class="product-card-custom"><span class="product-card-price">{{$product->price}} MDL</span>
                            <div class="row">
                                <div class="col-md-6 card-button">
                                    <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="card-button-inner bag-button">Remove</button>
                                    </form>
                                </div>
                                <div class="col-md-6 card-button"><a href="{{ route('products.show', $product->id) }}"><div class="card-button-inner wish-button">DETAILS</div></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{--                <p>No products available.</p>--}}
            @endforelse
        </div>
    </div>
@endsection

<script>
    // Image Navigation Script (standalone)
    // Initializes image navigation for image carousels on a page
    const initializeImageNavigation = () => {
        document.querySelectorAll('.image-container').forEach(container => {
            const images = Array.from(container.querySelectorAll('img'));
            const leftButton = container.querySelector('.nav-button.left');
            const rightButton = container.querySelector('.nav-button.right');

            if (images.length === 0) {
                return; // No images to display
            }

            let currentIndex = 0;
            let startX = 0;
            let endX = 0;

            // Show the first image by default
            images[currentIndex].classList.add('active');

            // Function to show image at given index
            const showImage = (index) => {
                images.forEach((img, i) => {
                    img.classList.toggle('active', i === index);
                });
                currentIndex = index;
            };

            // Event listener for left button
            if (leftButton) {
                leftButton.addEventListener('click', () => {
                    const newIndex = (currentIndex - 1 + images.length) % images.length;
                    showImage(newIndex);
                });
            }

            // Event listener for right button
            if (rightButton) {
                rightButton.addEventListener('click', () => {
                    const newIndex = (currentIndex + 1) % images.length;
                    showImage(newIndex);
                });
            }

            // Add swipe detection for mobile
            container.addEventListener('touchstart', (e) => {
                startX = e.touches[0].clientX;
            });

            container.addEventListener('touchmove', (e) => {
                endX = e.touches[0].clientX;
            });

            container.addEventListener('touchend', () => {
                const swipeDistance = endX - startX;

                // Swipe left to show next image
                if (swipeDistance < -50) {
                    const newIndex = (currentIndex + 1) % images.length;
                    showImage(newIndex);
                }

                // Swipe right to show previous image
                if (swipeDistance > 50) {
                    const newIndex = (currentIndex - 1 + images.length) % images.length;
                    showImage(newIndex);
                }
            });
        });
    };

    // Initialize image navigation on page load
    window.addEventListener('load', initializeImageNavigation);

</script>