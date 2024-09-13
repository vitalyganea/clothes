document.addEventListener('DOMContentLoaded', function() {
    let loading = false;
    let page = 1;
    let hasMoreProducts = true; // Flag to check if there are more products to load

    const loadMoreProducts = () => {
        if (loading || !hasMoreProducts) return;

        loading = true;
        page++;

        fetch(`/?page=${page}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newProducts = doc.querySelector('#product-list');
                const newPagination = doc.querySelector('#pagination'); // The invisible div for pagination

                // Check if newProducts is empty or if pagination links are not present
                if (!newProducts || !newProducts.innerHTML.trim()) {
                    hasMoreProducts = false; // No more products to load
                    window.removeEventListener('scroll', onScroll);
                    return;
                }

                document.querySelector('#product-list').insertAdjacentHTML('beforeend', newProducts.innerHTML);

                // Update pagination content
                if (newPagination && newPagination.innerHTML.trim()) {
                    document.querySelector('#pagination').innerHTML = newPagination.innerHTML;
                } else {
                    hasMoreProducts = false; // No more pagination links, stop loading
                    window.removeEventListener('scroll', onScroll);
                }

                loading = false;
            })
            .catch(error => {
                console.error('Error loading more products:', error);
                loading = false;
            });
    };

    const onScroll = () => {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
            loadMoreProducts();
        }
    };

    window.addEventListener('scroll', onScroll);
});