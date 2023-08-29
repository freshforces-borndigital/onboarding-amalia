<?php

namespace BD\Team;

use BD\Answer\Answer;
use BD\TravelMethod\TravelMethod;

class Team
{
	public static function get_all()
	{
		$args = [
			"post_type" => "team",
			"order" => "ASC",
			"fields" => "ids",
			"numberposts" => -1,
		];

		$posts = get_posts($args);
		$res = [];

		if ($posts) {
			foreach ($posts as $item) {
				$res[] = self::get($item);
			}
		}

		return $res;
	}

	public static function get($id)
	{
		$post = get_post($id);
		if (!$post || $post->post_type !== "team") {
			return null;
		}

		$unique_link = get_field("unique_link", $post);

		return [
			"id" => $post->ID,
			"name" => $post->post_title,
			"code" => get_field("code", $post),
			"unique_link" => $unique_link,
			"unique_link_absolute" => get_site_url() . "/chart/" . $unique_link,
		];
	}

	public static function create($name, $code, $email)
	{
		if (!$name) {
			throw new \Exception(__("Name cannot be blank", "asmlanm"));
		} elseif (!$code) {
			throw new \Exception(__("Code cannot be blank","asmlanm"));
		} elseif (!$email) {
			throw new \Exception(__("Email cannot be blank", "asmlanm"));
		}

		$post_data = [
			"post_title" => $name,
			"post_type" => "team",
			"post_status" => "publish",
		];
		$post_id = wp_insert_post($post_data);

		// $code = self::generate_team_code();
		$code = strtolower($code);
		$email = strtolower($email);
		$unique_link = self::generate_unique_link();
		update_field("code", $code, $post_id);
		update_field("email", $email, $post_id);
		update_field("unique_link", $unique_link, $post_id);
		return $post_id;
	}

	public static function generate_team_code(): string
	{
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ012345689";
		$team_code = "";
		for ($i = 0; $i < 6; $i++) {
			$pos = random_int(0, strlen($chars) - 1);
			$team_code .= substr($chars, $pos, 1);
		}

		$code = strtolower($team_code);

		if (self::is_team_exist_by_code($code)) {
			return self::generate_team_code();
		}

		return $code;
	}

	public static function generate_unique_link(): string
	{
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ012345689";
		$team_code = "";
		for ($i = 0; $i < 12; $i++) {
			$pos = random_int(0, strlen($chars) - 1);
			$team_code .= substr($chars, $pos, 1);
		}

		$code = strtolower($team_code);

		if (self::is_team_exist_by_unique_link($code)) {
			return self::generate_unique_link();
		}

		return $code;
	}

	public static function is_team_exist_by_code($code): bool
	{
		$args = [
			"post_type" => "team",
			"meta_key" => "code",
			"meta_value" => $code,
		];
		$posts = get_posts($args);
		return !!$posts;
	}

	public static function is_team_exist_by_unique_link($code): bool
	{
		$args = [
			"post_type" => "team",
			"meta_key" => "code",
			"meta_value" => $code,
		];
		$posts = get_posts($args);
		return !!$posts;
	}

	public static function get_by_code($code)
	{
		$args = [
			"post_type" => "team",
			"meta_key" => "code",
			"meta_value" => $code,
		];
		$posts = get_posts($args);
		return $posts ? self::get($posts[0]) : null;
	}

	public static function get_by_email($email)
	{
		$args = [
			"post_type" => "team",
			"meta_key" => "email",
			"meta_value" => $email,
			"order" => "DESC",
			"fields" => "ids",
			"numberposts" => -1,
		];
		$posts = get_posts($args);
		return $posts ? self::get($posts[0]) : null;
	}

	public static function get_by_unique_link($unique_link)
	{
		$args = [
			"post_type" => "team",
			"meta_key" => "unique_link",
			"meta_value" => strtolower($unique_link),
		];
		$posts = get_posts($args);
		return $posts ? self::get($posts[0]) : null;
	}

	public static function get_chart($team)
	{
		$answers = Answer::find_by_team_and_current_month($team["id"]);
		
		$answer_travel_methods = [];
		foreach ($answers as $answer) {
			$answer_travel_methods = array_merge($answer_travel_methods, $answer["travel_methods"]);
		}

		// collection of travel method ids with it's total user
		$answer_travel_methods_grouped = array_count_values($answer_travel_methods);

		// Get the travel id for Not on campus data
		$travel_methods = TravelMethod::get_all();
		$index = array_search('Not on campus', array_column($travel_methods, 'name'));
		$travel_method = $travel_methods[$index];

		// pop not on campus data
		$not_on_campus = array_filter($answer_travel_methods, function($ids) use ($travel_method) { 
			return $ids === $travel_method['id'];
		});

		$not_on_campus = is_array($not_on_campus) ? $not_on_campus : array();

		// the total of all the user minus the total of not on campus user
		$total = count($answer_travel_methods) - count($not_on_campus);

		// refactor data with it's portion of percentage
		$res_travel_methods = [];
		foreach ($answer_travel_methods_grouped as $travel_method_id => $count) {
			if($travel_method_id === $travel_method['id']){
				$with_not_on_campus_total = $total + count($not_on_campus);
				$res_travel_methods[$travel_method_id] = ($count/$with_not_on_campus_total)*100;
			}else{
				$res_travel_methods[$travel_method_id] = ($count/$total)*100;
			}
		}

		return $res_travel_methods;
	}
}
