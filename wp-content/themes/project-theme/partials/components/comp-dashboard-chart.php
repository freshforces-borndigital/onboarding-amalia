<?php
defined("ABSPATH") || die("Can't access directly");

use BD\Team\Team;
use BD\Chart\Chart;

 $team_unique_link = get_query_var("team_unique_link");
 $team = Team::get_by_unique_link($team_unique_link);
 $team_chart = Team::get_chart($team);
 $weekly_number = get_field("weekly_number", "option");
?>

<div class="dashboard__charts">
    <div class="dashboard__col">
        <div class="dashboard__col--inner is-canvas">
                <div class="campusChart">
                    <canvas id="leftCampusChart"></canvas>
                    <span class="category"><?= __("Not on Campus","asmlanm")?></span>
                </div>
                <canvas id="teamChart"></canvas>
            <div class="dashboard__chartLabel">
                <span><?= __("Team", "asmlanm") ?></span>
                <h4 class="js-team" data-unique-link="<?= $team_unique_link ?>"><?= $team["name"] ?></h4>
                <span><?= __("Week", "asmlanm") ?></span>
            </div>
        </div>
    </div>
    <div class="dashboard__col">
        <div class="dashboard__col--inner is-canvas">
            <canvas id="asmlChart"></canvas>
            <!-- <div class="campusChart">
                <canvas id="rightCampusChart"></canvas>
                <span class="category"><?= __("Not on Campus","asmlanm")?></span>
            </div> -->
            <div class="dashboard__chartLabel">
                <span>&nbsp;</span>
                <h4><?= __("ASML", "asmlanm") ?></h4>
                <span><?= sprintf(__("Total travel mix of week %d", "asmlanm"), $weekly_number); ?></span>
            </div>
        </div>        
    </div>
</div>
