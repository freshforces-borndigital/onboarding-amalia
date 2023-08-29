<?php
/**
 * Restrict some pages
 *
 * @package BornDigital
 */

namespace BD\Access;

/**
 * Setup class to restrict some pages
 */
class Setup {
	/**
	 * Setup the flow
	 */
	public function __construct() {
		add_action( 'wp', [ $this, 'restrict_guest' ] );
		add_action( 'wp', [ $this, 'restrict_users' ] );
	}

	/**
	 * This restriction is only for
	 * - Guest user
	 *
	 * Allowed pages
	 * - Landing page
	 * - Privacy page
	 *
	 * @return void
	 */
	public function restrict_guest() {
		// if user is logged-in, then return.
		if ( is_user_logged_in() ) {
			return;
		}

		global $wp;

		// write your restriction rule here.
        $pagename = get_query_var('pagename');

		$login = home_url('/login');

        if ($pagename == 'datavisualisation') {
            $msg = sprintf( __("Sorry, you can't access this page. Please login <a href='%s'>here</a>", "asmlanm"), $login);
            wp_die($msg);
        }
	}

	/**
	 * This restriction is only for
	 * - Logged-in user
	 *
	 * @return void
	 */
	public function restrict_users() {
		// if user is not logged-in, then return.
		if ( ! is_user_logged_in() ) {
			return;
		}

		// write your restriction rule here.
	}

}

new Setup();
