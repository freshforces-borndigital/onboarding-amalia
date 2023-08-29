<?php
namespace BD\Chart;

defined("ABSPATH") or exit();

class Chart
{
	public static function global_chart()
	{
		$asml_global_chart = get_field("asml_pie_charts", "option");

		$chart_res = [];
		foreach ($asml_global_chart as $chart) {
			$chart_res[$chart["travel_method"]] = $chart["portion"];
		}

		return $chart_res;
	}

	public static function get_current_week_of_month()
	{
		$week_of_month = function ($date_outer) {
			$week_of_year = function ($date) {
				$week_of_year = intval(date("W", $date));
				if (date("n", $date) == "1" && $week_of_year > 51) {
					// It's the last week of the previos year.
					return 0;
				} elseif (date("n", $date) == "12" && $week_of_year == 1) {
					// It's the first week of the next year.
					return 53;
				} else {
					// It's a "normal" week.
					return $week_of_year;
				}
			};

			//Get the first day of the month.
			$firstOfMonth = strtotime(date("Y-m-01", $date_outer));
			//Apply above formula.
			return $week_of_year($date_outer) - $week_of_year($firstOfMonth) + 1;
		};

		$res = $week_of_month(time());
		return $res;
	}
}
