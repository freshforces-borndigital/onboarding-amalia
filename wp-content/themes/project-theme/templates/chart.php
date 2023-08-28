<?php
defined("ABSPATH") || die("Can't access directly");

use BD\Team\Team;
use BD\Chart\Chart;
use BD\TravelMethod\TravelMethod;

$team_unique_link = get_query_var("team_unique_link");
$team = Team::get_by_unique_link($team_unique_link);

if (!$team) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part(404);
    exit();
}

$travel_methods = TravelMethod::get_all();
$team["chart"] = Team::get_chart($team);
// wp_send_json_success($team["chart"]);
$global_chart = Chart::global_chart();
$dashboard_option = get_field('dashboard', 'option');

get_header();
?>

<div class="app" id="dashboard">
    <div class="app__page dashboard">
        <div class="app__bg"></div>
        <?php get_template_part("partials/components/comp", "grid"); ?>
        <header class="submission__header">
            <?php get_template_part("partials/components/comp", "logo"); ?>
            <div class="submission__container container">
                <div class="submission__header--inner">
                    <h2 class="submission__title alignleft"><?= __("Travel habits reports", "asmlanm") ?></h2>
                    <div class="chartLegends">
                        <?php foreach ($travel_methods as $travel_method): ?>
                            <div class="chartLegends__item">
                                <div class="chartLegends__item--icon">
                                    <span class="iconBox" style="background-color: <?= $travel_method["color"] ?>"></span>
                                    <img class="amicon" src="<?= $travel_method["icon_dark"] ?>">
                                </div>
                                <span><?= $travel_method["name"] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <button class="menuTrigger js-menu-toggle" title="<?= __("Open Menu", "asmlanm") ?>">
                <span><?= __("Open Menu", "asmlanm") ?></span>
            </button>
        </header>
        <div class="app__content">
            <div class="container">
                <?php get_template_part("partials/components/comp", "dashboard-chart"); ?>
            </div>
        </div>

        <?php get_template_part("partials/components/comp", "curtain"); ?>
    </div>

    <div id="dashboardPopup" class="popup" isonLoad="true">
        <div class="popup__inner">
            <div class="popup__content">
                <div class="popup__defaultPopup">
                    <button class="popup__close--btn js-close-popup" title="<?= __("Close", "asmlanm") ?>">
                        <span><?= __("Close", "asmlanm") ?></span>
                    </button>
                    <header class="popup__header">
                        <h2 class="popup__title"><?= $dashboard_option['popup_title'] ?></h2>
                    </header>
                    <div class="entrycontent scroller">
                        <?= $dashboard_option['popup_body'] ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php get_template_part("partials/components/comp", "menu-drawer"); ?>
</div>

<?php get_footer();
