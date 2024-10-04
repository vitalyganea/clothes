// resetFilters.js
const filterForm = document.getElementById('filter-form');

const resetButton = document.getElementById('reset-filters');

if (resetButton !== null) {
    resetButton.addEventListener('click', function () {
        filterForm.reset();
        updateURL('', '', '', '', '');
        fetchProducts(new FormData(filterForm)); // Fetch products with reset filters
    });
}
