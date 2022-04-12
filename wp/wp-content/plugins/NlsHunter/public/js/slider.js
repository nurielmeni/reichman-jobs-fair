var Slider =
  Slider ||
  (function ($) {
    "use strict";

    var wrapper, nav, slider, item;

    /**
     * 
     * @param {*} config Object with specific definintions for the elemnts classes
     */
    function init(config) {
      wrapper = config && "wrapper" in config ? config.wrapper : ".hs-wrapper";
      nav =
        config && "nav" in config
          ? wrapper + " " + config.nav
          : wrapper + " button.nav";
      slider =
        config && "slider" in config
          ? wrapper + " " + config.slider
          : wrapper + " .hs-container";
      item =
        config && "item" in config
          ? slider + " " + config.item
          : slider + " > *";

      // Check if images needs slide
      if (getScrollWidth(wrapper) >= getScrollWidth(slider)) {
        $(nav).hide();
        return;
      };


      if (mobileCheck()) {
        swipedetect(document.querySelector(slider), function (swipedir) {
          if (swipedir === 'none') return;
          var direction = swipedir === 'left'
            ? 1
            : swipedir === 'right'
              ? -1
              : null;

          scrollSlider(direction, 200, null);
        });

        var width = $(item).outerWidth(true);
        $(slider).scrollLeft(width * Math.floor($(item).length / 2));
      } else {
        $(slider).scrollLeft((getScrollWidth(slider) - $(slider).get(0).clientWidth) / 2);
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

        var sLeft = scrollSlider(direction, 600, function () {
          $(btnEl).prop('disabled', false);
        });

        // Slider width + screen width
        if (sLeft + $(slider).get(0).clientWidth >= getScrollWidth(slider)) $(nav + '.left').hide()
        else $(nav + '.left').show();

        if (sLeft <= 0) $(nav + '.right').hide()
        else $(nav + '.right').show();
      });
    }

    function getScrollWidth(el) {
      var sliderEl = document.querySelector(el);
      return sliderEl ? sliderEl.scrollWidth : 0;
    }

    function scrollSlider(direction, delay, cbAfterAnimation) {
      if (!direction) return;
      var sliderEl = document.querySelector(slider);

      var width = $(item).outerWidth(true);
      var sLeft = sliderEl.scrollLeft + direction * width;

      $(slider).animate({ scrollLeft: sLeft }, {
        duration: delay, complete: cbAfterAnimation
      });

      return sliderEl.scrollLeft;
    }

    return {
      init: init,
    };
  })(jQuery);

jQuery(document).ready(function () {
  Slider.init();
  window.onresize = Slider.init;
});
