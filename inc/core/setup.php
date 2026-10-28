<?php
/**
 * Theme supports, translations and navigation locations.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

// Set up the theme baseline: translations, supports, and menu locations.
function den_setup_theme()
{
    load_theme_textdomain('fox-den', get_template_directory() . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
        'header-text' => array('site-title', 'site-description'),
    ));
    add_theme_support(
        'html5',
        array(
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
            'navigation-widgets',
        )
    );
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-font-sizes');

    register_nav_menus(
        array(
            'header-menu' => __('Header Menu', 'fox-den'),
            'header-submenu' => __('Header Submenu', 'fox-den'),
            'footer-submenu' => __('Footer Submenu', 'fox-den'),
        )
    );
}
add_action('after_setup_theme', 'den_setup_theme');
