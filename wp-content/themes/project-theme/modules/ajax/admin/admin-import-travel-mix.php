<?php

namespace BD\Ajax;

defined("ABSPATH") || die("Can't access directly");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ImportTravelMix extends BD_Ajax_Abstract
{
    protected $action = "import_travel_mix";
    protected $fields = array(
        "import_file" => false,
    );

    public function response()
    {
        $file = $_FILES["import_file"];
        $path_info = pathinfo($file["name"]);
        $file_ext = $path_info["extension"];

        if (!isset($file)) {
            $this->throw_error(__("File can not be empty.", "asmlanm"));
        }

        $file_exts = ["xls", "xlsx"];

        if (!in_array($file_ext, $file_exts)) {
            $this->throw_error(__("File extension is not supported.", "asmlanm"));
        }

        $reader = new Xlsx();
        $spreadsheet = $reader->load($file['tmp_name']);
        $get_import_sheet = $spreadsheet->getSheetByName('Import');

        if (is_null($get_import_sheet)) {
            $this->throw_error(__("Import sheet not found. Please check again.", "asmlanm"));
        }

        $sheetData = $get_import_sheet->rangeToArray('A1:F5', null, true, true, false);

        $number_per_cat = array();
        $travel_methods = array_filter($sheetData[0]);
        $category_numbers = $sheetData[1];
        $get_week_number = array_filter($sheetData[4]);
        $weeknumber = array_shift($get_week_number);

        foreach ($travel_methods as $key => $method) {
            $travel_method_post = get_page_by_title($method, OBJECT, 'travel_method');

            if (is_null($travel_method_post)) {
                $this->throw_error(sprintf(__('Travel method "%s" is not found. Please check again.', 'asmlanm'), $method));
            }

            $travel_method_ID = $travel_method_post->ID;
            $number_per_cat[$travel_method_ID] = (float) $category_numbers[$key];
        }

        $total_number_all_cats = array_sum(array_values($number_per_cat));

        $calculate_percentage = function ($number, $total) {
            return round(($number / $total) * 100);
        };

        if (!is_int($weeknumber)) $weeknumber = $get_week_number[0];

        update_field("weekly_number", $weeknumber, "option");

        if (have_rows("asml_pie_charts", "option")) {
            while (have_rows("asml_pie_charts", "option")) {
                $row = the_row();
                $categoryID = $row['field_625e57b83bc07'];
                $new_actual_number = $number_per_cat[$categoryID];
                $new_portion = $calculate_percentage($new_actual_number, $total_number_all_cats);

                update_sub_field("actual_number", $new_actual_number);
                update_sub_field("portion", $new_portion);
            }
        }

        wp_send_json_success(__("Successfully import travel mix number.", "asmlanm"));
    }
}

new ImportTravelMix();