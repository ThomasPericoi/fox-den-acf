<?php
/**
 * Block registration and editor category.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

// Register every ACF block declared in the local blocks directory.
function den_register_acf_blocks()
{
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    foreach (glob(get_template_directory() . '/blocks/*/block.json') ?: array() as $metadata) {
        register_block_type(dirname($metadata));
    }
}
add_action('init', 'den_register_acf_blocks');

// Add the theme block category to the editor inserter.
function den_register_block_category($categories)
{
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'fox-den',
                'title' => __('Fox Den', 'fox-den'),
            ),
        )
    );
}
add_filter('block_categories_all', 'den_register_block_category', 10, 1);
