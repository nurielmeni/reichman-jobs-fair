var App = App || (
    function ($) {
        var employersGrid = 'section.employers-grid';

        function showEmployerSpinner() {
            $('.footer .spinner svg').removeClass('hidden');
        }

        function hideEmployerSpinner() {
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
                beforeSend: showEmployerSpinner,
                success: function (response) {
                    var page = Number(response.page);
                    hideEmployerSpinner();
                    if (isNaN(page) || page < 0) return;

                    $(employersGrid).append(response.html);
                    $(employersGrid).data('page', page);

                    // Call this function so the wp will inform the change to the post
                    $(document.body).trigger("post-load");

                    ScrollTo && ScrollTo.setCalls('.footer .spinner', 1);
                }
            });
        }

        $(document).ready(function () {
            ScrollTo && ScrollTo.add('.footer .spinner', loadEmployers, 1)
        });

        return {
            loadEmployers: loadEmployers
        }
    }
)(jQuery)