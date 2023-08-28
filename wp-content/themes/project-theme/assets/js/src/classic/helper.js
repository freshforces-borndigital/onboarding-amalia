import $ from 'jquery';

const createAlert = (type = null, title = "", body = "", btnTxt = "OK") => {
	$(".alert").removeClass("is-error");
	$(".alert").removeClass("is-success");
	$(".alert").removeClass("is-warning");
	$(".alert").removeClass("is-open");

	if (type) {
		$(".alert").addClass("is-" + type);
	}

	$("#global-alert-title").html(title);
	$("#global-alert-body").html(body);
	$("#global-alert-btn").html(btnTxt);
	$(".alert").addClass("is-open");
};

const validateEmail = (email) => {
	const re = /\S+@\S+\.\S+/;
	return re.test(email);
}

export { createAlert, validateEmail };