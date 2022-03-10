var ScrollTo = ScrollTo || (
    function ($) {
        var positions = [];

        $(document).on('scroll', function () {
            var viewPos = $(document).scrollTop() + $(window).height();
            positions.forEach(function (pos) {
                var elPos = $('span.spinner').position().top;
                if (viewPos >= elPos) pos.cb();
            });
        });

        function add(el, cb) {
            positions.push({ el: el, cb: cb });
        }

        function remove(el) {
            positions.find(function (pos) { if (pos.el === el) delete pos; });
        }

        return {
            add: add,
            remove: remove
        }
    }
)(jQuery)