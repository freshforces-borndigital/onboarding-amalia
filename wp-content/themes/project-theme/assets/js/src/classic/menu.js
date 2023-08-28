import $ from "jquery";

$(document).on("click", ".js-menu-toggle", function() {
    const hasOpen = $(".menuWrapper").hasClass("is-open");
    const isOpen = !hasOpen;

    $(".menuWrapper").toggleClass("is-open", isOpen);

    
});