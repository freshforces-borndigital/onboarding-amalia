<?php
namespace BD\DataVisualisation\Admin;

defined("ABSPATH") || die("Can't access directly");

class Setup
{
    public function __construct()
    {
        add_action("acf/init", [$this, "add_data_visualisation_page"], 10);
        add_filter("acf/load_field/name=total_commuting_number", [$this, "set_attr_total_commuting"]);
        add_filter("acf/load_value/name=setup_each_year", [$this, "set_values_total_commuting"], 10, 3);
    }

    public function add_data_visualisation_page()
    {
        if (!function_exists("acf_add_options_page")) {
            return;
        }

        acf_add_options_page([
            "page_title" => __("Data Visualisation", "asmlanm"),
            "menu_title" => __("Data Visualisation", "asmlanm"),
            "menu_slug" => "bd-data-visualisation",
            "capability" => "manage_options",
            "icon_url" => "dashicons-marker",
            "position" => 51,
        ]);
    }

    public function set_attr_total_commuting($field)
    {
        if(!function_exists("get_current_screen")) return $field;

        $screen = get_current_screen();

        if (empty($screen)) return $field;

        if ($screen
            && ($screen->id == "acf_field_group"
                || $screen->id == "custom-field_page_acf-tools")) {
            return $field;
        }

        $field['readonly'] = 1;

        return $field;
    }

    public function set_values_total_commuting($value, $post_id, $field)
    {
        if ($value == false) return $value;

        $number_per_cat = get_field('number_of_each_category', 'option');

        $total_per_cat = array();
        foreach ($number_per_cat as $item) {
            foreach ($item['amount_of_people'] as $amount) {
                $the_year = $amount['year'];
                if (array_key_exists($the_year, $total_per_cat)) {
                    $total_per_cat[$the_year] = $total_per_cat[$the_year] + (int) $amount['current_number'];
                } else {
                    $total_per_cat[$the_year] = (int) $amount['current_number'];
                }
            }
        }

        foreach ($value as $key => $setup) {
            $total_number_per_year = $total_per_cat[$setup['field_6319b11e66e21']]; // can't access field name, so it's using field key

            $value[$key]['field_6319b2ba6112f'] = $total_number_per_year;
        }

        return $value;
    }
}

new Setup();