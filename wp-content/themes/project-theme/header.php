<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package BornDigital
 */

$title = get_bloginfo("name", false);
if (wp_title("", false)) {
	$title = get_bloginfo("name", false) . " | " . wp_title("", false);
}

defined("ABSPATH") || die("Can't access directly");
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo("charset"); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable = yes">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<title><?= $title ?></title>

	<?php wp_head(); ?>
</head>

<body <?php body_class("is-loading"); ?>>
<div class="site">
	<!-- .site: the closing tag is in header.php -->
	<div class="loadingscreen"></div>
