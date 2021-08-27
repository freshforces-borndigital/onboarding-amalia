<?php

namespace BD\Sequence;

defined ('ABSPATH') || die("Can't access directly");

class Sequence {

	public static function get_first_sequence() {
		$args = array(
			'post_type'     => 'sequence',
			'post_per_page' => -1,
		);

		$sequences = get_posts($args);

		$sequence = null;
		foreach($sequences as $sq) {
			$first_sequence = get_field('is_first_sequence', $sq->ID);
			if($first_sequence) {
				$sequence = $sq;
			}
		}

		$acf = get_field('sequence_type', $sequence->ID);
		$acf = array_shift(array_values($acf));

		$sequence->sub_title = $acf['question_sub_title'];
		$sequence->body_question = $acf['question_body_question'];
		$sequence->answer = $acf['question_answer'];

		return (object) $sequence;
	}

	public static function get_sequence($post_id)
	{
		$sequence = get_post($post_id);

		$acf = get_field('sequence_type', $post_id);
		$acf = array_shift(array_values($acf));

		$sequence->is_first_sequence = get_field('is_first_sequence', $post_id);
		switch ($acf['acf_fc_layout']) {
			case 'question' :
				$sequence->sub_title = $acf['question_sub_title'];
				$sequence->body_question = $acf['question_body_question'];
				$sequence->answer = $acf['question_answer'];
				break;
			case 'video' :
				$sequence->video_file = $acf['video_file'];
				$sequence->follow_up_sequence = $acf['video_follow_up_sequence'];
				break;
			case 'page' :
				$sequence->sub_title = $acf['page_sub_title'];
				$sequence->follow_up_sequence = $acf['page_follow_up_sequence'];
				break;
		}

		return (object) $sequence;
	}

}

new Sequence();