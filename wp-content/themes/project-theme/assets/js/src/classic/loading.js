import $ from "jquery";

$(window).on("load", function() {
    $('body').removeClass("is-loading");
    $(".app").addClass("content-loaded");
})