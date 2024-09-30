/******/ (() => { // webpackBootstrap
/*!***************************************!*\
  !*** ./resources/js/product/index.js ***!
  \***************************************/
var categorySelect = document.getElementById('category-select');
var sizesSelect = document.getElementById('sizes-select');
var filterForm = document.getElementById('filter-form');
var productList = document.getElementById('product-list');
var pagination = document.getElementById('pagination');
var noProductsDiv = document.getElementById('no-products'); // Div to show when no products are found
var resetButton = document.getElementById('reset-filters');
var minPriceInput = document.getElementById('min-price');
var maxPriceInput = document.getElementById('max-price');
var sortSelect = document.getElementById('sort-select');
var citySelect = document.getElementById('city-select');
var loadingMore = false;

// Extract URL parameters
var urlParams = new URLSearchParams(window.location.search);
var previouslySelectedSize = urlParams.get('size') || '';
var previouslySelectedCategory = urlParams.get('category') || '';

// Initialize image navigation for image carousels
var initializeImageNavigation = function initializeImageNavigation() {
  document.querySelectorAll('.image-container').forEach(function (container) {
    var images = Array.from(container.querySelectorAll('img'));
    var leftButton = container.querySelector('.nav-button.left');
    var rightButton = container.querySelector('.nav-button.right');
    if (images.length === 0) {
      return; // No images to display
    }
    var currentIndex = 0;
    var startX = 0;
    var endX = 0;

    // Show the first image by default
    images[currentIndex].classList.add('active');

    // Function to show image at given index
    var showImage = function showImage(index) {
      images.forEach(function (img, i) {
        img.classList.toggle('active', i === index);
      });
      currentIndex = index;
    };

    // Event listener for left button
    if (leftButton) {
      leftButton.addEventListener('click', function () {
        var newIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(newIndex);
      });
    }

    // Event listener for right button
    if (rightButton) {
      rightButton.addEventListener('click', function () {
        var newIndex = (currentIndex + 1) % images.length;
        showImage(newIndex);
      });
    }

    // Add swipe detection
    container.addEventListener('touchstart', function (e) {
      startX = e.touches[0].clientX;
    });
    container.addEventListener('touchmove', function (e) {
      endX = e.touches[0].clientX;
    });
    container.addEventListener('touchend', function () {
      var swipeDistance = endX - startX;

      // Swipe left to show next image
      if (swipeDistance < -50) {
        var newIndex = (currentIndex + 1) % images.length;
        showImage(newIndex);
      }

      // Swipe right to show previous image
      if (swipeDistance > 50) {
        var _newIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(_newIndex);
      }
    });
  });
};

// Function to update size options based on selected category
var updateSizes = function updateSizes(categoryId) {
  if (categoryId === "") {
    // If "All Categories" is selected, reset sizes to "All Sizes"
    sizesSelect.innerHTML = '<option value="">All Sizes</option>';
    sizesSelect.value = ""; // Deselect any selected size
    sizesSelect.disabled = true; // Disable sizes select
  } else {
    // Fetch sizes for the selected category
    fetch("/category/".concat(categoryId, "/sizes")).then(function (response) {
      return response.json();
    }).then(function (sizes) {
      sizesSelect.innerHTML = '<option value="">All Sizes</option>';
      sizesSelect.disabled = false; // Enable sizes select

      var sizeFound = false;
      sizes.forEach(function (size) {
        var option = document.createElement('option');
        option.value = size.id;
        option.textContent = size.size_name;
        if (size.id == previouslySelectedSize) {
          option.selected = true;
          sizeFound = true;
        }
        sizesSelect.appendChild(option);
      });
      if (!sizeFound) {
        sizesSelect.value = "";
      }
    })["catch"](function (error) {
      console.error('Error fetching sizes:', error);
    });
  }
};

// Function to update URL parameters without reloading the page
var updateURL = function updateURL(categoryId, sizeId, minPrice, maxPrice, sortBy, city) {
  var url = new URL(window.location.href);
  var params = new URLSearchParams(url.search);
  if (categoryId === "") {
    params["delete"]('category');
  } else {
    params.set('category', categoryId);
  }
  if (sizeId === "") {
    params["delete"]('size');
  } else {
    params.set('size', sizeId);
  }
  if (minPrice === "" && maxPrice === "") {
    params["delete"]('min_price');
    params["delete"]('max_price');
  } else {
    if (minPrice) params.set('min_price', minPrice);
    if (maxPrice) params.set('max_price', maxPrice);
  }
  if (sortBy === "") {
    params["delete"]('sort');
  } else {
    params.set('sort', sortBy);
  }
  if (city === "" || city === undefined) {
    params["delete"]('city');
  } else {
    params.set('city', city);
  }

  // Remove URL parameters if no filters are applied
  if (!params.toString()) {
    history.replaceState({}, '', window.location.pathname);
  } else {
    window.history.replaceState({}, '', "".concat(url.pathname, "?").concat(params.toString()));
  }
};

// Function to fetch and display products based on filters
var fetchProducts = function fetchProducts(formData) {
  var append = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
  loadingMore = true;
  fetch("/?".concat(new URLSearchParams(formData).toString())).then(function (response) {
    return response.text();
  }).then(function (html) {
    var parser = new DOMParser();
    var doc = parser.parseFromString(html, 'text/html');
    var newProducts = doc.querySelector('#product-list');
    var newPagination = doc.querySelector('#pagination'); // The invisible div for pagination

    if (newProducts && newProducts.innerHTML.trim()) {
      if (append) {
        productList.insertAdjacentHTML('beforeend', newProducts.innerHTML);
      } else {
        productList.innerHTML = newProducts.innerHTML;
      }
      initializeImageNavigation();
      pagination.innerHTML = newPagination.innerHTML;
      noProductsDiv.style.display = 'none'; // Hide "No products found" message
    } else {
      productList.innerHTML = ''; // Clear the product list
      noProductsDiv.style.display = 'block'; // Show "No products found" message
    }
    loadingMore = false;
  })["catch"](function (error) {
    console.error('Error loading products:', error);
    loadingMore = false;
  });
};

// Initialize size select based on the category and previously selected size
if (previouslySelectedCategory) {
  categorySelect.value = previouslySelectedCategory;
  updateSizes(previouslySelectedCategory);
}

// Set previously selected size
sizesSelect.value = previouslySelectedSize;

// Event listener for the "Apply" button
filterForm.addEventListener('submit', function (e) {
  e.preventDefault(); // Prevent normal form submission
  var formData = new FormData(filterForm);
  fetchProducts(formData);
  var categoryId = categorySelect.value;
  var sizeId = sizesSelect.value;
  var minPrice = minPriceInput.value;
  var maxPrice = maxPriceInput.value;
  var sortBy = sortSelect.value;
  var city = citySelect.value;
  updateURL(categoryId, sizeId, minPrice, maxPrice, sortBy, city);
});

// Event listener for filter changes
function handleFilterChange() {
  updateURL(categorySelect.value, sizesSelect.value, minPriceInput.value, maxPriceInput.value, sortSelect.value, citySelect.value);
}

// Event listener for category change to also update sizes
categorySelect.addEventListener('change', function () {
  updateSizes(this.value); // Update sizes for the selected category
  handleFilterChange(); // Update the URL with the new category
});

// Use the same handler for the other filter inputs
sizesSelect.addEventListener('change', handleFilterChange);
minPriceInput.addEventListener('input', handleFilterChange);
maxPriceInput.addEventListener('input', handleFilterChange);
sortSelect.addEventListener('change', handleFilterChange);
citySelect.addEventListener('change', handleFilterChange);

// Reset filters functionality
if (resetButton !== null) {
  resetButton.addEventListener('click', function () {
    filterForm.reset();
    updateURL('', '', '', '', '');
    fetchProducts(new FormData(filterForm)); // Fetch products with reset filters
  });
}

// Infinite Scroll
window.addEventListener('scroll', function () {
  var scrollPosition = window.scrollY + window.innerHeight;
  var triggerPosition = document.documentElement.scrollHeight - 100;
  if (scrollPosition >= triggerPosition && !loadingMore) {
    var formData = new FormData(filterForm);
    var nextPage = pagination.querySelector('a[rel="next"]');
    if (nextPage) {
      formData.set('page', nextPage.getAttribute('href').split('page=')[1]);
      fetchProducts(formData, true); // Append new products
    }
  }
});
initializeImageNavigation();
/******/ })()
;