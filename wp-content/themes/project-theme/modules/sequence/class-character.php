<?php

namespace BD\Sequence;

defined ('ABSPATH') || die("Can't access directly");

class Character {

	public static function get_character_data($episode_id) {
		$args = array(
			'post_type'     => 'character',
			'post_per_page' => -1,
		);

		$characters = get_posts($args);

		$charactersNew = [];

		foreach ($characters as $character) {
			$matched_episode = get_field('character_relation', $character->ID);
			if($matched_episode == $episode_id) {
				$acf = get_fields($character->ID);
				$acf['character_relation_title'] = get_the_title($episode_id);

				$charactersNew[] = array_merge((array) $character, $acf);
			}
		}

		return $charactersNew;
	}
}

new Character();