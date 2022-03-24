var App = App || (
    function ($) {
        var employersGrid = 'section.employers-grid';
        var searchBoxButton = '.search-box button.search-btn';
        var searchBoxInput = 'input#employer-search';
        var loading = false;

        function showSpinner() {
            $('.footer .spinner svg').removeClass('hidden');
        }

        function hideSpinner() {
            $('.footer .spinner svg').addClass('hidden');
        }

        function clearResults() {
            $(employersGrid).html('');
        }

        function loadEmployers(page) {
            if (loading) return;
            var searchPhrase = $(searchBoxButton).data('search-phrase') ? $(searchBoxButton).data('search-phrase').trim() : '';

            var page = page || $(employersGrid).data('page');
            var data = {
                action: 'load_employers_function',
                page: page,
                searchPhrase: searchPhrase
            };
            $.ajax({
                url: frontend_ajax.url,
                data: data,
                type: "POST",
                beforeSend: function () {
                    showSpinner();
                    loading = true;
                    $(searchBoxButton).prop('disabled', true)
                },
                success: function (response) {
                    var page = Number(response.page);
                    hideSpinner();
                    if (isNaN(page) || page < 0) return;

                    $(employersGrid).append(response.html);
                    $(employersGrid).data('page', page);

                    // Call this function so the wp will inform the change to the post
                    $(document.body).trigger("post-load");

                    ScrollTo && ScrollTo.setCalls('#employers-loader .spinner', 1);
                },
                complete: function () {
                    loading = false;
                    $(searchBoxButton).prop('disabled', false)
                }
            });
        }

        $(document).ready(function () {
            ScrollTo && ScrollTo.add('#employers-loader .spinner', loadEmployers, 1);

            $(searchBoxButton).on('click', function () {
                $(this).data('search-phrase', $(searchBoxInput).val());
                clearResults();
                loadEmployers(-1);
            });

            // Reset the search phrase
            $(this).data('search-phrase', false);
        });

        return {
            loadEmployers: loadEmployers
        }
    }
)(jQuery)