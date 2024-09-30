document.getElementById('searchQuery').addEventListener('input', function() {
    const query = this.value;
    if (query.length > 2) {
        fetch('/search?query=' + query)
            .then(response => response.json())
            .then(data => {
                let resultList = '';

                document.getElementById('searchQuery').classList.remove('border-radius-bottom');

                if (data.html.length > 0) {
                    resultList += '<ul class="list-group custom-list-group">' + data.html + '</ul>';
                } else {
                    resultList = '<ul class="list-group custom-list-group"><li class="list-group-item custom-list-group-item">Nothing found</li></ul>';
                }

                document.getElementById('searchResults').classList.remove('d-none');
                document.getElementById('searchResults').innerHTML = resultList;
            });
    } else {
        document.getElementById('searchResults').innerHTML = '';
        document.getElementById('searchResults').classList.add('d-none');
        document.getElementById('searchQuery').classList.add('border-radius-bottom');
    }
});


// Add event listener for clicks outside of the search input and results
document.addEventListener('click', function(event) {
    const searchInput = document.getElementById('searchQuery');
    const searchResults = document.getElementById('searchResults');

    // Check if the click is outside the search input and results
    if (!searchInput.contains(event.target) && !searchResults.contains(event.target)) {
        searchResults.innerHTML = '';
        searchResults.classList.add('d-none');
        document.getElementById('searchQuery').classList.add('border-radius-bottom');

    }
});

