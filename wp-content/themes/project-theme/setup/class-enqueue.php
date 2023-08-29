<?php
/**
 * Setting up enqueue
 *
 * @package BornDigital
 */

namespace BD_Theme\Setup;

use BD\Pusher;
use BD\TravelMethod\TravelMethod;
use BD\Team\Team;
use BD\Chart\Chart;

/**
 * Enqueue class to setup assets enqueue
 */
class Enqueue
{
	/**
	 * Setup the flow
	 */
	public function __construct()
	{
		add_action("admin_init", [$this, "editor_enqueue"]);

		add_filter("style_loader_src", [$this, "support_autoversion"]);
		add_filter("script_loader_src", [$this, "support_autoversion"]);

		add_action("login_enqueue_scripts", [$this, "login_enqueue"]);
		add_action("admin_enqueue_scripts", [$this, "admin_enqueue"]);

		add_action("wp_enqueue_scripts", [$this, "theme_styles"]);
		add_action("wp_enqueue_scripts", [$this, "theme_scripts"]);
	}

	/**
	 * Add autoversion support to style & script's "src"
	 *
	 * @param string $src Non-raw url from style/ script enqueue.
	 * @return string
	 */
	public function support_autoversion($src)
	{
		if (strpos($src, "ver=auto")) {
			$src = remove_query_arg("ver", $src);

			if (false === strpos($src, BASE_URL)) {
				return $src;
			}

			$dir = str_replace(BASE_URL, BASE_DIR, $src);

			if (!file_exists($dir)) {
				$last_modifed = "0";
			} else {
				$last_modifed = date("YmdHis", filemtime($dir));
			}

			$src = add_query_arg("ver", $last_modifed, $src);
		}

		return $src;
	}

	/**
	 * Enqueue all styles & scripts to adjust editor's content
	 *
	 * @return void
	 */
	public function editor_enqueue()
	{
		add_editor_style("assets/css/src/wp-editor.min.css");
	}

	/**
	 * Enqueue all styles and scripts to enhance login screen
	 *
	 * @return void
	 */
	public function login_enqueue()
	{
		wp_enqueue_style("style", THEME_URL . "/assets/css/dist/wp-login.min.css", [], "auto");

		wp_enqueue_script("loginjs", THEME_URL . "/assets/js/dist/wp-login.min.js", ["jquery"], "auto", true);
	}

	/**
	 * Enqueue all styles and scripts to custom admin style and behaviour
	 *
	 * @return void
	 */
	public function admin_enqueue()
	{
		wp_enqueue_script("bd-admin-js", THEME_URL . "/assets/js/dist/wp-admin.min.js", [], "auto", true);

        wp_localize_script("bd-admin-js", "ADMINOBJ", [
            "ajaxUrl" => admin_url("admin-ajax.php"),
            "nonce" => wp_create_nonce(BD_SECURE_KEY),
            "ajx"     => array(
                "importTravelMix" => "import_travel_mix",
            ),
        ]);
	}

	/**
	 * Enqueue all style that must included to make theme work
	 *
	 * @return void
	 */
	public function theme_styles()
	{
		wp_enqueue_style("style", THEME_URL . "/assets/css/dist/themes.min.css", [], "auto");
	}

	/**
	 * Enqueue all scripts that must included to make theme work
	 *
	 * @return void
	 */
	public function theme_scripts()
	{
		wp_enqueue_script("bd-vendor-js", THEME_URL . "/assets/js/dist/vendors.min.js", [], "auto", true);

		wp_enqueue_script("bd-theme-js", THEME_URL . "/assets/js/dist/themes.min.js", [], "auto", true);

		$error_messages = [
			"teamNameEmpty" => __("Team name can't be empty", "asmlanm"),
			"emailEmpty" => __("Email can't be empty", "asmlanm"),
			"emailInvalid" => __("Email is not valid", "asmlanm"),
			"teamCodeEmpty" => __("Team code can't be empty", "asmlanm"),
			"teamNotFoundByCode" => __("Team with this code is not found", "asmlanm"),
			"failedSubmitData" => __("Failed to submit the data, please try again", "asmlanm"),
		];

		$CFG = [
			"ajaxUrl" => admin_url("admin-ajax.php"),
			"themeUrl" => THEME_URL,
			"errorMessages" => $error_messages,
			"nonce" => wp_create_nonce(BD_SECURE_KEY),
		];

		$team_id_query_var = get_query_var("team_unique_link");
        $pagename = get_query_var('pagename');

		if(!empty($team_id_query_var) and $pagename === "chart"){
			$team = Team::get_by_unique_link($team_id_query_var);

			$travel_methods = TravelMethod::get_all();
			$chart = Team::get_chart($team);
			$global_chart = Chart::global_chart();

			$CFG['travelMethods'] 	= $travel_methods;
			$CFG['leftChart'] 		= $chart;
			$CFG['rightChart'] 		= $global_chart;
		}

		wp_localize_script("bd-theme-js", "THEMEOBJ", $CFG );

		if (is_singular() && comments_open() && get_option("thread_comments")) {
			wp_enqueue_script("comment-reply");
		}
	}
}

new Enqueue();
