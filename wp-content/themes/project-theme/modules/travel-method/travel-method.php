<?php

namespace BD\TravelMethod;

class TravelMethod
{
	public static function get_all()
	{
		$args = [
			"post_type" => "travel_method",
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
		if (!$post || $post->post_type !== "travel_method") {
			return null;
		}

		return [
			"id" => $post->ID,
			"name" => $post->post_title,
			"icon" => get_field("icon", $post),
			"icon_dark" => get_field("icon_dark", $post),
			"color" => get_field("color", $post),
		];
	}

    public static function get_category_number($year = null)
    {
        $current_year = date("Y");
        $from_year = is_null($year) ? $current_year : $year;

        $number_each_cat = get_field("number_of_each_category", "option");

        $year_descriptions = get_field("setup_each_year", "option");

        $each_each_year = array(
            'year' => $from_year,
            'title' => null,
            'description' => null,
            'total_commuting_number' => 0,
            'total_not_commuting_number' => 0
        );

        $get_year = function ($desc) use ($from_year) {
            return $desc["year"] == $from_year;
        };

        if ($year_descriptions != false) {
            $get_year_data = array_filter($year_descriptions, $get_year);
            $each_each_year = array_shift($get_year_data);
        }

        $travel_methods = array();
        foreach ($number_each_cat as $item) {
            $icon = get_field("icon", $item['travel_method']);
            $color = get_field("color", $item['travel_method']);
            $current_number = 0;
            $target_number = 0;

            foreach ($item['amount_of_people'] as $amount) {
                if ($amount['year'] == $from_year) {
                    $current_number = number_format($amount['current_number'] == "" ? 0 : $amount['current_number']);
                    $target_number = number_format($amount['target_number'] == "" ? 0 : $amount['target_number']);
                }
            }

            $travel_methods[] = array(
                'id' => $item['travel_method']->ID,
                'icon' => $icon,
                'color' => $color,
                'current_number' => $current_number,
                'target_number' => $target_number,
                'warning_txt' => $item['warning_indicator'],
            );
        }

        return array(
            'each_year_setup' => $each_each_year,
            'amount_each_cat' => $travel_methods,
        );
    }


}
