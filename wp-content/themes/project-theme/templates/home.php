<?php
/**
 * Template Name: Homepage
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="landing-page" class="site-main">
			<div class="row">
				<div class="col-md-12 d-flex justify-content-center">
					<video id="intro-video" controls>
						<source src="<?php echo get_field('homepage_video_intro','option')?>">
					</video>
				</div>
			</div>
			<br>
			<div class="row ">
				<div class="col-md-12">
					<div class="text-center intro-description">
						<p><?php echo get_field('homepage_text_intro','option') ?></p>
					</div>
					<div class="d-flex justify-content-center">
						<a href="<?php echo get_site_url().'/episode'?>" class="btn btn-outline-primary border-0">Continue</a>
					</div>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
