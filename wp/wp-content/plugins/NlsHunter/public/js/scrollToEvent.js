var ScrollTo = ScrollTo || (
    function ($) {
        var positions = [];

        $(document).on('scroll', function () {
            var viewPos = $(document).scrollTop() + $(window).height();
            positions.forEach(function (pos) {
                var elPos = $(pos.el).position().top;
                if (viewPos >= elPos) pos.cb();
                if (pos.options.once) delete pos;
            });
        });

        function add(el, cb, options) {
            if (typeof el !== 'string' || typeof cb !== 'function') {
                console.log('scrollToEvent: must have el (string) cb (function)');
                return;
            }
            options = options || {};
            positions.push({ el: el, cb: cb, options: options });
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