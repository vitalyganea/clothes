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
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $product->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                          rows="4" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="form-group mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $product->price) }}" required>
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Images -->
            <div class="form-group mb-3">
                <label for="images" class="form-label">Images</label>
                <div class="row" id="image-preview-container">
                    <!-- Display existing images -->
                    @if ($product->images->count() > 0)
                        @foreach ($product->images as $image)
                            <div id="image-container-{{ $image->id }}" class="relative rounded border col-md-3 p-2">
                                <a href="{{ $image->path }}" data-lightbox="product-gallery"
                                   data-title="{{ $product->name }}" class="image-link">
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
                        <img src="https://via.placeholder.com/150" class="center-cropped object-cover w-full h-full"
                             alt="No image available">
                    @endif
                </div>

                <!-- File input for new images -->
                <input type="file" id="images" name="images[]"
                       class="form-control-file @error('images') is-invalid @enderror" multiple>
                @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Category -->
            <div class="form-group mb-3">
                <label for="category_id" class="form-label">Select Category:</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    @foreach($productCategories as $productCategory)
                        <option value="{{$productCategory->id}}" {{ $productCategory->id == $product->category_id ? 'selected' : '' }}>
                            {{$productCategory->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Size -->
            <div class="form-group mb-3">
                <label for="size_id" class="form-label">Select Size:</label>
                <select class="form-select" id="size_id" name="size_id" required>
                    @foreach($productSizes as $productSize)
                        <option value="{{$productSize->id}}" {{ $productSize->id == $product->size_id ? 'selected' : '' }}>
                            {{$productSize->size_name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
@endsection

<!-- Styles -->
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

    .ck-editor__editable_inline {
        min-height: 300px;
    }
</style>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox-plus-jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize CKEditor for the description field
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: {
                    items: [
                        'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'
                    ]
                },
                removePlugins: ['Image', 'ImageUpload', 'MediaEmbed', 'Table', 'EasyImage', 'CKFinder']
            })
            .catch(error => {
                console.error(error);
            });

        // Check for success message in session
        @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Ok'
        });
        @endif

        // Event listener for file input change
        const fileInput = document.getElementById('images');

        if (fileInput) {
            fileInput.addEventListener('change', function (event) {
                const previewContainer = document.getElementById('image-preview-container');

                // Only remove dynamically added images, keep existing ones
                const dynamicPreviews = document.querySelectorAll('.new-image');
                dynamicPreviews.forEach(image => image.remove());

                Array.from(event.target.files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const imgPreview = document.createElement('div');
                        imgPreview.className = 'relative rounded border col-md-3 p-2 new-image';
                        imgPreview.id = 'new-image-' + index;

                        imgPreview.innerHTML = `
                        <a href="${e.target.result}" data-lightbox="product-gallery" data-title="New Image">
                            <div class="icon-container">
                                <i class="fa fa-eye"></i>
                            </div>
                            <img src="${e.target.result}" class="center-cropped" alt="New Image">
                            <div class="trash-icon-container" onclick="removeNewImage(${index})">
                                <i class="fa fa-trash"></i>
                            </div>
                        </a>
                        `;

                        previewContainer.appendChild(imgPreview);
                    };
                    reader.readAsDataURL(file);
                });
            });
        }
    });

    // Function to handle image deletion
    window.deleteImage = function (imageId) {
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
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Image deleted successfully.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#image-container-' + imageId).fadeOut(300, function () {
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
                    error: function (xhr) {
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

    // Function to remove newly added image preview
    function removeNewImage(index) {
        const imagePreview = document.getElementById('new-image-' + index);
        if (imagePreview) {
            imagePreview.remove();
        }
    }
</script>
