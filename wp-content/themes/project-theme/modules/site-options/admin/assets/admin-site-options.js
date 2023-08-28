(function ($) {

    var $acfPieChart = $('.acf-field[data-name="asml_pie_charts"]');

    $acfPieChart.on(
        "input",
        '.acf-field[data-name="actual_number"] input[type=number]',
        function (e) {
            var $this = $(this);
            var thisValue = Number($this.val());
            var $parent = $this.parents(".acf-row");
            var $percentage = $parent.find('.acf-field[data-name="portion"] input[type=number]');

            var totalActualNumber = 0;
            var $actualNumbers = $('.acf-field[data-name="actual_number"] input[type=number]').not(':disabled');
            var $allPercentage = $('.acf-field[data-name="portion"] input[type=number]').not(':disabled');

            $.each($actualNumbers, function (key, value) {
                const eachActualNumber = Number($(value).val());
                totalActualNumber += eachActualNumber;
            });
            
            const calculatePercentage = (portion, total) => {
              const thePercentage = (portion / total) * 100;

              return Math.round(thePercentage);
            };

            const thisPercentage = calculatePercentage(thisValue, totalActualNumber);
            $percentage.val(thisPercentage);

            $.each($allPercentage, function (key, value) {
                if (this === $percentage.get(0)) return;

                let $parent = $(this).parents(".acf-row");
                let $actualNumber = $parent.find('.acf-field[data-name="actual_number"] input[type=number]');
                let actualNumber = Number($actualNumber.val());

                if (actualNumber !== 0) {
                    const updatePercentage = calculatePercentage(actualNumber, totalActualNumber);

                    $(this).val(updatePercentage);
                }
            });
        }
    );

})(jQuery);