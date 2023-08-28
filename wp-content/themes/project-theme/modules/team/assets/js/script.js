(function ($) {
	const calculatePoint = () => {
		const host = CFG.host;
		const code = $("#team-unique-link-code input").val();
		if (!code) return $("#team-unique-link-result .acf-input").html("-");

		const url = `${host}/chart/${code}`;
		$("#team-unique-link-result .acf-input").html(
			`<a href="${url}" target="_BLANK">${url}</a>`
		);
	};

	$("#team-unique-link-code input").change(calculatePoint);
	$("#team-unique-link-code input").keyup(calculatePoint);
	calculatePoint();
})(jQuery);
