import $ from "jquery";
import { createAlert, validateEmail } from "./helper";

const stopLoadingAndAlert = (message, ctx) => {
  $(ctx).removeClass("is-loading");
  createAlert("error", message);
};

$(document).on("click", ".js-landingpage-back", function () {
  $(".landingpage").removeClass(
    "is-creating-team is-joining-team is-team-created is-forgetting-team"
  );
});

$(document).on("click", ".js-create-team", function () {
  $(".landingpage").addClass("is-creating-team");
});

$(document).on("click", ".js-join-team", function () {
  $(".landingpage").addClass("is-joining-team");
});

$(document).on("click", ".js-forgot-team", function () {
  $(".landingpage").addClass("is-forgetting-team");
});

$(document).on("click", ".js-submit-team", function () {
  const ctx = this;
  const teamNameVal = $("#teamName").val();
  if (!teamNameVal)
    return stopLoadingAndAlert(
      window.THEMEOBJ.errorMessages.teamNameEmpty,
      ctx
    );

  const emailVal = $("#email").val();
  if (!emailVal)
    return stopLoadingAndAlert(window.THEMEOBJ.errorMessages.emailEmpty, ctx);

  if (!validateEmail(emailVal))
    return stopLoadingAndAlert(window.THEMEOBJ.errorMessages.emailInvalid, ctx);

  const teamCodeVal = $("#teamCode").val();
  if (!teamCodeVal)
    return stopLoadingAndAlert(
      window.THEMEOBJ.errorMessages.teamCodeEmpty,
      ctx
    );

  const $this = $(this);
  $this.addClass("is-loading");

  const formData = new FormData();
  formData.append("action", "create_team");
  formData.append("nonce", window.THEMEOBJ.nonce);

  formData.append("name", teamNameVal);
  formData.append("code", teamCodeVal);
  formData.append("email", emailVal);

  $.ajax({
    url: window.THEMEOBJ.ajaxUrl,
    type: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      if (!response.success) {
        return stopLoadingAndAlert(response.data, ctx);
      }

      // success
      $this.removeClass("is-loading");
      $(".alert").removeClass("is-open");
      $("#teamcode-string").text(response.data.team.code.toUpperCase());
      $("#permalink-string").text(response.data.team.unique_link_absolute);
      $("#new-team-name").text(response.data.team.name);
      $(".landingpage").addClass("is-team-created");
    },
  });
});

$(".js-submit-forgotTeam").click(function () {
  const ctx = this;

  const email = $("#email-forgot").val();
  if (!email) {
    return stopLoadingAndAlert(window.THEMEOBJ.errorMessages.emailEmpty, ctx);
  }

  if (!validateEmail(email))
    return stopLoadingAndAlert(window.THEMEOBJ.errorMessages.emailInvalid, ctx);

  const $this = $(this);
  $this.addClass("is-loading");

  const formData = new FormData();
  formData.append("action", "resend_team_code");
  formData.append("nonce", window.THEMEOBJ.nonce);

  formData.append("email", email);

  $.ajax({
    url: window.THEMEOBJ.ajaxUrl,
    type: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      if (!response.success) {
        return stopLoadingAndAlert(response.data, ctx);
      }

      $this.removeClass("is-loading");
      createAlert("success", response.data.message);
    },
  });
});

$("#joinTeam--form").submit(function (e) {
  e.preventDefault();
});

$(document).on("keypress", "#team-code", function (e) {
  if (e.which == 13) {
    $(".js-submit-join-team").click();
  }
});

$(document).on("click", ".js-submit-join-team", function () {
  const $ctx = $(".js-submit-join-team");
  $(this).addClass("is-loading");
  const teamCode = $("#team-code").val();

  if (!teamCode) {
    return stopLoadingAndAlert(
      window.THEMEOBJ.errorMessages.teamCodeEmpty,
      this
    );
  }

  const formData = new FormData();
  formData.append("action", "check_team");
  formData.append("nonce", window.THEMEOBJ.nonce);

  formData.append("code", teamCode);

  $.ajax({
    url: window.THEMEOBJ.ajaxUrl,
    type: "post",
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      if (!response.success) {
        return stopLoadingAndAlert(response.data, $ctx);
      }

      if (!response.data.team) {
        return stopLoadingAndAlert(
          window.THEMEOBJ.errorMessages.teamNotFoundByCode,
          $ctx
        );
      }

      // console.log("response.data", response.data);
      $ctx.removeClass("is-loading");

      $("body").addClass("is-loading");
      $(".app").removeClass("content-loaded");

      setTimeout(() => {
        const teamCodeLowerCase = teamCode.toLowerCase();
        window.location.href = "/submission/" + teamCodeLowerCase;
      }, 1000);
    },
  });
});

$(document).on("click", ".js-copy-string", function () {
  const $this = $(this);
  const string = $this.prev().text();
  const message = $(this).next();

  const $temp = $("<input>");
  $("body").append($temp);
  $temp.val(string).select();
  document.execCommand("copy");
  $temp.remove();

  message.addClass("is-shown");

  setTimeout(function () {
    message.removeClass("is-shown");
  }, 1500);
});
