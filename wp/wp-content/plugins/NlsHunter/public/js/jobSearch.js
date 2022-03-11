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

        function registerEventListeners() {
            // Clear fileds
            $('.nls-hunter-search-wrapper .search-buttons button.eraser').on('click', clearFields);

            // Search Button
            $('.nls-hunter-search-wrapper button.search').on('click', search);

            // Show job details and submit form
            $(document).on('click', jocCardsDetailsBtn, showJobDetails);

            // Hide job details
            $(document).on('click', jocCardsCancelBtn, hideJobDetails);
        }

        function init() {
            console.log('Job search Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            $('.nls-hunter-search-wrapper select.sumo').each(function () { initSumoSelect(this); });

            registerEventListeners()
        }

        return {
            init: init
        }
    })(jQuery);

jQuery(document).ready(function () {
    JobSearch.init();
});