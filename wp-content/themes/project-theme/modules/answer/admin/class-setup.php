<?php
namespace BD\Answer\Admin;

defined("ABSPATH") or exit();

class Setup
{
    public function __construct()
    {
        add_action("init", [$this, "register_post_type_answer"]);
    }

    public function register_post_type_answer()
    {
        $args = [
            "labels" => [
                "name" => __("Answers", "asmlanm"),
                "singular_name" => __("Answer", "asmlanm"),
                "add_new" => __("Add New Answer", "asmlanm"),
                "add_new_item" => __("Add New Answer", "asmlanm"),
                "edit_item" => __("Edit Answer", "asmlanm"),
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

        register_post_type("answer", $args);
    }
}

new Setup();
