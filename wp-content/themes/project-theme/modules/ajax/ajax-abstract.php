<?php

namespace BD\Ajax;

defined("ABSPATH") or exit();

abstract class BD_Ajax_Abstract
{
    /**
     * @var string|array
     */
    protected $action;

    /**
     * @var bool
     */
    protected $is_public = false;

    /**
     * @var array
     */
    protected $fields = [];

    public function __construct()
    {
        if (is_array($this->action)) {
            foreach ($this->action as $act) {
                add_action("wp_ajax_{$act}", [$this, "action_ajax"]);

                if ($this->is_public) {
                    add_action("wp_ajax_nopriv_{$act}", [$this, "action_ajax"]);
                }
            }

            return true;
        }

        add_action("wp_ajax_{$this->action}", [$this, "action_ajax"]);
        if ($this->is_public) {
            add_action("wp_ajax_nopriv_{$this->action}", [$this, "action_ajax"]);
        }
    }

    /**
     * Ajax callback
     *
     * @return void
     */
    public function action_ajax()
    {
        $this->sanitize_request();
        $this->validate_request();
        $this->response();
    }

    protected function sanitize_request()
    {
        // End the operation if there is no 'nonce' is given
        if (!isset($_REQUEST["nonce"])) {
            wp_die();
        }

        foreach ($this->fields as $key => $value) {
            if (isset($_REQUEST[$key])) {
                $value = $_REQUEST[$key];
                $this->fields[$key] = is_array($value) ? $this->sanitize_array($value) : sanitize_text_field($value);
            }
        }
    }

    /**
     * Sanitize request fields
     *
     * @param array $array
     * @return array
     */
    protected function sanitize_array(&$array)
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $this->sanitize_array($value);
            } else {
                sanitize_text_field($value);
            }
        }

        return $array;
    }

    /**
     * Validate the request. You can override this function to add your own validation
     *
     * @return void
     */
    protected function validate_request()
    {
        $token_is_corrent = wp_verify_nonce($_REQUEST["nonce"], BD_SECURE_KEY);

        if (!$token_is_corrent) {
            $this->throw_error(__("Invalid Token. Please refresh the page and try again!","asmlanm"));
        }
    }

    protected function throw_error($message, $additional_data = [])
    {
        return wp_send_json_error(
            array_merge(
                [
                    "message" => $message,
                ],
                $additional_data
            )
        );
    }

    /**
     * @return mixed
     */
    abstract public function response();
}
