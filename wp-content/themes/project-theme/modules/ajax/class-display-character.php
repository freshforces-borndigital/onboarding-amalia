<?php

namespace BD\Ajax;

defined('ABSPATH') || die("Can't access directly");

use BD\Sequence\Character;

class DisplayCharacter {
	private $episode_id;

	public function __construct() {
		add_action('wp_ajax_display_character',[$this, 'ajax']);
		add_action('wp_ajax_nopriv_display_character',[$this,'ajax']);
	}

	public function ajax() {
		$this->_sanitize();
		$this->_validate();
		$this->_response();
	}

	private function _sanitize()
	{
		if (!isset($_POST) || !isset($_POST['nonce'])) {
			wp_die();
		}

		$this->episode_id = isset($_POST['episode_id']) ? sanitize_text_field($_POST['episode_id']) : false;
	}

	private function _validate()
	{
		$post = get_post($this->episode_id);

		if(!$post) {
			wp_send_json_error(__('Post not found','onboardingamalia'));
		}
	}

	private function _response()
	{
		$caharacters = Character::get_character_data($this->episode_id);

		wp_send_json_success($caharacters);
	}
}

new DisplayCharacter();
