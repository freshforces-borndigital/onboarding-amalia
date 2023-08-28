<?php

namespace BD\Ajax;

use BD\TravelMethod\TravelMethod;

defined("ABSPATH") || die("Can't open directly");

class GetTargetNumber extends BD_Ajax_Abstract
{
    protected $action = "get_target_number";
    protected $fields = array(
        "year" => null,
    );
    protected $is_public = true;

    public function response()
    {
        $year = $this->fields["year"];
        if (!$year) {
            wp_send_json_error(__("Year can't be empty", "asmlanm"));
        }

        $get_data = TravelMethod::get_category_number($year);

        wp_send_json_success($get_data);
    }
}

new GetTargetNumber();