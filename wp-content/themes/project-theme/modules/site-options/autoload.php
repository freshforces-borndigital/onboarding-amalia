<?php
/**
 * Autoloading
 *
 * @package BornDigital
 */

namespace BD\SiteOption;

defined("ABSPATH") || die("Can't access directly");

/* ADMIN */
require_once __DIR__ . "/admin/class-setup.php";


/* NON ADMIN */
require_once __DIR__ . "/site-options.php";


