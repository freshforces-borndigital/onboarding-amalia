<?php

/**
 * Setting up theme options
 *
 * @package BornDigital
 */

namespace BD\Pusher\Admin;

use BD\Pusher;

defined('ABSPATH') || die("Can't access directly");

/**
 * Options class to setup theme options
 */
class Setup
{
    /**
     * Setup the flow
     */
    public function __construct()
    {
        add_action('acf/init', [$this, 'add_option_page'], 10);
        add_action('init', [$this, 'rewrite_rule_webhook']);
        add_action('template_redirect', [$this, 'page_controller_webhook']);
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_pusher_js'], 0);
    }

    /**
     * This function to create theme option menu under themas
     */
    public function add_option_page()
    {

        if (!function_exists('acf_add_options_page')) {
            return;
        }

        acf_add_options_page([
            'page_title'  => 'Pusher',
            'menu_title'  => 'Pusher',
            'menu_slug'   => 'pusher-settings',
            'parent_slug' => 'options-general.php',
            'capability'  => 'manage_options',
        ]);
    }

    public function rewrite_rule_webhook()
    {
        add_rewrite_rule('^webhook/?', 'index.php?pagename=bd-webhook', 'top');
    }

    public function page_controller_webhook()
    {
        global $wp_query, $wpdb;

        $pagename = get_query_var('pagename');
        if ($pagename !== 'bd-webhook') {
            return;
        }

        $wp_query->is_404 = false;

        $app_secret = Pusher::get_secret();

        $app_key = @$_SERVER['HTTP_X_PUSHER_KEY'];
        $webhook_signature = @$_SERVER['HTTP_X_PUSHER_SIGNATURE'];

        $body = @file_get_contents('php://input');

        $expected_signature = hash_hmac('sha256', $body, $app_secret, false);

        if ($webhook_signature == $expected_signature) {
            // decode as associative array
            $payload = json_decode($body, true);

            status_header(200);
        } else {
            status_header(401);
        }

        exit();
    }

    public function enqueue_pusher_js(){
        wp_enqueue_script(
            'pusher',
            THEME_URL . '/modules/pusher/assets/js/pusher.min.js',
            [ 'jquery' ],
            'auto',
            true
        );
    }
}

new Setup();