<?php
/**
 * Setting up theme options
 *
 * @package BornDigital
 */

namespace BD_Theme\Setup;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Options class to setup theme options
 */
class Options {
	/**
	 * Setup the flow
	 */
	public function __construct() {
		add_action( 'acf/init', [ $this, 'add_theme_option' ], 10 );
	}

	/**
	 * This function to create theme option menu under themas
	 */
	public function add_theme_option() {

		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		acf_add_options_page(
			array(
				'page_title'  => __( 'Theme Settings', 'asmlanm' ),
				'menu_title'  => __( 'Theme Settings', 'asmlanm' ),
				'parent_slug' => 'themes.php',
				'menu_slug'   => 'theme-settings',
				'capability'  => 'manage_options',
			)
		);
		
		acf_add_options_page(
			array(
				'page_title'  => __( 'Server Setting', 'asmlanm' ),
				'menu_title'  => __( 'Server Setting', 'asmlanm' ),
				'parent_slug' => 'options-general.php',
				'menu_slug'   => 'bd-server-page',
				'capability'  => 'manage_options',
			)
		);

	}

}

new Options();
