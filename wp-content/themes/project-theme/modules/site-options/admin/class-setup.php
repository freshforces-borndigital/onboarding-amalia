<?php
namespace BD\SiteOptions\Admin;

defined("ABSPATH") or exit();

class Setup
{
	public function __construct()
	{
		add_action("acf/init", [$this, "add_option_page"], 10);
        add_action('admin_menu', [$this, 'register_page']);
        add_action('admin_enqueue_scripts', [$this, 'site_options_scripts']);
	}

	public function add_option_page()
	{
		if (!function_exists("acf_add_options_page")) {
			return;
		}

		acf_add_options_page([
			"page_title" => __("Site Options", "asmlanm"),
			"menu_title" => __("Site Options", "asmlanm"),
			"menu_slug" => "bd-site-options",
			"capability" => "manage_options",
			"icon_url" => "dashicons-marker",
			"position" => 50,
		]);
	}

    public function register_page()
    {
        // register import travel mix menu
        add_menu_page(
            __('Import Travel Mix', 'asmlanm'),
            __('Import Travel Mix', 'asmlanm'),
            'manage_options',
            'import-travel-mix',
            [$this, 'import_travel_mix_page'],
            'dashicons-upload',
            52
        );
    }

    public function import_travel_mix_page()
    {
        ?>
        <style>
            .description{
                font-style: italic;
            }
        </style>
        <template id="notice">
            <div id="message" class="notice is-dismissible">
                <p class="txt-msg"></p>
                <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'asmlanm' ); ?></span></button>
            </div>
        </template>
        <div class="wrap import-users">
            <h2><?php esc_html_e( 'Import Travel Mix', 'asmlanm' ); ?></h2>
            <div class="metabox-holder">
                <div class="info"></div>
                <div id="poststuff">
                    <form id="import-travel-mix">
                        <table class="form-table">
                            <tbody>
                            <tr class="form-field">
                                <th scope="import_file">
                                    <label for="import_file"><?= __('File', 'asmlanm') ?></label>
                                </th>
                                <td>
                                    <input name="import_file" type="file" id="import_file" required>
                                    <p class="description"><strong><?php _e('Note', 'asmlanm'); ?> : </strong></p>
                                    <p class="description">
                                        <a href=" <?= THEME_URL . '/assets/templates/Import Travel Mix Template.xlsx' ?> " download> <?= __('Click here to get the import template', 'asmlanm')?></a>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="button button-primary" id="import-travel-btn"><?= __('Import', 'asmlanm') ?></button>
                        <span class="loading" style="display: none"><?= __('Loading', 'asmlanm') ?> .....</span>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    public function site_options_scripts()
    {
        $screen = get_current_screen();

        if ($screen->id === 'toplevel_page_bd-site-options') {
            wp_enqueue_script(
                'bd-site-options-js',
                MODULES_URL . '/site-options/admin/assets/admin-site-options.js',
                ['jquery'],
                'auto',
                true,
            );
        }

        if ($screen->id === 'toplevel_page_import-travel-mix') {
            wp_enqueue_script(
                'bd-site-options-js',
                MODULES_URL . '/site-options/admin/assets/admin-import-travel-mix.js',
                ['jquery'],
                'auto',
                true,
            );
        }
    }
}

new Setup();
