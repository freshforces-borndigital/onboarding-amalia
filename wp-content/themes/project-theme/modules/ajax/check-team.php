<?php

namespace BD\Ajax;

defined("ABSPATH") or exit();

use BD\Team\Team;

class CheckTeam extends BD_Ajax_Abstract
{
	protected $action = "check_team";
	protected $fields = [
		"code" => null,
	];
	protected $is_public = true;

	public function response()
	{
		$code = $this->fields["code"];
		if (!$code) {
			return wp_send_json_error(__("Team code can't be empty", "asmlanm"));
		}

		$team = Team::get_by_code($code);

		wp_send_json_success([
			"team" => $team,
		]);
	}
}

new CheckTeam();
