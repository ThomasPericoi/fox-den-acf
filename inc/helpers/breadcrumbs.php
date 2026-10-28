<?php
/**
 * Accessible breadcrumbs for hierarchical singular content.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

function den_render_breadcrumbs()
{
    if (is_front_page() || !is_singular()) {
        return;
    }

    $items = array(array('url' => home_url('/'), 'label' => __('Home', 'fox-den')));
    foreach (array_reverse(get_post_ancestors(get_queried_object_id())) as $ancestor_id) {
        $items[] = array('url' => get_permalink($ancestor_id), 'label' => get_the_title($ancestor_id));
    }

    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__('Breadcrumbs', 'fox-den') . '"><ol>';
    foreach ($items as $item) {
        echo '<li><a href="' . esc_url($item['url']) . '">' . esc_html($item['label']) . '</a></li>';
    }
    echo '<li aria-current="page">' . esc_html(get_the_title(get_queried_object_id())) . '</li></ol></nav>';
}
