var JobSearch =
    JobSearch ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';

        var jobCards = '.search-results-wrapper .job-card',
            jocCardsDetailsBtn = '.job-card button.additional-details',
            jocCardsCancelBtn = '.job-card button.cancel',
            jobApplyForm = '.search-results-wrapper .job-apply-form-wrapper',
            detailsClasses = 'details md:col-span-2 lg:col-span-3 md:p-8 animate-expand',
            applyBtn = '.job-card button.apply',
            moreResultsBtn = '.search-results-wrapper .footer button.more-results',
            applyEmployer = '.job-card button.apply-employer';

        function initSumoSelect(selectBoxItem) {
            var name = $(selectBoxItem).attr('name') || '';
            var placeholder = $(selectBoxItem).attr('placeholder') || '';

            $('select.sumo[name="' + name + '"]').SumoSelect({
                placeholder: placeholder,
                search: true,
                csvDispCount: 2,
                okCancelInMulti: true,
                isClickAwayOk: true,
                searchText: (rtl ? 'חפש ' : 'Search ') + placeholder,
                locale: rtl ? ['בחר', 'בטל', 'בחר הכל', 'בטל הכל'] : ['OK', 'Cancel', 'Select All', 'Clear ALL'],
                captionFormat: rtl ? '{0} נבחרו' : '{0} Selected',
                captionFormatAllSelected: rtl ? '{0} כולם נבחרו!' : '{0} all selected!',
            });
        }

        function toggleAdvanced() {
            var el = '.nls-hunter-search-wrapper .search-advanced';
            if ($(el).hasClass('hidden')) {
                $(el).removeClass('hidden');
                $(el).slideDown(500);
            } else {
                $(el).slideUp(500, function () {
                    $(this).addClass('hidden');
                });
            }

        }

        function clearFields() {
            $('.nls-hunter-search-wrapper input').val('');
            $('.nls-hunter-search-wrapper select.sumo').each(function () {
                $(this)[0].sumo.unSelectAll();
            });
        }

        function search(e) {
            console.log(e);
            var form = $(e.target).parents('form')[0];
            var formData = new FormData(form);
            form.submit();
        }

        function showJobDetails(event) {
            var el = event.target;
            var jobCard = $(el).parents('.job-card');
            if ($(jobCard).hasClass('details')) return jobCard;

            $(jobCard).removeClass('animate-expand');
            $(jobCard).find('.additional').removeClass('hidden');
            $(jobCard).find('.no-additional').addClass('hidden');
            $(jobCard).get(0).scrollIntoView({ behavior: "smooth" });
            $(jobCard).addClass(detailsClasses);
            return jobCard;
        }

        function showApplyForm(event) {
            var jobCard = showJobDetails(event);
            $(event.target).addClass('hidden');

            $(jobApplyForm).appendTo($(jobCard));
            $(jobApplyForm).removeClass('hidden');
            $(jobApplyForm).addClass('animate-slide-down');
        }

        function hideJobDetails(event) {
            var el = event.target;
            var jobCard = $(el).parents('.job-card');

            $(jobApplyForm).addClass('hidden');
            $(jobCard).find('.additional').addClass('hidden');
            $(jobCard).find('.no-additional').removeClass('hidden');
            $(jobCard).find('button.apply').removeClass('hidden');
            $(jobCard).removeClass(detailsClasses);
            $(jobCard).get(0).scrollIntoView({ behavior: "smooth", block: "center" });
            $(jobCard).addClass('animate-expand');
        }

        function moreResults(event) {
            var button = event.target;
            var currentPage = $(button).data('page') || 0;

            $(button).find('svg').removeClass('hidden');

            $.ajax({
                url: frontend_ajax.url,
                data: { page: currentPage },
                success: renderMoreResults,
                dataType: 'html'
            });

            // Call this function so the wp will inform the change to the post
            $(document.body).trigger("post-load");

        }

        function renderMoreResults(htmMoreResults) {
            console.log('more', htmMoreResults);
        }

        function registerEventListeners() {
            // Toggle advanced search options
            $('.nls-hunter-search-wrapper .search-buttons button.advanced').on('click', toggleAdvanced);

            // Clear fileds
            $('.nls-hunter-search-wrapper .search-buttons button.eraser').on('click', clearFields);

            // Clear fileds
            $('.nls-hunter-search-wrapper button.search').on('click', search);

            // Show job details and submit form
            $(document).on('click', jocCardsDetailsBtn, showJobDetails);

            // Hide job details
            $(document).on('click', jocCardsCancelBtn, hideJobDetails);

            // Show apply form
            $(document).on('click', moreResultsBtn, moreResults);

            // Load more serach results
            $(document).on('click',)
        }

        function init() {
            console.log('Job search Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            $('.nls-hunter-search-wrapper select.sumo').each(function () { initSumoSelect(this); });

            $('.nls-hunter-search-wrapper input[name="last-update"]').datepicker({
                dateFormat: 'M d, yy'
            });
            // if (lang === 'he-IL') {
            //     $('.nls-hunter-search-wrapper input[name="last-update"]').datepicker(
            //         $.datepicker.regional["he"]
            //     );
            // } else {
            // }

            registerEventListeners()
        }

        return {
            init: init
        }
    })(jQuery);

jQuery(document).ready(function () {
    JobSearch.init();
});