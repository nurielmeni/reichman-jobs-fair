var App = App || (
    function ($) {
        var employersGrid = 'section.employers-grid';

        function showSpinner() {
            $('.footer .spinner svg').removeClass('hidden');
        }

        function hideSpinner() {
            $('.footer .spinner svg').addClass('hidden');
        }

        function loadEmployers() {
            var page = $(employersGrid).data('page');
            var data = {
                action: 'load_employers_function',
                page: page
            };
            $.ajax({
                url: frontend_ajax.url,
                data: data,
                type: "POST",
                beforeSend: showSpinner,
                success: function (response) {
                    var page = Number(response.page);
                    hideSpinner();
                    if (isNaN(page) || page < 0) return;

                    $(employersGrid).append(response.html);
                    $(employersGrid).data('page', page);

                    // Call this function so the wp will inform the change to the post
                    $(document.body).trigger("post-load");

                    ScrollTo && ScrollTo.setCalls('#employers-loader .spinner', 1);
                }
            });
        }

        $(document).ready(function () {
            ScrollTo && ScrollTo.add('#employers-loader .spinner', loadEmployers, 1);
        });

        return {
            loadEmployers: loadEmployers
        }
    }
)(jQuery)