<?php
/**
 * Template Name: Episode
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

use BD\Sequence\Episode;

$episodes = Episode::get_episode_data();
//wp_send_json_success($episodes);
get_header(); ?>

	<div id="episode" class="content-area w-75">
		<main id="main" class="site-main">
			<div class="row">
				<?php foreach ($episodes as $key => $episode)  { ?>
				<div class="col-md-12">
					<div class="card mb-3 round">
						<div class="row no-gutters">
							<div class="col-md-2">
								<img class="card-img-left img-thumbnail float-left" src="<?php echo $episode->metavalues['episode_image_thumbnail'] ?>" alt="episode thumbnail">
							</div>
							<div class="col-md-10">
								<div class="card-body">
									<small class="card-text"><?php echo $episode->metavalues['episode_sub_title'] ?></small>
									<h5 class="card-title"><?php echo $episode->post_title ?></h5>
									<p class="card-text"><?php echo $episode->metavalues['episode_description'] ?></p>
										<a href="#" id="relation-btn-<?=$episode->metavalues['episode_relation']?>" class="btn btn-primary btn-sm border-0 relation-btn">Start</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>