<?php
use BD\TravelMethod\TravelMethod;

$travel_methods = TravelMethod::get_all();
$days = [__("Monday", "asmlanm"), __("Tuesday","asmlanm"), __("Wednesday","asmlanm"), __("Thursday","asmlanm"), __("Friday","asmlanm")];
?>

<div class="submission__form">
    <?php foreach ($days as $key => $day): ?>
        <div class="submission__form--col">
            <span class="submission--day"><?= $day ?></span>
            <?php foreach ($travel_methods as $travel_method): ?>
                <div class="travelMethod">
                    <input type="radio" class="js-day-input day-<?= $key ?>" name="submission[<?= $key ?>]" value="<?= $travel_method[
    "id"
] ?>" />
                    <div class="travelMethod--label">
                        <span class="travelMethod--icon">
                            <img class="icon-image" src="<?= $travel_method["icon_dark"] ?>">
                            <img class="icon-image selected-icon" src="<?= $travel_method["icon"] ?>">
                        </span>
                        <span class="travelMethod--text"><?= $travel_method["name"] ?></span>
                        <span class="travelMethod--selected">
                            <i class="amicon amicon-check"></i>
                        </span>
                        <span class="travelMethod--bg" style="background-color: <?= $travel_method["color"] ?>"></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>
