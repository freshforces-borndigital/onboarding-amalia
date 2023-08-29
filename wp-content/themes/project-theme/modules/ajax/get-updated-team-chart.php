<?php

namespace BD\Ajax;

use BD\Team\Team;

defined("ABSPATH") || die("Can't access file directly");

class GetUpdatedTeamChart extends BD_Ajax_Abstract
{
    protected $action = "get_updated_team_chart";
    protected $fields = array(
        "team_unique_link" => null
    );
    protected $is_public = true;

    public function response()
    {
        $unique_link = $this->fields["team_unique_link"];

        if (is_null($unique_link)) {
            wp_send_json_error(__("Unique link is null, please check again.", "asmlanm"));
        }

        $team = Team::get_by_unique_link($unique_link);
        $team_chart = Team::get_chart($team);

        wp_send_json_success($team_chart);
    }
}

new GetUpdatedTeamChart();