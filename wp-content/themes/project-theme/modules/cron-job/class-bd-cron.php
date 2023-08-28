<?php
namespace BD\Cron;

use BD\Answer\Answer;

defined("ABSPATH") or exit();

class BD_Cron
{
	public function __construct() {
		add_filter('cron_schedules', [$this, 'cron_time_intervals'], 1);
		add_action( 'wp',  [$this, 'cron_scheduler'] );


		// cron events
		add_action( 'bd_remove_user_travel_data', [ $this, 'remove_user_travel_data' ] );
	}

	public function cron_time_intervals($schedules)
	{
		$schedules['every_day'] = array(
			'interval' => 60 * 60 * 12 * 2, // second for one day 24H
			'display' => 'Once daily'
		);
		
		return $schedules;
	}

	function cron_scheduler()
	{
		$the_time = strtotime('today 00:01');

		if ( ! wp_next_scheduled( 'bd_remove_user_travel_data' ) ) {
			wp_schedule_event( Date($the_time) , 'every_day', 'bd_remove_user_travel_data');
		}
	}

	/**
 	 * Remove user travel data from 2 months before
 	 *
 	 * @return void
 	 */
	function remove_user_travel_data()
	{
		try {
			Answer::cron_delete_old_answer();
		} catch (\Throwable $th) {
			$msg = 'failed to execute the task!. ' . $th;

			printf($msg);
		}
	}
}

new BD_Cron();
