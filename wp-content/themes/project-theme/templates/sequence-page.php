<?php
/**
 * Template Name: Sequence Page
 */

defined('ABSPATH') || die("Can't access directly");

use BD\Sequence\Episode;
use BD\Sequence\Character;
use BD\Sequence\Sequence;

$episodes = Episode::get_episode_data();

get_header(); ?>

<!--display episodes-->
<div id="episode" class="content-area p-3 container">
	<main id="main" class="site-main">
		<div class="row">
			<?php foreach ($episodes as $key => $episode)  { ?>
				<div class="col-md-11">
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
								</div>
								<div class="card-footer border-0 bg-transparent">
									<button id="relation-btn-<?=$episode->metavalues['episode_relation']?>" data-id="<?php echo $episode->ID?>" class="btn btn-primary btn-sm border-0 choose-sequence">Start</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</main>
</div>

<!--display sequence question-->
<div id="display-sequence-question" class="d-flex justify-content-center mb-3">
	<div class="p-3 align-self-center px-2 container">
		<small id="sequence-sub-title" class="text-justify"></small>
		<h2 id="sequence-title"></h2>
		<br>
		<p id="sequence-question"></p>
		<div id="answers-div">
		</div>
	</div>
</div>

<!--display sequence video-->
<div id="display-sequence-video" class="content-area container">
	<main id="main" class="site-main">
		<h4 id="video-title"></h4>
		<video id="video-file" width="650" controls></video>
		<br>
		<button class="btn btn-info next-sequence-video border-0" id="next-video">Next</button>
	</main>
</div>

<!--display characters-->
<div id="character" class="content-area container">
	<main id="main" class="site-main">
		<div id="display-character" class="row">
		</div>
	</main>
</div>

<?php get_footer(); ?>
