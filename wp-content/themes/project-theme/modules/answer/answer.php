<?php
namespace BD\Answer;

use BD\Team\Team;
use BD\TravelMethod\TravelMethod;
use BD\UserProfile\UserProfile;

defined("ABSPATH") or exit();

class Answer
{
	// Answer::create([1, 2, 1, 1, 1], 2)
	public static function create($travel_method_ids = null, $user_id = null, $team_id = null)
	{
		$validate = function () use ($travel_method_ids, $user_id, $team_id) {
			if (!$travel_method_ids || !$user_id || !$team_id) {
				return __("Args cannot be blank", "asmlanm");
			}

			if (!is_array($travel_method_ids)) {
				return __("Travel method must be an array", "asmlanm");
			}

			if (count($travel_method_ids) !== 5) {
				return __("Travel method must have length of 5","asmlanm");
			}

			foreach ($travel_method_ids as $travel_method_id) {
				$travel_method = TravelMethod::get($travel_method_id);
				if (!$travel_method) {
					return sprintf(__("Travel method not found for id %s", "asmlanm"), $travel_method_id);
				}
			}

			/*
			$user_profile = UserProfile::get($user_id);
			if (!$user_profile) {
				return "User not found";
			}
			*/

			$team = Team::get($team_id);
			if (!$team) {
				return __("Team not found", "asmlanm");
			}

			return null;
		};

		$error = $validate();
		if ($error) {
			return [
				"status" => "error",
				"msg" => $error,
			];
		}

		// $user_profile = UserProfile::get($user_id);
		$post_title = "team-" . $team_id . "-created-at-" . time();

		$post_data = [
			"post_title" => $post_title,
			"post_type" => "answer",
			"post_status" => "publish",
		];
		$post_id = wp_insert_post($post_data);

		$counter = 1;
		foreach ($travel_method_ids as $travel_method_id) {
			update_field("travel_method_day_" . $counter, $travel_method_id, $post_id);
			$counter++;
		}

		update_field("team", $team_id, $post_id);
		// update_field("user", $user_id, $post_id);

		return [
			"status" => "success",
			"data" => $post_id,
		];
	}

	public static function get($id)
	{
		$post = get_post($id);
		if (!$post || $post->post_type !== "answer") {
			return null;
		}

		$travel_method_day_1 = get_field("travel_method_day_1", $post);
		$travel_method_day_2 = get_field("travel_method_day_2", $post);
		$travel_method_day_3 = get_field("travel_method_day_3", $post);
		$travel_method_day_4 = get_field("travel_method_day_4", $post);
		$travel_method_day_5 = get_field("travel_method_day_5", $post);

		return [
			"id" => $post->ID,
			"team" => get_field("team", $post),
			"user" => get_field("user", $post),
			"created_at" => $post->post_date,
			"travel_method_day_1" => $travel_method_day_1,
			"travel_method_day_2" => $travel_method_day_2,
			"travel_method_day_3" => $travel_method_day_3,
			"travel_method_day_4" => $travel_method_day_4,
			"travel_method_day_5" => $travel_method_day_5,
			"travel_methods" => [
				$travel_method_day_1,
				$travel_method_day_2,
				$travel_method_day_3,
				$travel_method_day_4,
				$travel_method_day_5,
			],
		];
	}

	// Answer::update_user_team(1, 2)
	public static function update_user_team($user_id, $team_id)
	{
		update_field("team", $team_id, "user_" . $user_id);
	}

	// Answer::find_by_team_and_current_month(1)
	public static function find_by_team_and_current_month($team_id)
	{
		$args = [
			"post_type" => "answer",
			"meta_key" => "team",
			"meta_value" => $team_id,
			"date_query" => [
				[
					"after" => "-30 days",
					"inclusive" => true,
				],
			],
			"numberposts" => -1
		];
		$posts = get_posts($args);

		$res = [];
		foreach ($posts as $post) {
			$res[] = self::get($post);
		}
		return $res;
	}

	/**
 	 * Remove user travel data from 2 months before
	 * Task executed by cron job
 	 *
 	 * @return void
 	 */
	public static function cron_delete_old_answer()
	{
		$date = self::get_date_calculation('-', 2); // @param string . int month

		$args = array(
			'fields'          	=> 'ids',
			'post_type' 		=> 'answer',
			'order'          	=> 'DESC',
			'post_status' 		=> 'publish',
			'posts_per_page' 	=> -1,
			'suppress_filters' 	=> false,
			'date_query' => array(
				array(
					'before'    => array(
						'year'  => $date['year'],
						'month' => $date['month'],
						'day'   => $date['day'],
					),
					'inclusive' => true,
				),
			),
		);

		$answers_post = get_posts($args);

		if(is_array($answers_post)){
			foreach($answers_post as $id){
				wp_delete_post($id, false);
			}
		}
	}

	/**
 	 * Get the year, mont, and date from few monts ago/few month ahead
 	 *
	 * @param string $aritmethic || -, +
 	 * @param int $number
	 * 
 	 * @return array
 	 */
	public static function get_date_calculation($aritmethic = '-', $number = 0)
	{
		$the_number = $aritmethic . $number;
		$artmt = sprintf("%s months", $the_number);

		$today = date("Y-m-d", strtotime($artmt));
		
		return array(
			'day' 	=> date('d', strtotime($today)),
			'month' => date('m', strtotime($today)),
			'year' 	=> date('Y', strtotime($today)),
		);
	}
}

/*add_action("init", function () {
	if (isset($_GET["ff"])) {
		var_dump(Answer::create([22, 22, 22, 22, 14], 1));
		die();
	}
});*/
