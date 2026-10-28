<?php
/**
 * Comment-free site policy (remove this module to restore comments).
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

// Keep comments and pingbacks closed everywhere.
function den_disable_comments_status()
{
    return false;
}
add_filter('comments_open', 'den_disable_comments_status', 20, 2);
add_filter('pings_open', 'den_disable_comments_status', 20, 2);

// Hide existing comments from public queries.
function den_disable_comments_hide_existing_comments($comments)
{
    return array();
}
add_filter('comments_array', 'den_disable_comments_hide_existing_comments', 10, 2);

// Remove the comments screen from the admin menu.
function den_disable_comments_admin_menu()
{
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'den_disable_comments_admin_menu');

// Redirect users away from the comments admin screen.
function den_disable_comments_admin_menu_redirect()
{
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'den_disable_comments_admin_menu_redirect');

// Remove the comments dashboard widget.
function den_disable_comments_dashboard()
{
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'den_disable_comments_dashboard');

// Remove the comments shortcut from the admin bar.
function den_disable_comments_icon_admin_bar()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'den_disable_comments_icon_admin_bar');

// Remove comment and trackback support from every post type.
function den_disable_comments_post_types_support()
{
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
        }
        remove_post_type_support($post_type, 'trackbacks');
    }
}
add_action('init', 'den_disable_comments_post_types_support', 100);

// Keep pingback discovery and the comments feed out of the public head.
add_filter('feed_links_show_comments_feed', '__return_false');

function den_remove_pingback_header($headers)
{
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'den_remove_pingback_header');
