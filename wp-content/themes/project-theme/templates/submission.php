<?php
/**
 * Template Name: Submission
 */

defined("ABSPATH") || die("Can't access directly");

use BD\Team\Team;
use BD\Chart\Chart;

$team_unique_link = get_query_var("team_unique_link");
$team = Team::get_by_code($team_unique_link);
$fill_travel_method_bg = get_field('fill_travel_method_bg', 'option');

if (!$team || !$team_unique_link) {
    global $wp_query;
    $wp_query->set_404();
    status_header(404);
    get_template_part(404);
    exit();
}

get_header();
?>

    <div class="app" id="submission" data-team-code="<?= $team_unique_link ?>">
        <div class="app__page submission">
            <div class="app__bg"></div>
            <?php get_template_part("partials/components/comp", "grid"); ?>
            <header class="submission__header">
                <?php get_template_part("partials/components/comp", "logo"); ?>
                <div class="submission__container container">
                    <div class="submission__header--inner">
                        <div class="submission__team">
                            <span><?= __("Team name", "asmlanm"); ?></span>
                            <h5><?= $team["name"] ?></h5>
                        </div>
                        <h2 class="submission__title"><?= __(
                            "Select if and how you commuted to work last week",
                            "asmlanm"
                        ) ?></h2>
                        <div class="submission__actions">
                            <button class="btn btn--primary btn--c-pink btn--icon-after js-submit-travel-methods" title="<?= __(
                                "Submit",
                                "asmlanm"
                            ) ?>" disabled="disabled">
                                <i class="amicon amicon-arrow-right"></i>
                                <span><?= __("Submit", "asmlanm") ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            <div class="app__content">
                <div class="container">
                    <?php get_template_part("partials/components/comp", "submit-form"); ?>
                </div>
            </div>

            <?php get_template_part("partials/components/comp", "success-popup"); ?>
            <?php get_template_part("partials/components/comp", "curtain"); ?>
        </div>
    </div>

    <div id="alert-submission" class="alert"><!-- class is-error, is-success, is-wraning, no extra class for blue color !-->
        <div class="alert__inner">
            <div class="alert__content">
                <h4 class="alert__title"><?= __("Succes message title", "asmlanm"); ?></h4>
                <span><?= __("Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.", "asmlanm"); ?></span>
            </div>    
            <button class="alert__close btn btn--secondary btn--c-white" title="Button label">
                <span><?= __("Ok! great", "asmlanm"); ?></span>
            </button>              
        </div>
    </div>

<?php
get_sidebar();
get_footer();
