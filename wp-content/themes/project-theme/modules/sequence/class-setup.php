<?php 

namespace BD\Sequence;

defined ('ABSPATH') || die("Can't access directly");

class Setup {
    public function __construct() {
		add_action('init',[$this,'register_post_type_episode']);
		add_action('init',[$this,'register_post_type_character']);
        add_action('init',[$this,'register_post_type_sequence']);
        // add_action('acf/init',[$this,'add_sequence_setting']);
    }

	public function register_post_type_episode() {
		$args = [
			'labels'            => [
				'name'          => __('Episodes', 'onboardingamalia'),
				'singular_name' => __('Episode', 'onboardingamalia'),
				'add_new'       => __('Add New episode', 'onboardingamalia'),
				'add_new_item'  => __('Add New episode', 'onboardingamalia'),
				'edit_item'     => __('Edit episode', 'onboardingamalia'),
			],
			'public'              => false,
			'publicly_queriable'  => true,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => ['title'],
			'menu_icon'           => 'dashicons-marker',
		];
		register_post_type('episode' , $args);
	}

	public function register_post_type_character() {
		$args = [
			'labels'            => [
				'name'          => __('Characters', 'onboardingamalia'),
				'singular_name' => __('Character', 'onboardingamalia'),
				'add_new'       => __('Add New character', 'onboardingamalia'),
				'add_new_item'  => __('Add New character', 'onboardingamalia'),
				'edit_item'     => __('Edit character', 'onboardingamalia'),
			],
			'public'              => false,
			'publicly_queriable'  => true,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => ['title'],
			'menu_icon'           => 'dashicons-marker',
		];
		register_post_type('character' , $args);
	}

    public function register_post_type_sequence() {
        $args = [
			'labels'            => [
				'name'          => __('Sequences', 'onboardingamalia'),
				'singular_name' => __('Sequence', 'onboardingamalia'),
				'add_new'       => __('Add New Sequence', 'onboardingamalia'),
				'add_new_item'  => __('Add New Sequence', 'onboardingamalia'),
				'edit_item'     => __('Edit Sequence', 'onboardingamalia'),
			],
			'public'              => false,
			'publicly_queriable'  => true,
			'show_ui'             => true,
			'exclude_from_search' => true,
			'show_in_nav_menus'   => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'supports'            => ['title'],
			'menu_icon'           => 'dashicons-marker',
		];
        register_post_type('sequence' , $args);
    }


    public function add_sequence_setting()
	{
		acf_add_options_page(
			array(
				'page_title'  => __( 'Sequence', 'onboardingamalia' ),
				'menu_title'  => __( 'Sequence', 'onboardingamalia' ),
				'parent_slug' => 'themes.php',
				'menu_slug'   => 'bd-sequence',
				'capability'  => 'manage_options',
			)
		);
    }
}

new Setup();
