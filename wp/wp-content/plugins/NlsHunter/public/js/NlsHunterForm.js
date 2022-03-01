var nls =
  nls ||
  (function ($) {
    "use strict";

    var emptyFriendDetails = '';

    var Validators = {
      ISRID: {
        fn: function (value) {
          // DEFINE RETURN VALUES
          var R_ELEGAL_INPUT = false; // -1
          var R_NOT_VALID = false; // -2
          var R_VALID = true; // 1

          //INPUT VALIDATION

          // Just in case -> convert to string
          var IDnum = String(value);

          // Validate correct input (Changed from 5 to 9 so only 9 digits are allowed)
          if (IDnum.length > 9 || IDnum.length < 9) return R_ELEGAL_INPUT;
          if (isNaN(IDnum)) return R_ELEGAL_INPUT;

          // The number is too short - add leading 0000
          if (IDnum.length < 9) {
            while (IDnum.length < 9) {
              IDnum = "0" + IDnum;
            }
          }

          // CHECK THE ID NUMBER
          var mone = 0,
            incNum;
          for (var i = 0; i < 9; i++) {
            incNum = Number(IDnum.charAt(i));
            incNum *= (i % 2) + 1;
            if (incNum > 9) incNum -= 9;
            mone += incNum;
          }
          if (mone % 10 == 0) return R_VALID;
          else return R_NOT_VALID;
        },
        msg: "מספר הזהות לא חוקי",
      },

      email: {
        fn: function (value) {
          var regex =
            /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return value && regex.test(String(value).toLowerCase());
        },
        msg: "כתובת האימייל לא חוקית",
      },

      phone: {
        fn: function (value) {
          var regex = /^0[0-9]{1,2}[-\s]{0,1}[0-9]{3}[-\s]{0,1}[0-9]{4}/i;
          return value && regex.test(String(value).trim().toLowerCase());
        },
        msg: "מספר הטלפון לא חוקי",
      },

      required: {
        fn: function (value) {
          return value && value.length > 0;
        },
        msg: "שדה זה הוא שדה חובה",
      },

      // If no option was selected of radi will return false
      radioRequired: {
        fn: function (el) {
          var valid = false;
          var name = $(el).attr("name");
          if (typeof name === "undefined") return valid;

          $(el)
            .parents(".nls-apply-field")
            .find('input[name="' + name + '"]')
            .each(function (i, option) {
              if ($(option).prop("checked")) valid = true;
            });
          return valid;
        },
        msg: "יש לבחור אחת מהאפשרויות",
      },
    };

    var validateSubmit = function (form, formData) {
      clearValidation(form);
      var valid = true;

      $(form)
        .find("input")
        .each(function (i, el) {
          if ($(el).parents(".nls-apply-field").css("display") === "none")
            return;
          if (typeof $(el).attr("validator") === "undefined") return;
          if (!fieldValidate(el)) valid = false;
        });
      console.log("Valid: ", valid);
      validForm();
      return valid;
    };

    var validForm = function () {
      var invalidFields = $("form.nls-apply-for-jobs .nls-invalid");
      if (invalidFields.length > 0) {
        $(".nls-apply-for-jobs .form-footer .help-block")
          .text("אחד או יותר משדות הטופס לא תקין")
          .show();
      } else {
        $(".nls-apply-for-jobs .form-footer .help-block").hide();
        $(".nls-apply-for-jobs .help-block").text("");
      }
    };

    // Validates all of the field validators
    var fieldValidate = function (el) {
      var valid = true;
      var validatorAttr = $(el).attr("validator");
      var validators = validatorAttr.trim().split(" ");
      var type = $(el).attr("type");
      var value = type === "radio" ? el : $(el).val();

      validators.forEach(function (validator) {
        if (!validator || validator.length === 0) return;
        // If invalid skip (show only first error)
        if ($(el).hasClass("nls-invalid")) return;

        if (!Validators[validator].fn(value)) {
          valid = false;
          var invalidElement =
            type === "radio" ? $(el).parents(".options-wrapper") : $(el);

          $(invalidElement).addClass("nls-invalid");
          $(el)
            .parents(".nls-apply-field")
            .find(".help-block")
            .text(Validators[validator].msg);
        }
      });
      return valid;
    };

    var clearFields = function (form) {
      form.find('input:not([type="radio"],[type="hidden"])').val("");
      clearValidation(form);
    };

    var clearValidation = function (form) {
      form.find(".nls-invalid").removeClass("nls-invalid");
      form.find(".nls-apply-field .help-block").text("");
      validForm();
    };

    var clearFieldValidation = function (el) {
      $(el)
        .parents(".nls-apply-field")
        .find(".nls-invalid")
        .removeClass("nls-invalid");
      $(el).parents(".nls-apply-field").find(".help-block").text("");
    };

    var getParam = function (param) {
      var queryString = window.location.search;
      var urlParams = new URLSearchParams(queryString);
      return urlParams.get(param);
    };

    var hideBeforeApply = function () {
      $(".nls-apply-for-jobs").hide();
      $("section.nls-fbf-flow-wrapper").hide();
    };

    var showHomePage = function () {
      $("#apply-response").remove();
      $(".nls-reply-message").remove();
      $(".hide-response-success").show();
      $(".hide-response-error").show();
      $(".nls-apply-for-jobs").show();
      $("section.nls-fbf-flow-wrapper").show();
    };

    $(document).ready(function () {
      // Set the sid if exist
      getParam("sid") && $('input[name="sid"').val(getParam("sid"));

      // Add event listeners
      console.log("Ready Function");

      // Apply selected jobs
      $(document).on(
        "click",
        ".nls-apply-for-jobs .nls-button .apply-cv",
        function (event) {
          var applyCvButton = this;
          var form = $(this).parents("form.nls-apply-for-jobs");
          var formData = new FormData(form[0]);

          if (!validateSubmit(form, formData)) {
            event.preventDefault();
            return;
          }

          formData.append("action", "apply_cv_function");

          $.ajax({
            url: frontend_ajax.url,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            beforeSend: function () {
              hideBeforeApply();
              $(".nls-apply-for-jobs").after(
                '<div id="apply-response" class="nls-rounded-10 nls-box-shadow"><div id="nls-loader" class="loader">אנא המתן...</div></div>'
              );
              var offset = $("#apply-response").offset();
              $("html, body").animate({
                scrollTop: offset.top - 100,
              });
            },
            success: function (response) {
              $("#nls-loader").remove();
              console.log("Status: ", response.sent);

              if (response.sent > 0) {
                $(".hide-response-success").hide();
                $("#apply-response").remove();
                $('.nls-apply-for-jobs').after(response.html);
              } else {
                $('.hide-response-error').hide();
                $("#apply-response").remove();
                $('.nls-apply-for-jobs').after(response.html);
              }

              // Call this function so the wp will inform the change to the post
              $(document.body).trigger("post-load");
            },
            complete: function () {
              window.history.pushState({}, '/');
            },
            type: "POST",
          });

          event.preventDefault();
        }
      );

      // State handler
      window.addEventListener("popstate", function (event) {
        if (event.state === null) {
          showHomePage();
        }
      });

      // Apply friend button handler
      $(".apply-friend a").on("click", function () {
        $(".friends-container")[0].scrollIntoView();
        $("#friend-name--0")[0].focus();
      });

      // Create an empty element
      emptyFriendDetails = $('.nls-apply-for-jobs .friends-details .friends-container').html();

      // Add new friend hendler
      $('.nls-apply-for-jobs .friends-details .form-footer .nls-button .add-friend').on('click', function () {
        var count = $('.nls-apply-for-jobs .friends-details .friends-container .form-body').length;
        var needle = /--0/g;
        var re = '--' + count;

        $(emptyFriendDetails.replace(needle, re)).hide().appendTo('.nls-apply-for-jobs .friends-details .friends-container').show('slow');
      });

      // Remove friend
      $(document).on('click', '.nls-apply-for-jobs .friends-details .friends-container .form-body span.remove', function () {
        var target = $(this).parent();
        $(target).hide('slow', function () { $(target).remove(); });
      });

      // Add file indication when selected
      $(document).on("change", '.nls-apply-for-jobs input[type="file"]', function (e) {
        if ($(this).val().length > 0) {
          $(this).parent().find('label').addClass('file-selected');
        } else {
          $(this).parent().find('label').removeClass('file-selected');
        }
      });

      // Clear validation errors on focus
      $(document).on("focus", "input", function () {
        clearFieldValidation(this);
      });

      // Validate on blur and change
      $(document).on('blur change', 'input:not([type="radio"])', function () {
        if (typeof $(this).attr("validator") === "undefined") return;
        clearFieldValidation(this);
        fieldValidate(this);
        validForm();
      });

      // Toggle visibility of radio
      $(document).on("change", 'input[type="radio"]', function () {
        var showClass = ".nls-apply-field." + $(this).attr("name") + "-show";
        $('input[name="' + $(this).attr("name") + '"]').prop("checked")
          ? $(showClass).show()
          : $(showClass).hide();
      });

      $(document).on('click', 'button.nls-btn.back', function () {
        $(this).parents('section.nls-hunter-fbf-wrapper').find('form.nls-apply-for-jobs').slideDown();
        $(this).parents('.submit-response').remove();
      });

      // Make sure to initilize the radio display options
      $('input[type="radio"]').trigger("change");
    });

    return {
      clearFields: clearFields,
    };
  })(jQuery);
