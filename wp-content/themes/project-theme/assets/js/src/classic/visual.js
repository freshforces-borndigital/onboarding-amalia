import $ from "jquery";
import {createAlert} from "./helper";

export const VisualPage = () => {
    // Check to make sure we are on the visual page, otherwise the code below won't run
    const isVisualPage = $("#visual").length > 0;
    if (!isVisualPage) return;

    const stopLoadingAndAlert = (message) => {
        // $(ctx).removeClass("is-loading");
        createAlert("error", message);
    };

    const elms = {
        year: ".js-year",
        yearSelector: ".js-year-select",
        dotContainer: ".js-dot-container",
        currentNumber: ".js-current-number",
        targetNumber: ".js-target-number",
        totalCommuting: ".js-total-commuting",
        totalNotCommuting: ".js-total-not-commuting",
        innerBracket: ".js-bar",
    };

    // Init brackets with 0 height as starting point for animation
    const initBarHeight = () => {
        const $innerBrackets = $(elms.innerBracket);

        $innerBrackets.css('height', '0%');
    }

    // Start bracket animation
    let newCurrentNumber = 0;

    const initBarAnimation = () => {
        const $catBrackets = $(".bracket");

        $.each($catBrackets, function (key, value) {
            const $this = $(value);
            const catID = $this.attr("data-id");
            const $innerBracket = $this.find(".js-bar");
            const $innerBracketReverseAnim = $this.find(".bracket__animation--reverse");
            const $currentNumber = $(elms.currentNumber + `[data-id=${catID}]`);
            const $targetNumber = $(elms.targetNumber + `[data-id=${catID}]`);
            const currentNumber = $currentNumber.attr("data-value").replace(/,/g, ""); // regex to remove all commas;
            const targetNumber = $targetNumber.attr("data-value").replace(/,/g, "");
            let bracketPercentage = (Number(currentNumber) / Number(targetNumber)) * 100;
            bracketPercentage = isNaN(bracketPercentage) ? 0 : bracketPercentage;

            $catBrackets.removeClass("is-overflowing");
            $innerBracket.css('height', `${bracketPercentage}%`);

            if (Number(currentNumber) > Number(newCurrentNumber)) {
                $innerBracketReverseAnim.css('opacity', '1');
            }
            newCurrentNumber = currentNumber;

            // Wait for height transition to finish
            setTimeout(() => {
                $innerBracketReverseAnim.css('opacity', '0');
                
                // If bracket is overflowing
                if (Number(currentNumber) > Number(targetNumber)) {
                    $this.addClass("is-overflowing");
                }
            }, 1250);
        });
    }

    // Get year data
    const getYearlyNumber = (year) => {
        const formData = new FormData();
        formData.append("action", "get_target_number");
        formData.append("nonce", window.THEMEOBJ.nonce);
        formData.append("year", year);
        
        $.ajax({
            url: window.THEMEOBJ.ajaxUrl,
            type: "post",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (!res.success) {
                    return stopLoadingAndAlert(res.data)
                }

                const numberPerCat = res.data.amount_each_cat;
                $.each(numberPerCat, function (key, value) {
                    const $currentNumber = $(elms.currentNumber + `[data-id=${value.id}]`);
                    const $targetNumber = $(elms.targetNumber + `[data-id=${value.id}]`);

                    $currentNumber.text(value.current_number);
                    $currentNumber.attr("data-value", value.current_number);

                    $targetNumber.text("/" + value.target_number);
                    $targetNumber.attr("data-value", value.target_number);
                });

                setTimeout(() => {
                    initBarAnimation();
                }, 1000);

                const yearly_setup = res.data.each_year_setup;
                $(elms.totalCommuting).text(yearly_setup.total_commuting_number);
                $(elms.totalNotCommuting).text(yearly_setup.total_not_commuting_number);
                $(".js-desc-title").text(yearly_setup.title);
                $(".visual__description p").html(yearly_setup.description);
            }
        });
    }

    // Select the year to be visualized
    const selectYear = (e) => {
        if ($(e.target).hasClass("selected")) return;

        $(elms.yearSelector).removeClass("selected");
        $(e.target).addClass("selected");
        $(".selector__popup").removeClass("is-visible"); // user only needs to see popup once
        generateDots(); // generate new dots to give the appearance of changing data

        const theYear = $(e.target).text();
        $(elms.year).text(theYear);
        getYearlyNumber(theYear);
    }

    // Generate a random number of dots (the position is random via SCSS)
    // TO-DO: Figure out how to convert to CANVAS (because it is better for graphic performance)
    const generateDots = () => {
        const $dotContainer = $(elms.dotContainer);
        const $dot = $("<div>", {"class": "dot"});
        const maxDots = Math.floor((Math.random() * 300) + 1); // initialize variable with randomly generated value between 1 and 300

        if (!$dotContainer.is(":empty")) $dotContainer.empty(); // clear all dots before proceeding

        for (let i = 0; i < maxDots; i++) {
            $dotContainer.append($dot.clone()); // clone dot element to repeatedly append
        }
    }

    // Run functions here
    generateDots();
    initBarHeight();
    setTimeout(() => {
        initBarAnimation();
    }, 2150);
    $(elms.yearSelector).on("click", selectYear);
}