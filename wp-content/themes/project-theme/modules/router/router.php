<?php

namespace BD\Router;

defined("ABSPATH") or die('Can\'t access directly');

class Router
{
    public function __construct()
    {
        add_action("init", [$this, "rewrite_rule"]);
        add_action("template_redirect", [$this, "page_controller"]);
        add_filter("query_vars", [$this, "whitelist_query_vars"]);
    }

    public function whitelist_query_vars($query_vars)
    {
        $query_vars[] = "team_unique_link";
        return $query_vars;
    }

    public function rewrite_rule()
    {
        add_rewrite_rule("^chart/([a-z0-9-]+)[/]?$", 'index.php?pagename=chart&team_unique_link=$matches[1]', "top");
        add_rewrite_rule(
            "^submission/([a-z0-9-]+)[/]?$",
            'index.php?pagename=submission&team_unique_link=$matches[1]',
            "top"
        );
        add_rewrite_rule(
            "^datavisualisation",
            'index.php?pagename=datavisualisation',
            "top"
        );
    }

    public function page_controller()
    {
        global $wp_query;
        $pagename = get_query_var("pagename");

        if ($pagename == "chart") {
            $this->_print_chart();
        } elseif ($pagename == "submission") {
            $this->_print_submission();
        } elseif ($pagename == "datavisualisation") {
            $this->_print_visualization();
        } else {
            $this->_fallback();
        }
    }

    private function _print_chart()
    {
        status_header(200);
        add_filter(
            "wp_title",
            function () {
                return "Dashboard";
            },
            99,
            3
        );
        // add_filter("body_class", [$this, "body_class_faq"], 99, 2);
        load_template(THEME_DIR . "/templates/chart.php", true);
        exit();
    }

    private function _print_submission()
    {
        status_header(200);
        add_filter(
            "wp_title",
            function () {
                return "Submission";
            },
            99,
            3
        );
        // add_filter("body_class", [$this, "body_class_faq"], 99, 2);
        load_template(THEME_DIR . "/templates/submission.php", true);
        exit();
    }

    private function _print_visualization()
    {
        status_header(200);
        add_filter(
            "wp_title",
            function () {
                return "Data Visualization";
            },
            99,
            3
        );
        // add_filter("body_class", [$this, "body_class_faq"], 99, 2);
        load_template(THEME_DIR . "/templates/visual.php", true);
        exit();
    }

    private function _fallback()
    {
    }
}

new Router();
