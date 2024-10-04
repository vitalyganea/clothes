const categorySelect = document.getElementById('category-select');
const sizesSelect = document.getElementById('sizes-select');
const minPriceInput = document.getElementById('min-price');
const maxPriceInput = document.getElementById('max-price');
const sortSelect = document.getElementById('sort-select');
const citySelect = document.getElementById('city-select');

const updateURL = (categoryId, sizeId, minPrice, maxPrice, sortBy, city) => {
    let url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);

    if (categoryId === "") {
        params.delete('category');
    } else {
        params.set('category', categoryId);
    }

    if (sizeId === "") {
        params.delete('size');
    } else {
        params.set('size', sizeId);
    }

    if (minPrice === "" && maxPrice === "") {
        params.delete('min_price');
        params.delete('max_price');
    } else {
        if (minPrice) params.set('min_price', minPrice);
        if (maxPrice) params.set('max_price', maxPrice);
    }

    if (sortBy === "") {
        params.delete('sort');
    } else {
        params.set('sort', sortBy);
    }

    if (city === "" || city === undefined) {
        params.delete('city');
    } else {
        params.set('city', city);
    }

    // Remove URL parameters if no filters are applied
    if (!params.toString()) {
        history.replaceState({}, '', window.location.pathname);
    } else {
        window.history.replaceState({}, '', `${url.pathname}?${params.toString()}`);
    }
};

// Event listeners for filter changes
const handleFilterChange = () => {
    updateURL(
        categorySelect.value,
        sizesSelect.value,
        minPriceInput.value,
        maxPriceInput.value,
        sortSelect.value,
        citySelect.value
    );
};

categorySelect.addEventListener('change', handleFilterChange);
sizesSelect.addEventListener('change', handleFilterChange);
minPriceInput.addEventListener('input', handleFilterChange);
maxPriceInput.addEventListener('input', handleFilterChange);
sortSelect.addEventListener('change', handleFilterChange);
citySelect.addEventListener('change', handleFilterChange);

window.updateURL = updateURL;
const filterForm = document.getElementById('filter-form');

filterForm.addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent normal form submission
    const formData = new FormData(filterForm);
    fetchProducts(formData);
    const categoryId = categorySelect.value;
    const sizeId = sizesSelect.value;
    const minPrice = minPriceInput.value;
    const maxPrice = maxPriceInput.value;
    const sortBy = sortSelect.value;
    const city = citySelect.value;
    updateURL(categoryId, sizeId, minPrice, maxPrice, sortBy, city);
});