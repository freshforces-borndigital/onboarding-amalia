<?php
namespace BD\UserProfile;

use BD\Team\Team;

defined("ABSPATH") or exit();

class UserProfile
{
	// UserProfile::get_user_team(1)
	public static function get_user_team($user_id)
	{
		$team_id = get_field("team", "user_" . $user_id);
		if (!$team_id) {
			return null;
		}

		return Team::get($team_id);
	}

	// UserProfile::update_user_team(1, 2)
	public static function update_user_team($user_id, $team_id)
	{
		update_field("team", $team_id, "user_" . $user_id);
	}

	public static function get($user_id)
	{
		$user = get_user_by("id", $user_id);
		if (!$user) {
			return null;
		}

		return [
			"id" => $user->ID,
			"team_id" => get_field("team", "user_" . $user_id),
		];
	}
}
