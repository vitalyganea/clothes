// Image Navigation Script (standalone)
// Initializes image navigation for image carousels on a page
const initializeImageNavigation = () => {
    document.querySelectorAll('.image-container').forEach(container => {
        const images = Array.from(container.querySelectorAll('img'));
        const leftButton = container.querySelector('.nav-button.left');
        const rightButton = container.querySelector('.nav-button.right');

        if (images.length === 0) {
            return; // No images to display
        }

        let currentIndex = 0;
        let startX = 0;
        let endX = 0;

        // Show the first image by default
        images[currentIndex].classList.add('active');

        // Function to show image at given index
        const showImage = (index) => {
            images.forEach((img, i) => {
                img.classList.toggle('active', i === index);
            });
            currentIndex = index;
        };

        // Event listener for left button
        if (leftButton) {
            leftButton.addEventListener('click', () => {
                const newIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(newIndex);
            });
        }

        // Event listener for right button
        if (rightButton) {
            rightButton.addEventListener('click', () => {
                const newIndex = (currentIndex + 1) % images.length;
                showImage(newIndex);
            });
        }

        // Add swipe detection for mobile
        container.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        container.addEventListener('touchmove', (e) => {
            endX = e.touches[0].clientX;
        });

        container.addEventListener('touchend', () => {
            const swipeDistance = endX - startX;

            // Swipe left to show next image
            if (swipeDistance < -50) {
                const newIndex = (currentIndex + 1) % images.length;
                showImage(newIndex);
            }

            // Swipe right to show previous image
            if (swipeDistance > 50) {
                const newIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(newIndex);
            }
        });
    });
};

// Initialize image navigation on page load
window.addEventListener('load', initializeImageNavigation);
