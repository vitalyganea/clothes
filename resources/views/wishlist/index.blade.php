@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Wishlist</h1>

        <!-- Table layout for larger screens -->
        <div class="d-none d-md-block">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Product</th>
                    <th scope="col">Category</th>
                    <th scope="col">Size</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody id="wishlist-table-body">
                @forelse ($products as $product)
                    <tr id="wishlist-item-{{ $product->id }}">
                        <td>
                            @if ($product->images->count() > 0)
                                <img src="{{ asset($product->images->first()->path) }}" alt="{{ $product->name }}" class="wishlist-product-image">
                            @else
                                <img src="{{ asset('assets/images/150.png') }}" alt="No image available" class="wishlist-product-image">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->productCategory['name'] }}</td>
                        <td>{{ $product->productSize->size_name }}</td>
                        <td>{{ $product->price }} MDL</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm card-button-inner wish-button">Details</a>
                                <button class="btn btn-danger btn-sm card-button-inner bag-button" onclick="confirmRemoveWishlistItem({{ $product->id }})">Remove</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No products in your wishlist.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Card layout for mobile devices -->
        <div class="d-md-none">
            @forelse ($products as $product)
                <div class="card mb-3" id="wishlist-item-{{ $product->id }}">
                    <div class="row no-gutters">
                        <div class="col-4">
                            @if ($product->images->count() > 0)
                                <img src="{{ asset($product->images->first()->path) }}" alt="{{ $product->name }}" class="wishlist-product-image">
                            @else
                                <img src="{{ asset('assets/images/150.png') }}" alt="No image available" class="wishlist-product-image">
                            @endif
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">
                                    <strong>Category:</strong> {{ $product->productCategory['name'] }}<br>
                                    <strong>Size:</strong> {{ $product->productSize->size_name }}<br>
                                    <strong>Price:</strong> {{ $product->price }} MDL
                                </p>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-dark btn-sm">Details</a>
                                    <button class="btn btn-outline-dark btn-sm" onclick="confirmRemoveWishlistItem({{ $product->id }})">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center">No products in your wishlist.</p>
            @endforelse
        </div>
    </div>
@endsection




<script>
    // Confirm removal of wishlist item using SweetAlert2
    function confirmRemoveWishlistItem(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to remove this product from your wishlist?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                removeWishlistItem(productId); // Call the function to remove the item
            }
        });
    }

    // Remove wishlist item via AJAX
    function removeWishlistItem(productId) {
        fetch(`/wishlist/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Failed to remove product from wishlist.');
                }
            })
            .then(data => {
                // If successful, remove the item from the DOM
                document.getElementById(`wishlist-item-${productId}`).remove();

                // Show success message
                Swal.fire({
                    title: 'Product removed!',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500,
                    toast: true,
                    position: 'top-end'
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to remove product from wishlist.', 'error');
            });
    }
</script>

<style>
    .card-button-inner {
        display: inline-block;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 14px;
        text-align: center;
        width: 100%;
    }

     .btn-outline-dark {
         color: #000 !important; /* Black text */
         border-color: #000 !important; /* Black border */
     }

    .btn-outline-dark:hover {
        background-color: #000 !important; /* Black background on hover */
        color: #fff !important; /* White text on hover */
    }

    .wishlist-product-image {
        width: 180px;
        height: 180px;
        object-fit: cover;
        object-position: center;
    }
</style>
