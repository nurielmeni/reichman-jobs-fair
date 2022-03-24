var Jobs =
    Jobs ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';
        var areaVal = null;

        var allJobsSection = '.jobs-wrapper section.all-jobs';
        var areaSelect = '.jobs-wrapper select[name="jobs-by-area"]';
        var buttonClear = '.jobs-wrapper button.clear';
        var totalHits = '.jobs-wrapper span.total-hits';
        var employer = 'section.employer-details-wrapper';

        function initSumoSelect(selectBoxItem) {
            var name = $(selectBoxItem).attr('name') || '';
            var placeholder = $(selectBoxItem).attr('placeholder') || '';

            $('select.sumo[name="' + name + '"]').SumoSelect({
                placeholder: placeholder,
                clearAll: true,
                search: true,
                searchText: (rtl ? 'חפש ' : 'Search ') + placeholder,
                noMatch: (rtl ? 'אין התאמות עבור "{0}"' : 'No matches for "{0}"')
            });
        }

        function clearAllSelection(selectEl) {
            $(selectEl).length && $(selectEl).get(0).sumo.unSelectAll();
        }

        function showSpinner() {
            $('.jobs-wrapper .footer .spinner svg').removeClass('hidden');
        }

        function hideSpinner() {
            $('.jobs-wrapper .footer .spinner svg').addClass('hidden');
        }

        function clearAllJobs() {
            $(allJobsSection).empty();
        }

        function loadJobs(page) {
            var page = page === null || page === undefined ? $(allJobsSection).data('page') : page;
            var area = $(areaSelect).val();

            if (page === -1) clearAllJobs();

            var data = {
                action: 'load_jobs_function',
                area: area,
                page: page,
                employer: $(employer).length ? $(employer).data('employerId') : 0
            };

            $.ajax({
                url: frontend_ajax.url,
                data: data,
                type: "POST",
                beforeSend: showSpinner,
                success: function (response) {
                    var page = Number(response.page);
                    hideSpinner();

                    $(totalHits).text(response.totalHits);

                    if (isNaN(page) || page < 0) return;

                    $(allJobsSection).append(response.html);
                    $(allJobsSection).data('page', page);

                    // Call this function so the wp will inform the change to the post
                    $(document.body).trigger("post-load");

                    ScrollTo && ScrollTo.setCalls('#all-jobs-loader .spinner', 1);
                }
            });
        }

        function registerEventListeners() {
            $(buttonClear).on('click', function () {
                clearAllSelection(areaSelect);
            });

            $(areaSelect).on('change', function () {
                var newAreaVal = $(this).val();
                if (areaVal === newAreaVal) return;

                areaVal = newAreaVal;

                if (newAreaVal !== null) {
                    $(buttonClear).removeClass('hidden');
                } else {
                    $(buttonClear).addClass('hidden');
                }

                loadJobs(-1);
            });
        }

        function init() {
            console.log('Jobs Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            $('.jobs-wrapper select.sumo').each(function () { initSumoSelect(this); });
            clearAllSelection(areaSelect);

            registerEventListeners()
        }

        $(document).ready(function () {
            ScrollTo && ScrollTo.add('#all-jobs-loader .spinner', loadJobs, 1);
        });

        return {
            init: init
        }
    })(jQuery);

jQuery(document).ready(function () {
    Jobs.init();
});