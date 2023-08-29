<?php

namespace BD\Ajax;

defined("ABSPATH") or exit();

use BD\Team\Team;
use BD\Emails\Email;

class CreateTeam extends BD_Ajax_Abstract
{
	protected $action = "create_team";
	protected $fields = [
		"name" => null,
		"code" => null,
		"email" => null,
	];
	protected $is_public = true;

	public function response()
	{
        $email = $this->fields["email"];
        if (!$email) {
            return wp_send_json_error(__("Email can't be empty", "asmlanm"));
        }

		$code = $this->fields["code"];
		if (!$code) {
			return wp_send_json_error(__("Team code can't be empty", "asmlanm"));
		}

        $name = $this->fields["name"];
        if (!$name) {
            return wp_send_json_error(__("Team name can't be empty", "asmlanm"));
        }

		$is_code_valid = !preg_match('/[^A-Za-z0-9\-$]/', $code);
		if (!$is_code_valid) {
			return wp_send_json_error(__("Team code is not valid, only alphanumeric and dash is allowed", "asmlanm"));
		}

		$check_team = Team::get_by_code($code);
		if ($check_team) {
			return wp_send_json_error(
				__("This team code is already existed, please choose another one", "asmlanm")
			);
		}

		$post_id = Team::create($name, $code, $email);
		$team = Team::get($post_id);
		$is_sent = $this->_send_email($team, $email);

		wp_send_json_success([
			"team" => $team,
			"is_sent" => $is_sent,
		]);
	}

	private function _send_email($team, $email)
	{
		$subject = get_field("bd_create_team_subject", "option");
		$body = get_field("bd_create_team_body", "option");

		$tags = [
			"{team_name}" => $team["name"],
			"{team_code}" => strtoupper($team["code"]),
			"{team_unique_link}" => $team["unique_link_absolute"],
		];

		$subject = Email::set_placeholder($subject, $tags);
		$body = Email::set_placeholder($body, $tags);

		$GLOBALS["freshjet_template_vars"] = [
			"body" => $body,
			"subject" => $subject,
		];

		$is_sent = wp_mail($email, $subject, $body);
		return [$is_sent, $email, $subject, $body];
	}
}

new CreateTeam();
