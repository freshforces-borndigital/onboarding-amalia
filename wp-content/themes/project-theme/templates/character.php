<?php
/**
 * Template Name: Character
 */

defined('ABSPATH') || die("Can't access directly");

use BD\Sequence\Character;

$characters = Character::get_character_data();
//wp_send_json_success($characters);

get_header(); ?>

<div id="character" class="content-area">
	<main id="main" class="site-main">
		<div class="row">
			<?php foreach ($characters as $key => $character)  { ?>
				<div class="col-md-2">
					<div class="card text-center">
						<div class="card-body">
							<small class="card-text"><?php echo $character->relation_episode_title ?></small>
							<h4 class="card-title"><?php echo $character->line_up ?></h4>
							<h6 class="card-title"><?php echo $character->post_title ?></h6>
							<a href="#" id="relation-btn-<?=$character->follow_up_sequence?>" class="btn btn-primary btn-sm border-0 relation-btn">Choose</a>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</main>
</div>



<?php get_footer(); ?>

