<?php

class BD_Irame_Handler
{
    private $whitelist_keys = null;

    public function __construct()
    {
        add_action("after_setup_theme", [$this, "init_hook"], 10);
    }

    public function init_hook()
    {
        $this->_set_default_origin();
    }

    // get manually because get_field throw a notice when run after_setup_theme
    private function _get_whitelist_keys()
    {
        if ($this->whitelist_keys) {
            return $this->whitelist_keys;
        }

        global $wpdb;
        $tbl = $wpdb->prefix . "options";
        $query = "SELECT option_value
				FROM {$tbl}
				WHERE
					option_name = 'options_iframe_whitelist_keys'";
        $result_count = $wpdb->get_row($query);
        if (!$result_count) {
            return [];
        }

        $query = "SELECT option_name, option_value
					FROM {$tbl}
					WHERE
						option_name LIKE 'options_iframe_whitelist_keys_%'";
        $query_results = $wpdb->get_results($query);

				$find_val = function($suffix, $index, $rows) {
					foreach($rows as $row) {
						if($row->option_name === 'options_iframe_whitelist_keys_'.$index.'_'.$suffix) {
							return $row->option_value;
						};
					}
					return null;
				};

				$res = []; 
        for ($i = 0; $i <= $result_count->option_value; $i++) {
					$res[] = [
						'key' => $find_val('key', $i, $query_results),
						'url' => $find_val('url', $i, $query_results),
					];
        }

        $this->whitelist_keys = $res;
        return $res;
    }

    private function _set_default_origin()
    {
        $whitelisted = $this->_get_whitelist_keys();

        if (!$whitelisted) {
            header("X-Frame-Options: DENY");
            return;
        }

        $urls = [];
        foreach ($whitelisted as $iframe_key) {
            $urls[] = $iframe_key["url"];
        }

        $urls = array_unique($urls);
        $url_str = join(' ', $urls);

        header("Content-Security-Policy: default-src 'self' " . $url_str);
    }
}

new BD_Irame_Handler();
