<?php

namespace BD;

defined('ABSPATH') or exit;

class Pusher
{
    public static function get_pusher()
    {
        $app_id  = self::get_app_id();
        $key     = self::get_key();
        $secret  = self::get_secret();
        $cluster = self::get_cluster();

        return new \Pusher\Pusher($key, $secret, $app_id, array('cluster' => $cluster));
    }

    public static function get_app_id()
    {
        return get_field('pusher__app_id', 'option');
    }

    public static function get_key()
    {
        return get_field('pusher__key', 'option');
    }

    public static function get_secret()
    {
        return get_field('pusher__secret', 'option');
    }

    public static function get_cluster()
    {
        return get_field('pusher__cluster', 'option');
    }

}