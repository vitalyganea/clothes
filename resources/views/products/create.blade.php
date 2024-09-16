@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Add Product to {{ $shop->name }}</h1>
        <form action="{{ route('products.store', $shop->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="form-group mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                          rows="4" required> </textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Price -->
            <div class="form-group mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" required>
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Images -->
            <div class="form-group mb-3">
                <label for="images" class="form-label">Images</label>
                <div class="row" id="image-preview-container">
                    <!-- Placeholder for image previews -->
                    <!-- Display new images previews here -->
                </div>

                <!-- File input for images -->
                <input type="file" id="images" name="images[]" class="form-control-file @error('images') is-invalid @enderror"
                       multiple>
                @error('images')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Select Category -->
            <div class="form-group mb-3">
                <label for="category_id" class="form-label">Select Category:</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    @foreach($productCategories as $productCategory)
                        <option value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Select Size -->
            <div class="form-group mb-3">
                <label for="size_id" class="form-label">Select Size:</label>
                <select class="form-select" id="size_id" name="size_id" required>
                    <!-- This will be dynamically populated via AJAX -->
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
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

                        // Initialize Lightbox for the new image
                        lightbox.init();
                    };
                    reader.readAsDataURL(file); // Convert file to base64 string
                });
            });
        }

        // Function to remove dynamically added image previews
        window.removeNewImage = function (index) {
            const imagePreview = document.getElementById('new-image-' + index);
            if (imagePreview) {
                imagePreview.remove();
            }

            // Remove the file from the input's files list
            const dataTransfer = new DataTransfer();
            Array.from(fileInput.files).forEach((file, i) => {
                if (i !== index) {
                    dataTransfer.items.add(file);
                }
            });
            fileInput.files = dataTransfer.files; // Set the updated files list
        }



        const categorySelect = document.getElementById('category_id');
        const sizeSelect = document.getElementById('size_id');

        // Function to fetch sizes based on category
        function fetchSizes(categoryId) {
            fetch(`/category/${categoryId}/sizes`)
                .then(response => response.json())
                .then(data => {
                    // Clear existing options
                    sizeSelect.innerHTML = '';

                    // Populate the size select dropdown with new options
                    data.forEach(size => {
                        const option = document.createElement('option');
                        option.value = size.id;
                        option.textContent = size.size_name;

                        // Select the size if it matches the old value (useful for edit forms)
                        @if(old('size_id'))
                        if (size.id == "{{ old('size_id') }}") {
                            option.selected = true;
                        }
                        @endif

                        sizeSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching sizes:', error);
                });
        }

        // Fetch sizes on page load for the default category
        const initialCategoryId = categorySelect.value;
        if (initialCategoryId) {
            fetchSizes(initialCategoryId);
        }

        // Listen for category selection changes
        categorySelect.addEventListener('change', function () {
            const categoryId = this.value;
            fetchSizes(categoryId);
        });
    });
</script>
