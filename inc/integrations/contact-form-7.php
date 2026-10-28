<?php
/**
 * Optional Contact Form 7 integration.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

// Keep form markup under theme control when the plugin is active.
add_filter('wpcf7_autop_or_not', '__return_false');
