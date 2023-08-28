<?php
/**
 * Autoloading
 *
 * @package BornDigital
 */

namespace BD\Team;

defined("ABSPATH") || die("Can't access directly");

define("BD_SECURE_KEY", "bD_S3CUR3_K3Ysss");

/* NON-ADMIN */
require_once __DIR__ . "/ajax-abstract.php";
require_once __DIR__ . "/create-team.php";
require_once __DIR__ . "/resend-team-code.php";
require_once __DIR__ . "/check-team.php";
require_once __DIR__ . "/submit-travel-methods.php";
require_once __DIR__ . "/get-target-number.php";
require_once __DIR__ . "/get-updated-team-chart.php";

/* ADMIN */
require_once __DIR__ . "/admin/admin-import-travel-mix.php";
