<?php 
    
use BD\TravelMethod\TravelMethod;

$travel_methods = TravelMethod::get_all();

?>

<div class="chartLegends">
    <div class="chartLegends__item">
        <div class="chartLegends__item--icon">
            <span class="iconBox target"></span>
        </div>
        <span><?= __("Target 2022", "asmlanm") ?></span>
    </div>
    <?php foreach ($travel_methods as $travel_method): ?>
        <div class="chartLegends__item">
            <div class="chartLegends__item--icon">
                <span class="iconBox" style="background-color: <?= $travel_method["color"] ?>"></span>
                <img class="amicon" src="<?= $travel_method["icon_dark"] ?>">
            </div>
            <span><?= $travel_method["name"] ?></span>
        </div>
    <?php endforeach; ?>
    <div class="chartLegends__item">
        <div class="chartLegends__item--icon">
            <span class="iconBox future"></span>
        </div>
        <span><?= __("Future employees", "asmlanm") ?></span>
    </div>
</div>