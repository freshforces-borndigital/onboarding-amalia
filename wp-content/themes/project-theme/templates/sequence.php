<?php
/**
 * Template Name: Sequence
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

use BD\Sequence\Sequence;

$setting = Sequence::get_first_sequence();
// wp_send_json_success($setting);

get_header();
?>

	<div id="sequence" class="d-flex justify-content-center mb-3">
		<div id="pop-up" class="p-3 align-self-center px-2 container">
			<h2 id="sequence-title"><?php echo $setting->post_title ?></h2>
			<h5><small id="sequence-description" class="text-justify"><?php echo $setting->sub_title?></small></h5>
			<br>
			<p><?php echo $setting->body_question ?></p>

			<div id="answers-div">
				<?php foreach ($setting->answer as $key => $answer) { ?>
					<button class="btn btn-info border-0" id="btn-option-<?=$answer['question_answer_sequence']?>" data-id="<?php echo $answer['question_answer_sequence']?>"><?php echo $answer['question_answer_option'] ?></button>
				<?php } ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>