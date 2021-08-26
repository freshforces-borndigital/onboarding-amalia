<?php

namespace BD\Sequence;

defined ('ABSPATH') || die("Can't access directly");

class Episode {

	public static function get_episode_data() {
		$args = array(
			'post_type'     => 'episode',
			'post_per_page' => -1,
		);

		$episodes = get_posts($args);
		foreach ($episodes as $episode) {
			$acf = get_fields($episode->ID);
			$episode->metavalues = $acf;
		}

		return $episodes;
	}
}

new Episode();