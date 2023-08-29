<?php

namespace BD\SiteOption;

class SiteOption
{
    public static function get_years_of_target_number()
    {
        $number_per_cat = get_field('number_of_each_category', 'option');

        if (is_null($number_per_cat)) return;

        $arr_years = array();
        foreach ($number_per_cat as $item) {
            foreach ($item['amount_of_people'] as $amount) {
                $year = (int) $amount['year'];
                $is_exist = in_array($year, $arr_years);

                if (!$is_exist) array_push($arr_years, $year);
            }
        }

        sort($arr_years);

        return $arr_years;
    }
}