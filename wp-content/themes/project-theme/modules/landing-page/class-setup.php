<?php

namespace BD\LandingPage;

defined ('ABSPATH') || die("Can't access directly");

class Setup {
	public function __construct() {
		 add_action('acf/init',[$this,'add_landing_page_setting']);
	}

	public function add_landing_page_setting()
	{
		acf_add_options_page(
			array(
				'page_title'  => __( 'Landing page', 'onboardingamalia' ),
				'menu_title'  => __( 'Landing page', 'onboardingamalia' ),
				'parent_slug' => 'themes.php',
				'menu_slug'   => 'bd-landing-page',
				'capability'  => 'manage_options',
			)
		);
	}
}

new Setup();
