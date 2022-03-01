(function ($) {
  "use strict";

  var localStorabeKey = "iaiSearchSlectBy";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
  function getOption(name) {
    return typeof setSelectedSumoOptions !== "undefined" &&
      setSelectedSumoOptions instanceof Object &&
      setSelectedSumoOptions.hasOwnProperty(name)
      ? setSelectedSumoOptions[name]
      : [];
  }

  function setSearchOptions() {
    var jobTypes = getOption("jobTypes");
    var areas = getOption("areas");
    var professionalFields = getOption("professionalFields");
    var keywords = getOption("keywords");

    setSelectOptions($(".SumoSelect .jobTypes")[0], jobTypes);
    setSelectOptions(
      $(".SumoSelect .professionalFields")[0],
      professionalFields
    );
    setSelectOptions($(".SumoSelect .areas")[0], areas);
    $("input.nls-search.keywords").val(keywords);
  }

  function setSelectOptions(select, items) {
    if (!select) return;
    items.forEach(function (element) {
      select.sumo.selectItem(element);
    });
  }

  function clipboardMsg(shareLink, success) {
    var msg = success
      ? $('<div class="flash-message">הקישור הועתק ללוח</div>')
      : $('<div class="flash-message error">בעיה בהעתקת הקישור</div>');
    $(shareLink).append(msg);
    setTimeout(function () {
      $(msg).fadeOut(2000, function () {
        msg.remove();
      });
    }, 3000);
  }

  function claerSearchFields() {
    // Clears the select inputs
    $(".nls-search-module form.nls-search select").each(function () {
      var sumoEl = $(this)[0].sumo;
      if (!sumoEl) return;
      if (sumoEl.isMobile()) {
        $("option").prop("selected", false);
        sumoEl.reload();
        //var l = sumoEl.E.find("option:not(:disabled,:hidden)").length;
        //for(i = 0; i < l; i++){ sumoEl.unSelectItem(i); }
      } else {
        sumoEl.unSelectAll();
      }
    });

    // Clears the text inputs
    $('.nls-search-module form.nls-search .nls-field input[type="text"]').val(
      ""
    );
  }

  function searchBy(type) {
    claerSearchFields();
    $("button.search.options").removeClass("active");
    $('button.search[data-type="' + type + '"]').addClass("active");

    if (type === "by-text") {
      $(".search-options .options.select").addClass("hide");
      $(".search-options .options.text").removeClass("hide");
    } else if (type === "by-options") {
      $(".search-options .options.select").removeClass("hide");
      $(".search-options .options.text").addClass("hide");
    }
  }

  $(document).ready(function () {
    var searchByValue = localStorage.getItem(localStorabeKey);
    if (searchByValue) {
      searchBy(searchByValue);
    }

    $('button.prevent').on('click', function(e) {
      e.preventDefault();
    });

    $("form.nls-search .nls-btn.search.options").on("click", function (e) {
      e.preventDefault();
      if ($(this).hasClass("active")) return false;
      var searchByElement = $(this).data("type");

      localStorage.setItem(localStorabeKey, searchByElement);
      searchBy(searchByElement);
      return false;
    });

    // Handle the share copy link to clipboard
    $(".share-item.copy").on("click", function () {
      var shareLink = this;
      var text = $(this).data("share-url");

      if (typeof window.clipboardData !== "undefined") {
        // ie settings
        if (window.clipboardData.setData("Text", text)) {
          clipboardMsg(shareLink, true);
        } else {
          clipboardMsg(shareLink, false);
        }
      } else {
        navigator.clipboard
          .writeText(text)
          .then(function () {
            // Clipboard failed to copy
            console.log("Clipboard success to copy");
            clipboardMsg(shareLink, true);
          })
          .catch(function () {
            // Clipboard failed to copy
            console.log("Clipboard failed to copy");
            clipboardMsg(shareLink, false);
          });
      }
    });

    // Handle the share btn
    $(document).on("click", "button.nls-outlined-btn.share", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).hide().parent().find(".share-widget").show();
    });

    var sumoSelect = $(
      ".nls-search-module form.nls-search .nls-field select, .nls-apply-for-jobs .nls-apply-field select"
    ).SumoSelect({
      csvDispCount: 2,
      captionFormat: "{0} נבחרו",
      captionFormatAllSelected: "כל ה-{0} נבחרו!",
      floatWidth: 768,
      forceCustomRendering: false,
      outputAsCSV: false,
      nativeOnDevice: [
        "android",
        "webos",
        "iphone",
        "ipad",
        "ipod",
        "blackberry",
        "iemobile",
        "opera mini",
        "mobi",
      ],
      placeholder: "בחירה",
      locale: ["אישור", "ביטול", "בחר הכל"],
      okCancelInMulti: false,
      isClickAwayOk: true,
      selectAll: false,
    });

    $("select.nls-search").on("sumo:opening", function (sumo) {
      // Turn arrow up make the filler div extend main to reveal all
      var sumoElement = $(this).parent();
      $(sumoElement).find(".CaptionCont>label>i").addClass("flip");
    });

    $("select.nls-search").on("sumo:closing", function (sumo) {
      // Turn arrow down
      var sumoElement = $(this).parent();
      $(sumoElement).find(".CaptionCont>label>i").removeClass("flip");

      $("div.sumo-filler").css("height", 0);
    });

    // Enable/Disable submit to selected jobs
    $('.sr-select input[type="checkbox"]').on("click", function () {
      $("button.submit-cv.submit-selected").prop(
        "disabled",
        $('.sr-select input[type="checkbox"]:checked').length === 0
      );
    });

    // if sumo select is set
    // Get the search options and set them on the search form
    if (sumoSelect.length > 0) setSearchOptions();

    // Display the form when doc ready (so the sumo select rendered before)
    $("form.nls-search").show();

    // Make the Flash message apear on ready
    $("div.nls-flash-message").css("visibility", "visible");

    // Make the Flash message remove on click
    $("div.nls-flash-message strong").on("click", function () {
      $(this).parent("div.nls-flash-message").remove();
    });

    // Show the Job Details page (from Search Results and Hot Jobs modules)
    $(document).on(
      "click",
      ".nls-search-results-module .sr-job-details button, .nls-hot-jobs-module .info",
      function () {
        var jobId = $(this).attr("job-id");
        window.location.assign(jobDetailsPageUrl + "?jobId=" + jobId);
      }
    );

    // Clear the search form
    $(".nls-search-module a.clear").on("click", function (event) {
      claerSearchFields().bind(this);
      event.preventDefault();
    });

    // Back to Search Page
    $(document).on("click", "#nls-serach-results-new-search", function () {
      window.location.href = searchPageUrl;
    });

    $(document, "input.nls-search.keywords").on("keydown", function (e) {
      if (e.keyCode === 13) {
        e.preventDefault();
        e.stopPropagation();
        $('input[type="submit"]').trigger("click");
      }
    });

    // Open the modal
    $(".submit-cv").on("click", function (event) {
      // clear previous validation
      var formLocation;
      nls.clearFields($(".nls-apply-for-jobs.modal form"));
      jQuery(".entry-content #apply-response").remove();

      if ($(this).hasClass("submit-selected")) {
        formLocation = $(".job-wrap:last");
      } else {
        formLocation = $(this).parents(".job-wrap");
      }
      jQuery(".nls-apply-for-jobs.modal").insertAfter(formLocation);
      jQuery(".nls-apply-for-jobs.modal").show();
      var offset = jQuery(".nls-apply-for-jobs.modal").offset();
      jQuery("html, body").animate({ scrollTop: offset.top - 100 });

      var jobids = $(this).attr("jobcode");
      var submitGeneral = $(this).hasClass("submit-general");
      var submitSelected = $(this).hasClass("submit-selected");
      var applyJobIdsField = $(
        ".nls-apply-for-jobs.modal .modal-content .modal-body input.jobids-hidden-field"
      );
      //console.log('Job IDs: ', jobids);
      //console.log('Submit General: ', submitGeneral);
      //console.log('Submit Selected: ', submitSelected);

      // Submit form with the specified Job ID
      if (jobids !== "undefined") {
        $(applyJobIdsField).val(jobids);
      }

      // Submit to the selected Job IDs (serach results selected jobs)
      if (submitSelected) {
        var selected = [];
        $.each(
          $('#search-result-jobs .sr-select input[type="checkbox"]:checked'),
          function () {
            selected.push($(this).attr("jobcode"));
          }
        );
        $(applyJobIdsField).val(selected);
        //console.log('Selected: ', selected);
      }

      // Submit without specifying Job Code
      if (submitGeneral) {
      }

      event.preventDefault();
    });
  });
})(jQuery);
