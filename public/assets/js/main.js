(function () {
    const input = document.getElementById('site-search');
    const box = document.getElementById('search-suggestions');

    if (!input || !box) {
        return;
    }

    let timer = null;

    function closeSuggestions() {
        box.innerHTML = '';
        box.classList.remove('is-open');
    }

    function renderSuggestions(items) {
        if (!items.length) {
            closeSuggestions();
            return;
        }

        box.innerHTML = items
            .map((item) => {
                return '<a class="search-item" href="' + item.url + '">' +
                    '<strong>' + item.titre + '</strong>' +
                    '<span>' + item.description + '</span>' +
                    '</a>';
            })
            .join('');

        box.classList.add('is-open');
    }

    input.addEventListener('input', function () {
        const q = input.value.trim();

        if (q.length < 2) {
            closeSuggestions();
            return;
        }

        clearTimeout(timer);
        timer = setTimeout(function () {
            fetch('/search-ajax?q=' + encodeURIComponent(q), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (data) {
                    renderSuggestions(data.articles || []);
                })
                .catch(function () {
                    closeSuggestions();
                });
        }, 220);
    });

    document.addEventListener('click', function (event) {
        if (!box.contains(event.target) && event.target !== input) {
            closeSuggestions();
        }
    });
})();
