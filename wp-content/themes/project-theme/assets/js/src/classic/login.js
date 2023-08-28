import $ from "jquery";

$(document).on('click', '.js-login-dummy, .alert__close', function() {
    toggleAlert();
});



function toggleAlert() {
    const hasOpen = $(".alert").hasClass("is-open");
    const isOpen = !hasOpen;

    $(".alert").toggleClass("is-open", isOpen);
}