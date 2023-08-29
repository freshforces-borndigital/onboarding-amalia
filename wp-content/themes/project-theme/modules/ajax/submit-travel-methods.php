<?php

namespace BD\Ajax;

defined("ABSPATH") or exit();

use BD\Team\Team;
use BD\Answer\Answer;

class SubmitTravelMethods extends BD_Ajax_Abstract
{
	protected $action = "submit_travel_methods";
	protected $fields = [
		"code" => null,
		"travel_methods" => null,
	];
	protected $is_public = true;

	public function response()
	{
		$code = $this->fields["code"];
		$travel_methods = explode(",", $this->fields["travel_methods"]);
		if (!$code) {
			return wp_send_json_error(__("Team code can't be empty", "asmlanm"));
		}

		if (count($travel_methods) !== 5) {
			return wp_send_json_error(__("Data is not complete", "asmlanm"));
		}

		$team = Team::get_by_code($code);
		if (!$team) {
			return wp_send_json_error(__("Team not found", "asmlanm"));
		}

		$user_id = -1; // anonymous
		// $user_id = get_current_user_id();
		$res = Answer::create($travel_methods, $user_id, $team["id"]);

       /* $pusher = \BD_Helper::get_pusher();
        $events = array(
            array(
         		'channel' => 'chart-update',
         		'name'    => 'client-trigger-chart',
         		'data'    => array(
                    'teamChart' => Team::get_chart($team),
         		),
         	),
        );

        $pusher->triggerBatch($events);*/

		wp_send_json_success([
			"team" => $team,
			"answer" => $res,
		]);
	}
}

new SubmitTravelMethods();
