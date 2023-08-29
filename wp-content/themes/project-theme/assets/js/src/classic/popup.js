import $ from "jquery";

$(document).on("click", ".js-close-popup", function() {
    $(this).parents(".popup").removeClass("is-open");
});

$(document).on("click", ".js-popup-trigger", function() {
    const targetPopup = $(this).attr("data-popup");
    $(this).parents(".popup").removeClass("is-open");

    $("#"+targetPopup).addClass("is-open");
});

$(window).on("load", function() {
    $(".popup").each(function() {
        const $this = $(this);
        const dataInit = $(this).attr("isonload");

        if (dataInit == "true") {
            setTimeout(function() {
                $this.addClass("is-open");
                // console.log(dataInit)
            }, 1000)
        }
    })
})