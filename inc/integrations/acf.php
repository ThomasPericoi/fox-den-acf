<?php
/**
 * ACF JSON storage, dependency notice and options page.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

// Save ACF local JSON inside the theme.
function den_save_acf_groups_json($path)
{
    return get_stylesheet_directory() . '/acf-json';
}
add_filter('acf/settings/save_json', 'den_save_acf_groups_json');

// Load ACF local JSON from the theme.
function den_load_acf_groups_json($paths)
{
    $paths[] = get_template_directory() . '/acf-json';
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return array_unique($paths);
}
add_filter('acf/settings/load_json', 'den_load_acf_groups_json');

// Warn admins when the required ACF Pro plugin is missing.
function den_display_acf_missing_notice()
{
    if ((defined('ACF_PRO') && ACF_PRO) || !current_user_can('activate_plugins')) {
        return;
    }

    echo '<div class="notice notice-error"><p><strong>' . esc_html__('Advanced Custom Fields Pro is required.', 'fox-den') . '</strong> ' . esc_html__('Activate the plugin to manage and display custom content.', 'fox-den') . '</p></div>';
}
add_action('admin_notices', 'den_display_acf_missing_notice');

// Add the global theme options page for ACF fields.
function den_register_theme_options()
{
    if (!function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page(array(
        'page_title' => __('Theme options', 'fox-den'),
        'menu_title' => __('Theme options', 'fox-den'),
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_theme_options',
        'redirect' => false,
        'position' => 2,
        'icon_url' => 'dashicons-admin-settings',
        'update_button' => __('Update', 'fox-den'),
        'updated_message' => __('Settings saved.', 'fox-den'),
    ));
}
add_action('acf/init', 'den_register_theme_options');
