// infinite scroll and product fetching
const filterForm = document.getElementById('filter-form');
const productList = document.getElementById('product-list');
const pagination = document.getElementById('pagination');
const noProductsDiv = document.getElementById('no-products'); // Div to show when no products are found
let loadingMore = false;

window.addEventListener('scroll', handleScroll);

// Function to handle scroll event
function handleScroll() {
    const scrollPosition = window.scrollY + window.innerHeight;
    const triggerPosition = document.documentElement.scrollHeight - 100;

    if (scrollPosition >= triggerPosition && !loadingMore) {
        loadMoreProducts();
    }
}

// Function to load more products
function loadMoreProducts() {
    const formData = new FormData(filterForm);
    const nextPage = pagination.querySelector('a[rel="next"]');

    if (nextPage) {
        const nextPageNumber = nextPage.getAttribute('href').split('page=')[1];
        formData.set('page', nextPageNumber);
        fetchProducts(formData, true); // Append new products
    }
}

// Function to fetch products from the server
const fetchProducts = (formData, append = false) => {
    loadingMore = true;

    fetch(`/?${new URLSearchParams(formData).toString()}`)
        .then(response => response.text())
        .then(html => handleFetchResponse(html, append))
        .catch(handleFetchError);
};

// Function to handle the response after fetching products
function handleFetchResponse(html, append) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const newProducts = doc.querySelector('#product-list');
    const newPagination = doc.querySelector('#pagination'); // The invisible div for pagination

    if (newProducts && newProducts.innerHTML.trim()) {
        updateProductList(newProducts.innerHTML, append);
        pagination.innerHTML = newPagination.innerHTML;
        noProductsDiv.style.display = 'none'; // Hide "No products found" message
    } else {
        displayNoProductsMessage();
    }

    loadingMore = false;
}

// Function to update the product list
function updateProductList(newProductsHTML, append) {
    if (append) {
        productList.insertAdjacentHTML('beforeend', newProductsHTML);
    } else {
        productList.innerHTML = newProductsHTML;
    }
    initializeImageNavigation();
}

// Function to display the "No products found" message
function displayNoProductsMessage() {
    productList.innerHTML = ''; // Clear the product list
    noProductsDiv.style.display = 'block'; // Show "No products found" message
}

// Function to handle fetch errors
function handleFetchError(error) {
    console.error('Error loading products:', error);
    loadingMore = false;
}

window.fetchProducts = fetchProducts;