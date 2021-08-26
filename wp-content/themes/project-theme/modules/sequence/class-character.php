<?php

namespace BD\Sequence;

defined ('ABSPATH') || die("Can't access directly");

class Character {

	public static function get_character_data() {
		$args = array(
			'post_type'     => 'character',
			'post_per_page' => -1,
		);

		$characters = get_posts($args);

		foreach ($characters as $character) {
			$acf = get_fields($character->ID);

			$character->relation_episode_title = $acf['character_relation']->post_title;
			$character->relation_episode_ID = $acf['character_relation']->ID;
			$character->line_up = $acf['character_line_up'];
			$character->follow_up_sequence = $acf['character_follow_up_sequence'];
		}

		return $characters;
	}
}

new Character();