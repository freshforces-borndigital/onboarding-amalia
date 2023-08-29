<?php
/**
 * Template Name: Dashboard
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

get_header(); ?>

    <div class="app" id="dashboard">
        <div class="app__page dashboard">
            <div class="app__bg"></div>
            <?php get_template_part( 'partials/components/comp', 'grid'); ?>
            <header class="submission__header">
                <?php get_template_part( 'partials/components/comp', 'logo'); ?>
                <div class="submission__container container">
                    <div class="submission__header--inner">
                        <h2 class="submission__title"><?= __("Travel habits reports", "asmlanm")?></h2>
                        <div class="chartLegends">
                            <div class="chartLegends__item">
                                <i class="amicon amicon-bicycle"></i>
                                <span><?= __("Bicycle / Walking", "asmlanm") ?></span>
                            </div>
                            <div class="chartLegends__item">
                                <i class="amicon amicon-bus"></i>
                                <span><?= __("Public Transportation", "asmlanm")?></span>
                            </div>
                            <div class="chartLegends__item">
                                <i class="amicon amicon-car"></i>
                                <span><?= __("Car", "asmlanm")?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="app__content">
                <div class="container">
                    <?php get_template_part('partials/components/comp', 'dashboard-chart'); ?>
                </div>
            </div>

            <?php get_template_part( 'partials/components/comp', 'curtain'); ?>
        </div>
    </div>

<?php
get_sidebar();
get_footer();
