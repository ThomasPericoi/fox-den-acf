<?php
/**
 * Login, admin bar and dashboard branding.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

// Replace the WordPress login logo with the project logo.
function den_change_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a,
        .login h1 a {
            background-image: url("<?php echo esc_url(get_theme_file_uri('/assets/medias/images/logo.svg')); ?>");
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            width: 100%;
            height: 127px;
            padding: 0;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'den_change_login_logo');

// Replace the login logo link and title with the site information.
function den_change_login_logo_url()
{
    return home_url('/');
}
add_filter('login_headerurl', 'den_change_login_logo_url');

function den_change_login_logo_title()
{
    return get_bloginfo('name');
}
add_filter('login_headertext', 'den_change_login_logo_title');

// Replace the admin bar WordPress icon with the project favicon.
function den_change_admin_bar_logo()
{ ?>
    <style type="text/css">
        #wpadminbar #wp-admin-bar-wp-logo>.ab-item .ab-icon:before {
            background-image: url("<?php echo esc_url(get_theme_file_uri('/assets/medias/images/favicon.png')); ?>");
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
            color: transparent;
            filter: brightness(0) invert(1);
        }
    </style>
<?php }
add_action('wp_before_admin_bar_render', 'den_change_admin_bar_logo');

// Add custom credits to the admin footer.
function den_change_admin_footer_text($text)
{
    return wp_kses_post(__('Powered by <a href="https://wordpress.org" target="_blank" rel="noopener noreferrer">WordPress</a> | Theme by <a href="https://thomaspericoi.com/" target="_blank" rel="noopener noreferrer">Thomas Pericoi</a>', 'fox-den'));
}
add_filter('admin_footer_text', 'den_change_admin_footer_text');

// Print the dashboard credits widget content.
function den_custom_dashboard_help()
{
    echo wp_kses_post(__('This theme was created by <a href="https://thomaspericoi.com/" target="_blank" rel="noopener noreferrer">Thomas Pericoi</a>.', 'fox-den'));
}

// Register custom dashboard widgets.
function den_add_admin_widgets()
{
    wp_add_dashboard_widget('den_credits_widget', __('Credits', 'fox-den'), 'den_custom_dashboard_help');
}
add_action('wp_dashboard_setup', 'den_add_admin_widgets');
