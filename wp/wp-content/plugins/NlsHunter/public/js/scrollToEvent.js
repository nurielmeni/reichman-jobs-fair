var ScrollTo = ScrollTo || (

    function ($) {
        function Position(el, cb, calls) {
            this.el = typeof el === 'string' ? el : '';
            this.cb = typeof cb === 'function' ? cb : function () { };
            this.calls = calls || -1; // unlimited calls to the function
        }

        // 
        var positions = [];

        $(document).ready(function () {
            $(document).on('scroll', function (event) {
                var viewPos = $(document).scrollTop() + $(window).height();
                positions.forEach(function (pos) {
                    // Number of calls permited for the function
                    if (pos.calls === 0 || $(pos.el).length === 0) return;

                    var elPos = $(pos.el).position().top;

                    if (pos.calls > 0 && viewPos >= elPos) {
                        pos.calls--;
                        pos.cb();
                    }
                });
            });
        });


        function add(el, cb, calls) {
            positions.push(new Position(el, cb, calls));
        }

        function remove(el) {
            positions.find(function (pos) { if (pos.el === el) delete pos; });
        }

        function setCalls(el, num) {
            if (isNaN(Number(num))) return;
            positions.find(function (pos) { if (pos.el === el) pos.calls = Number(num); });
        }

        return {
            add: add,
            remove: remove,
            setCalls: setCalls
        }
    }
)(jQuery)