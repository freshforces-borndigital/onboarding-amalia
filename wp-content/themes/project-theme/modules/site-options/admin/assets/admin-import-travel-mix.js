(function ($){
    const ajaxImportTravelMix = (e) => {
        e.preventDefault();

        const $loading = $(".loading");
        const $importBtn = $("#import-travel-btn");
        const formData = new FormData();

        formData.append("nonce", ADMINOBJ.nonce);
        formData.append("action", ADMINOBJ.ajx.importTravelMix);
        formData.append("import_file", $("input[type=file]")[0].files[0]);

        $loading.css("display", "block");
        $importBtn.prop("disabled", true);

        $.ajax({
            url: ADMINOBJ.ajaxUrl,
            type: "POST",
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
        })
            .done((res) => {
                $loading.css("display", "none");
                $importBtn.prop("disabled", false);

                let type,
                    msg = "";

                if (res && res.success) {
                    type = "updated";
                    msg = res.data;
                } else {
                    type = "error";
                    msg = res.data.message;
                }

                $("input[type=file]").val("");

                var $notice = $("#notice").html();
                $notice = $($.parseHTML($notice));

                $notice
                    .addClass(type)
                    .find(".txt-msg")
                    .html("<strong>" + msg + "</strong>");

                $(".info").html($notice);
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.error("Status: " + textStatus);
                console.error("Error: " + errorThrown);
                console.error("There's something wrong. Try again.");

                $loading.css("display", "none");
                $importBtn.prop("disabled", false);
            });

        return false;
    };

    const dismissNotice = () => {
        const $noticeInfo = $("#notice");

        if ($noticeInfo.length > 0) $noticeInfo.remove();
    };

    $("#import-travel-btn").on("click", ajaxImportTravelMix);
    $(document).on("click", ".notice-dismiss", dismissNotice);

})(jQuery);