// sizeUpdate.js
const urlParams = new URLSearchParams(window.location.search);
const previouslySelectedSize = urlParams.get('size') || '';
const previouslySelectedCategory = urlParams.get('category') || '';
const sizesSelect = document.getElementById('sizes-select');
const categorySelect = document.getElementById('category-select');

const updateSizes = (categoryId) => {
    if (categoryId === "") {
        // If "All Categories" is selected, reset sizes to "All Sizes"
        sizesSelect.innerHTML = '<option value="">All Sizes</option>';
        sizesSelect.value = ""; // Deselect any selected size
        sizesSelect.disabled = true; // Disable sizes select
    } else {
        // Fetch sizes for the selected category
        fetch(`/category/${categoryId}/sizes`)
            .then(response => response.json())
            .then(sizes => {
                sizesSelect.innerHTML = '<option value="">All Sizes</option>';
                sizesSelect.disabled = false; // Enable sizes select

                sizes.forEach(size => {
                    const option = document.createElement('option');
                    option.value = size.id;
                    option.textContent = size.size_name;
                    sizesSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching sizes:', error);
            });
    }
};

// Initialize size select based on the category and previously selected size
if (previouslySelectedCategory) {
    categorySelect.value = previouslySelectedCategory;
    updateSizes(previouslySelectedCategory);
}

// Set previously selected size
sizesSelect.value = previouslySelectedSize;

// Event listener for category change to also update sizes
categorySelect.addEventListener('change', (e) => {
    updateSizes(e.target.value);
});
