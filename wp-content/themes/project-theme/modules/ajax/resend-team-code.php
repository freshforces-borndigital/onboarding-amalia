<?php

namespace BD\Ajax;

defined("ABSPATH") or exit();

use BD\Team\Team;
use BD\Emails\Email;

class ResendTeamCode extends BD_Ajax_Abstract
{
	protected $action = "resend_team_code";
	protected $fields = [
		"email" => null,
	];
	protected $is_public = true;

	public function response()
	{
		$email = $this->fields["email"];
		if (!$email) {
			return wp_send_json_error(__("Email can't be empty", "asmlanm"));
		}

		$check_team = Team::get_by_email($email);
		if (!$check_team) {
			return wp_send_json_error(
				__("This email has no team", "asmlanm")
			);
		}

		$this->_send_email($check_team, $email);

		wp_send_json_success([
			"team" => $check_team,
			"is_exist" => !!$check_team,
			"message" => __("We've sent you an email with the link and the code to your team page.", "asmlanm")
		]);
	}

	private function _send_email($team, $email)
	{
		$subject = get_field("bd_resend_team_code_subject", "option");
		$body = get_field("bd_resend_team_code_body", "option");

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

new ResendTeamCode();
