import './bootstrap';


$(document).ready(function() {
    $('#search-input').on('keyup', function() {
        let query = $(this).val().trim();

        if (query.lenght > 2) {
            $.ajax ({
                url: "/search-suggestions",
                method: "GET",
                data: { query: query },
                success: function(response) {
                    let suggestions = response.data;
                    let resultsDiv = $('#search-results');

                    resultsDiv.empty().show();

                    if (suggestions.length > 0) {
                        suggestions.forEach(suggestions => {
                            resultsDiv.append(`
                                <a href="/properties/${suggestions.id}" class="list-group-item list-group-item-action">
                                    ${suggestions.address}
                                </a>
                            `);
                        });
                    } else {
                        resultsDiv.html('<div class="list-group-item">No results found</div>');
                    }
                }
            });
        } else {
            $('#serach-results').hide();
        }
    });
    $(document).on('click', function(e) {
        if(!$(e.target).closest('#search-input, #search-results'). lenght) {
            $('#search-results').hide();
        }
    });
});