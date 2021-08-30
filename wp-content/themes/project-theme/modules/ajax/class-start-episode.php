<?php

namespace BD\Ajax;

defined ('ABSPATH') || die("Can't access directly");

use BD\Sequence\Sequence;

class StartEpisode {

	private $sequence_id;

	public function __construct() {
		add_action('wp_ajax_start_episode',[$this, 'ajax']);
		add_action('wp_ajax_nopriv_start_episode',[$this,'ajax']);
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

		$this->sequence_id = isset($_POST['sequence_id']) ? sanitize_text_field($_POST['sequence_id']) : false;
	}

	private function _validate()
	{
		$post = get_post($this->sequence_id);

		if(!$post) {
			wp_send_json_error(__('Post not found','onboardingamalia'));
		}
	}

	private function _response()
	{
		$next_sequence = Sequence::get_sequence($this->sequence_id);

		wp_send_json_success($next_sequence);
	}
}

new StartEpisode();