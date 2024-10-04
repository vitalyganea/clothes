function toggleWishlist(productId, isInWishlist) {
    // Determine the action based on the current wishlist state
    const actionUrl = isInWishlist ? `/wishlist/remove/${productId}` : `/wishlist/add/${productId}`;
    const method = isInWishlist ? 'DELETE' : 'POST';

    fetch(actionUrl, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': window.Laravel.csrfToken // Use the CSRF token here
        },
        body: JSON.stringify({ product_id: productId })
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Network response was not ok');
        })
        .then(data => {
            // Update the button's text and classes dynamically
            const buttonText = isInWishlist ? 'ADD WISHLIST' : 'IN WISHLIST';
            const buttonClass = isInWishlist ? 'wish-button' : 'bag-button';

            document.getElementById(`wishlist-button-inner-${productId}`).textContent = buttonText;
            document.getElementById(`wishlist-button-inner-${productId}`).className = `card-button-inner ${buttonClass}`;

            // Toggle the wishlist state for the next click
            document.getElementById(`wishlist-button-${productId}`).setAttribute('onclick', `toggleWishlist(${productId}, ${!isInWishlist})`);

            // Show success message
            Swal.fire({
                title: isInWishlist ? 'Product removed from wishlist!' : 'Product added to wishlist!',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
                toast: true,
                position: 'top-end',
                showClass: {
                    popup: 'animate__animated animate__fadeInRight' // Add entrance animation
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutRight' // Add exit animation
                }
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

window.toggleWishlist = toggleWishlist;
