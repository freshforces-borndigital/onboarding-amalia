import $ from "jquery";
window.$ = $;
import { createAlert } from "./helper";

const workDays = 5;
const teamCode = $("#submission").attr("data-team-code");

const stopLoadingAndAlert = (message, ctx) => {
  $(ctx).removeAttr("disabled");
  $(ctx).removeClass("is-loading");
  createAlert("error", message);
};

const isComplete = () => {
  const keys = Array.from(Array(workDays).keys());
  const data = keys.map((k) =>
    $("input[name='submission[" + k + "]']:checked").val()
  );

  return data.filter((v) => v).length === workDays;
};

const togglePopup = () => {
  const hasOpen = $("#successpopup").hasClass("is-open");
  const isOpen = !hasOpen;

  $("#successpopup").toggleClass("is-open", isOpen);
};

$(document).on("click", ".js-day-input", function () {
  const $this = $(this);
  const thisDay = $this.attr("name");
  const $siblings = $('.js-day-input[name="' + thisDay + '"]').not($this);

  $this.removeClass("inactive");
  $siblings.addClass("inactive");

  if (isComplete()) {
    $(".js-submit-travel-methods").removeAttr("disabled");
  } else {
    $(".js-submit-travel-methods").prop("disabled", "disabled");
  }
});

$(document).on("click", ".js-toggle-success", function () {
  togglePopup();
});

$(document).on("click", ".js-submit-travel-methods", function () {
  const ctx = this;
  $(ctx).prop("disabled", "disabled");
  $(ctx).addClass("is-loading");

  // $("#alert-submission").show();
  // stopLoadingAndAlert(window.THEMEOBJ.errorMessages.failedSubmitData, ctx);

  const keys = Array.from(Array(workDays).keys());
  const travelMethods = keys.map((k) =>
    $("input[name='submission[" + k + "]']:checked").val()
  );

  const formData = new FormData();
  formData.append("action", "submit_travel_methods");
  formData.append("nonce", window.THEMEOBJ.nonce);

  formData.append("code", teamCode);
  formData.append("travel_methods", travelMethods);

  $.ajax({
    url: window.THEMEOBJ.ajaxUrl,
    type: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      try {
        if (!response.success) {
          return stopLoadingAndAlert(response.data, ctx);
        }

        if (response.data.answer.status === "error") {
          return stopLoadingAndAlert(response.data.answer.msg, ctx);
        }

        $("input").prop("disabled", "disabled");
        $(ctx).removeClass("is-loading");
        // eslint-disable-next-line no-console
        console.log("response.data", response.data);
        togglePopup();
      } catch (e) {
        // eslint-disable-next-line no-console
        console.log("e", e);
        stopLoadingAndAlert("Unknown error", ctx);
      }
    },
  });
});
