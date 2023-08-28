<?php
defined('ABSPATH') or die('Can\'t access directly');

class BD_Helper
{
    public static function get_pusher()
    {
        static $pusher;

        if (!$pusher) {
            $pusher = \BD\Pusher::get_pusher();
        }

        return $pusher;
    }

}
