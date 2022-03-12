var App = App || (
    function ($) {
        loadEmployers()
        $(document).ready(function () {
            ScrollTo && ScrollTo.add('.footer .spinner', () => { alert('more'); })
        });

        return {

        }
    }
)(jQuery)