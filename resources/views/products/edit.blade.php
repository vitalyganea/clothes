@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Product</h1>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="form-group mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Images -->
            <div class="form-group mb-3">
                <label for="images" class="form-label">Images</label>
                <div class="row">
                    @if ($product->images->count() > 0)
                        @foreach ($product->images as $image)
                            <div id="image-container-{{ $image->id }}" class="relative rounded border col-md-3 p-2">
                                <a href="{{ $image->path }}" data-lightbox="product-gallery" data-title="{{ $product->name }}" class="image-link">
                                    <div class="icon-container">
                                        <i class="fa fa-eye"></i>
                                    </div>
                                    <img src="{{ $image->path }}" class="center-cropped" alt="{{ $product->name }}">
                                </a>
                                <div class="trash-icon-container" onclick="deleteImage({{ $image->id }})">
                                    <i class="fa fa-trash"></i>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <img src="https://via.placeholder.com/150" class="center-cropped object-cover w-full h-full" alt="No image available">
                    @endif
                </div>
                <input type="file" id="images" name="images[]" class="form-control-file @error('images') is-invalid @enderror" multiple>
                @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
@endsection

<style>
    .relative {
        position: relative;
    }

    .icon-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        text-shadow: 0 0 3px #000000;
        font-size: 36px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2;
    }

    .relative:hover .icon-container {
        opacity: 1;
    }

    .center-cropped {
        width: 100%;
        height: 150px;
        object-fit: cover;
        overflow: hidden;
        z-index: 1;
    }

    /* Trash icon container */
    .trash-icon-container {
        position: absolute;
        top: 10px;
        right: 10px;
        color: red;
        text-shadow: 0 0 3px #000000;
        font-size: 24px;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
        z-index: 3;
    }

    .relative:hover .trash-icon-container {
        opacity: 1;
    }

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteImage(imageId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("product-image.delete", ":id") }}'.replace(':id', imageId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Image deleted successfully.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#image-container-' + imageId).fadeOut(300, function() {
                                $(this).remove();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to delete the image.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while deleting the image.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            timer: 1300,
            showConfirmButton: false
        });
        @endif
    });
</script>
