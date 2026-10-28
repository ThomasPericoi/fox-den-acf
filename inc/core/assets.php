<?php
/**
 * Front-end assets and cache versions.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

// Use the newest CSS file timestamp as the main stylesheet version.
function den_get_stylesheet_version()
{
    static $version = null;

    if ($version !== null) {
        return $version;
    }

    $version = (string) wp_get_theme()->get('Version');
    if (!is_dir(get_template_directory() . '/assets/css')) {
        return $version;
    }
    $version = filemtime(get_template_directory() . '/style.css');
    $css_directory = new RecursiveDirectoryIterator(get_template_directory() . '/assets/css', FilesystemIterator::SKIP_DOTS);
    $css_files = new RecursiveIteratorIterator($css_directory);

    foreach ($css_files as $css_file) {
        if ($css_file->getExtension() === 'css') {
            $version = max($version, $css_file->getMTime());
        }
    }

    return $version;
}

// Version individual assets from their file timestamp.
function den_get_asset_version($relative_path)
{
    $path = get_theme_file_path($relative_path);

    if (file_exists($path)) {
        return filemtime($path);
    }

    return den_get_stylesheet_version();
}

// Load the project font on the website.
function den_enqueue_google_fonts()
{
    wp_enqueue_style('den-google-fonts', 'https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100..900;1,100..900&display=swap', array(), null);
}
add_action('wp_enqueue_scripts', 'den_enqueue_google_fonts', 5);

// Prepare Google Fonts connections only when the stylesheet is enqueued.
function den_google_fonts_resource_hints($urls, $relation_type)
{
    if ($relation_type !== 'preconnect' || !wp_style_is('den-google-fonts', 'enqueued')) {
        return $urls;
    }

    $urls[] = 'https://fonts.googleapis.com';
    $urls[] = array(
        'href' => 'https://fonts.gstatic.com',
        'crossorigin' => 'anonymous',
    );

    return $urls;
}
add_filter('wp_resource_hints', 'den_google_fonts_resource_hints', 10, 2);

// Register and enqueue theme styles only when they are needed.
function den_enqueue_theme_stylesheets()
{
    wp_enqueue_style('den-style', get_template_directory_uri() . '/style.css', array('den-google-fonts'), den_get_stylesheet_version());
    if (is_child_theme()) {
        wp_enqueue_style('den-child-style', get_stylesheet_uri(), array('den-style'), den_get_asset_version('style.css'));
    }
}
add_action('wp_enqueue_scripts', 'den_enqueue_theme_stylesheets');

// Register and enqueue theme scripts only when they are needed.
function den_enqueue_theme_scripts()
{
    wp_register_script('den-ascii-printer', get_theme_file_uri('assets/js/ascii-printer.min.js'), array(), den_get_asset_version('assets/js/ascii-printer.min.js'), true);
    wp_register_script('den-main', get_theme_file_uri('assets/js/main.js'), array('den-ascii-printer'), den_get_asset_version('assets/js/main.js'), true);
    wp_enqueue_script('den-ascii-printer');
    wp_enqueue_script('den-main');
}
add_action('wp_enqueue_scripts', 'den_enqueue_theme_scripts');
