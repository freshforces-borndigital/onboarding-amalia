<?php
/**
 * Template Name: Visual
 */

defined("ABSPATH") || die("Can't access directly");

use BD\TravelMethod\TravelMethod;
use BD\SiteOption\SiteOption;

$the_years = SiteOption::get_years_of_target_number();
$cat_numbers = TravelMethod::get_category_number();
$travel_methods = $cat_numbers['amount_each_cat'];
$yearly_setup = $cat_numbers['each_year_setup'];

get_header();
?>

<div class="app" id="visual">
    <div class="app__page visual">
        <div class="app__content">
            <?php get_template_part("partials/components/comp", "logo-visual"); ?>
            <div class="container container--visual">
                <div class="visual__header">
                    <div class="visual__selector">
                        <span>Choose year</span>
                        <div class="selector">
                            <!-- states: selected -->
                            <?php foreach ($the_years as $year) : ?>
                            <button class="selector__box js-year-select <?= $year == date('Y') ? 'selected' : ''  ?> ">
                                <h3 class="selector__year"><?= $year ?></h3>
                            </button>
                            <?php endforeach; ?>

                            <!-- states: is-visible -->
                            <div class="selector__popup is-visible">
                                <span><?= __("See the differences between the years", "asmlanm") ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="visual__stats">
                        <div class="stat commuting">
                            <i class="stat--icon">
                                <?php include(locate_template('assets/images/commute.svg')); ?>
                            </i>
                            <div class="stat--info">
                                <p><?= __('Commuting', 'asmlanm'); ?></p>
                                <h3 class="js-total-commuting"><?= number_format($yearly_setup['total_commuting_number']); ?></h3>
                            </div>                     
                        </div>
                        <div class="stat not-on-campus">
                            <i class="stat--icon">
                                <?php include(locate_template('assets/images/not_on_campus.svg')); ?>
                            </i>
                            <div class="stat--info">
                                <p><?= __('Not on Campus', 'asmlanm') ?></p>
                                <h3 class="js-total-not-commuting"><?= number_format($yearly_setup['total_not_commuting_number']); ?></h3>
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="visual__info">
                    <div class="visual__dots js-dot-container"></div>
                    <div class="visual__brackets">
                        <?php foreach ($travel_methods as $travel_method): ?>
                            <!-- states: is-overflowing -->
                            <div class="bracket" data-id="<?= $travel_method["id"] ?>">
                                <div class="bracket__overflow">
                                    <div class="indicator"><span>!</span></div>
                                    <div class="warning">
                                        <span><?= $travel_method["warning_txt"] ?></span>
                                    </div>
                                </div>
                                <div class="bracket__animation">
                                    <?php for ($i = 0; $i <= 200; $i++) { ?>
                                        <div class="particle" style="background-color: <?= $travel_method["color"] ?>"></div>
                                    <?php } ?>
                                </div>
                                <div class="bracket__bar">
                                    <div class="bracket__bar--inner js-bar" style="background-color: <?= $travel_method["color"] ?>;"></div>
                                </div>
                                <div class="bracket__animation--reverse">
                                    <?php for ($i = 0; $i <= 200; $i++) { ?>
                                        <div class="particle" style="background-color: <?= $travel_method["color"] ?>"></div>
                                    <?php } ?>
                                </div>
                                <div class="bracket__icon--container">
                                    <img class="bracket__icon" src="<?= $travel_method["icon_dark"] ?>">
                                </div>
                                <h3 class="bracket__number js-current-number" data-id="<?= $travel_method["id"] ?>" data-value="<?= $travel_method["current_number"] ?>" style="color: <?= $travel_method["color"] ?>"><?= $travel_method["current_number"] ?></h3>
                                <h3 class="bracket__number target js-target-number" data-id="<?= $travel_method["id"] ?>" data-value="<?= $travel_method["target_number"] ?>"> / <?= $travel_method["target_number"] ?></h3>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="visual__description">
                        <h2 class="js-year"><?= $yearly_setup["year"] ?></h2>
                        <h3 class="js-desc-title"><?= $yearly_setup["title"] ?></h3>
                        <?= $yearly_setup["description"] ?>
                    </div>
                </div>
            </div>
        </div>
        <?php get_template_part("partials/components/comp", "curtain"); ?>
    </div>
</div>

<?php
get_sidebar();
get_footer();