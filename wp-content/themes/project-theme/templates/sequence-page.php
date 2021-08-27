<?php
/**
 * Template Name: Sequence Page
 */

defined('ABSPATH') || die("Can't access directly");

use BD\Sequence\Episode;
use BD\Sequence\Character;
use BD\Sequence\Sequence;

$episodes = Episode::get_episode_data();
$setting = Sequence::get_first_sequence();
$characters = Character::get_character_data();

get_header(); ?>

<!--display episodes-->
<div id="episode" class="content-area w-75 p-3">
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
									<a href="#" id="relation-btn-<?=$episode->metavalues['episode_relation']?>" data-id="<?php echo $episode->ID?>" class="btn btn-primary btn-sm border-0 relation-btn">Start</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</main>
</div>

<!--display sequence type-->
<div id="sequence-type">
	<div class="row">
		<div class="col-md-4">
			<button class="btn btn-info border-0 sequence-video" id="sequence-video">Videos</button>
		</div>
		<div class="col-md-4">
			<button class="btn btn-info border-0 sequence-question" id="sequence-question">Questions</button>
		</div>
		<div class="col-md-4">
			<button class="btn btn-info border-0 sequence-page" id="sequence-page">Pages</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<button class="btn btn-success border-0 character-btn" id="">List of Characters</button>
		</div>
	</div>
</div>

<!--display sequence question-->
<div id="display-sequence-question" class="d-flex justify-content-center mb-3">
	<div class="p-3 align-self-center px-2 container">
		<small id="sequence-sub-title" class="text-justify"><?php echo $setting->sub_title?></small>
		<h2 id="sequence-title"><?php echo $setting->post_title ?></h2>
		<br>
		<p id="sequence-question"><?php echo $setting->body_question ?></p>

		<div id="answers-div">
			<?php foreach ($setting->answer as $key => $answer) { ?>
				<button class="btn btn-info border-0 option-btn" id="option-btn-<?=$answer['question_answer_sequence']?>" data-id="<?php echo $answer['question_answer_sequence']?>"><?php echo $answer['question_answer_option'] ?></button>
			<?php } ?>
		</div>
	</div>
</div>

<!--display characters-->
<div id="character" class="content-area">
	<main id="main" class="site-main">
		<div class="row">
			<?php foreach ($characters as $key => $character)  { ?>
				<div class="col-md-2">
					<div class="card text-center">
						<div class="card-body">
							<small class="card-text"><?php echo $character->relation_episode_title ?></small>
							<h4 class="card-title"><?php echo $character->post_title ?></h4>
							<h6 class="card-title"><?php echo $character->line_up ?></h6>
							<a href="#" id="relation-btn-<?=$character->follow_up_sequence?>" class="btn btn-primary btn-sm border-0 relation-btn">Choose</a>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</main>
</div>

<?php get_footer(); ?>
