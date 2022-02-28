var Hotjobs =
  Hotjobs ||
  (function ($) {
    "use strict";

    var wrapper, nav, slider, item;

    function init(config) {
      wrapper = config && "wrapper" in config ? config.wrapper : ".hs-wrapper";
      nav =
        config && "nav" in config !== "undefined"
          ? wrapper + " " + config.nav
          : wrapper + " button.nav";
      slider =
        config && "slider" in config !== "undefined"
          ? wrapper + " " + config.slider
          : wrapper + " .hs-container";
      item =
        config && "item" in config !== "undefined"
          ? slider + " " + config.item
          : slider + " .hot-job-card";

      $(slider).scrollLeft((sliderWidth() - window.screen.width) / 2);

      if (mobileCheck()) {
        swipedetect(document.querySelector(slider), function (swipedir) {
          if (swipedir === 'none') return;
          var direction = swipedir === 'left'
            ? 1
            : swipedir === 'right'
              ? -1
              : null;

          scrollSlider(direction, null);
        });
      }

      // Nav Buttons Clicked
      $(nav).on("click", function (e) {
        var btnEl = this;
        $(btnEl).prop('disabled', true);
        var direction = $(btnEl).hasClass("left")
          ? 1
          : $(btnEl).hasClass("right")
            ? -1
            : null;

        var sLeft = scrollSlider(direction, function () {
          $(btnEl).prop('disabled', false);
        });

        // Slider width + screen width
        if (sLeft + window.screen.width >= sliderWidth()) $(nav + '.left').hide()
        else $(nav + '.left').show();

        if (sLeft <= 0) $(nav + '.right').hide()
        else $(nav + '.right').show();
      });
    }

    function sliderWidth() {
      var sliderEl = document.querySelector(slider);
      return sliderEl ? sliderEl.scrollWidth : 0;
    }

    function scrollSlider(direction, cbAfterAnimation) {
      if (!direction) return;
      var sliderEl = document.querySelector(slider);

      var width = $(item).outerWidth(true);
      var sLeft = sliderEl.scrollLeft + direction * width;

      $(slider).animate({ scrollLeft: sLeft }, {
        duration: 600, complete: cbAfterAnimation
      });

      return sliderEl.scrollLeft;
    }

    return {
      init: init,
    };
  })(jQuery);

jQuery(document).ready(function () {
  Hotjobs.init();
});
