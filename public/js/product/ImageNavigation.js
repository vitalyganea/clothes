/******/ (() => { // webpackBootstrap
/*!*************************************************!*\
  !*** ./resources/js/product/ImageNavigation.js ***!
  \*************************************************/
// Image Navigation Script (standalone)
// Initializes image navigation for image carousels on a page
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

    // Add swipe detection for mobile
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

// Initialize image navigation on page load
window.addEventListener('load', initializeImageNavigation);
/******/ })()
;