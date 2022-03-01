var JobApply =
JobApply ||
    (function ($) {
        "use strict";
        var rtl = false;
        var lang = 'en-US';

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

        function registerEventListeners() {

        }

        function init() {
            console.log('Job search Init');

            rtl = $('html').attr('dir') === 'rtl';
            lang = $('html').attr('lang');

            $('.job-apply-form-wrapper select.sumo').each(function () { initSumoSelect(this); });

            registerEventListeners()
        }

        return {
            init: init
        }
    })(jQuery);

jQuery(document).ready(function () {
  JobApply.init();
});