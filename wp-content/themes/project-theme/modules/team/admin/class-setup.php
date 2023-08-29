<?php
namespace BD\Team\Admin;

use BD\Team\Team;

defined("ABSPATH") or exit();

class Setup
{
    public function __construct()
    {
        add_action("init", [$this, "register_post_type_team"]);
        add_action("admin_enqueue_scripts", [$this, "enqueue_script"]);
        add_filter("manage_team_posts_columns", [$this, "set_custom_edit_team_columns"]);
        add_action("manage_team_posts_custom_column", [$this, "custom_team_column"], 10, 2);
        add_action("acf/save_post", [$this, "on_acf_save_post"]);
    }

    public function register_post_type_team()
    {
        $args = [
            "labels" => [
                "name" => __("Teams", "asmlanm"),
                "singular_name" => __("Team", "asmlanm"),
                "add_new" => __("Add New Team", "asmlanm"),
                "add_new_item" => __("Add New Team", "asmlanm"),
                "edit_item" => __("Edit Team", "asmlanm"),
            ],
            "public" => false,
            "publicly_queriable" => true,
            "show_ui" => true,
            "exclude_from_search" => true,
            "show_in_nav_menus" => true,
            "has_archive" => false,
            "rewrite" => false,
            "supports" => ["title"],
            "menu_icon" => "dashicons-marker",
            "capabilities" => [
                "edit_post" => "manage_options",
                "read_post" => "manage_options",
                "delete_post" => "manage_options",
                "edit_posts" => "manage_options",
                "edit_others_posts" => "manage_options",
                "delete_posts" => "manage_options",
                "publish_posts" => "manage_options",
                "read_private_posts" => "manage_options",
                "create_posts" => "do_not_allow",
            ],
        ];

        register_post_type("team", $args);
    }

    public function enqueue_script($hook_suffix)
    {
        $cpt = "team";
        $prefix_url = THEME_URL . "/modules/team";

        if (in_array($hook_suffix, ["post.php", "post-new.php"])) {
            $screen = get_current_screen();

            if (is_object($screen) && $cpt == $screen->post_type) {
                wp_enqueue_script("bd-admin-team-js", $prefix_url . "/assets/js/script.js", ["jquery"], "auto", true);
                $CFG = [
                    "host" => get_site_url(),
                ];
                wp_localize_script("bd-admin-team-js", "CFG", $CFG);
            }
        }
    }

    public function set_custom_edit_team_columns($columns)
    {
        unset($columns["date"]);
        $columns["code"] = __("Code", "asmlanm");
        $columns["chart_link"] = __("Chart Link", "asmlanm");
        $columns["date"] = __("Date", "asmlanm");

        return $columns;
    }

    public function custom_team_column($column, $post_id)
    {
        switch ($column) {
            case "code":
                echo strtoupper(get_field("code", $post_id));
                break;
            case "chart_link":
                $unique_link = get_field("unique_link", $post_id);
                if ($unique_link) {
                    $link = get_site_url() . "/chart/" . $unique_link;
                    echo '<a href="' . $link . '" target="_BLANK">Link</a>';
                } else {
                    echo "-";
                }
                break;
        }
    }

    function on_acf_save_post($post_id)
    {
        $is_team = Team::get($post_id);
        if (!$is_team) {
            return;
        }

        // Get newly saved values.
        $values = get_fields($post_id);

        // Check the new value of a specific field.
        $code = get_field("code", $post_id);
        if ($code) {
            update_field("code", strtolower($code), $post_id);
        }
    }
}

new Setup();
