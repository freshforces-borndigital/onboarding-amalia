export const importTravelMix = () => {
    const widiw = window;
    if (!widiw.jQuery) return;

    const $ = widiw.jQuery;
    const CFG = widiw.ADMINOBJ;
    const $form = $("form#import-travel-mix");
    console.log("testststst");

    if (!$form) return;

    const ajaxImportTravelMix = (e) => {
        e.preventDefault();

        const $loading = $(".loading");
        const $importBtn = $("#import-travel-btn");
        const formData = new FormData();

        formData.append("nonce", CFG.nonce);
        formData.append("action", CFG.ajx.importTravelMix);
        formData.append("import_file", $("input[type=file]")[0].files[0]);
        formData.append("text","test text");
        console.log(formData)

        $loading.css("display", "block");
        $importBtn.prop("disabled", true);

        $.ajax({
            url: CFG.ajaxURL,
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
        })
            .done((res) => {
                console.log(res)
                /*$loading.css("display", "none");
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

                $(".info").html($notice);*/
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                // console.log("jqXHR response: " + jqXHR.responseText);
                console.log("Status: " + textStatus);
                console.log("Error: " + errorThrown);
                console.error("There's something wrong. Try again.");
            });

        return false;
    };

    const dismissNotice = () => {
        const $noticeInfo = $("#notice");

        if ($noticeInfo.length > 0) $noticeInfo.remove();
    };

    $form.on("submit", ajaxImportTravelMix);
    $(document).on("click", ".notice-dismiss", dismissNotice);
}