<?php
/**
 * Escaped HTML for reusable ACF buttons.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

// Build a reusable CTA from cloned ACF button fields.
function den_get_cta($selector_prefix, $post_id = false, $sub_field = false)
{
    if (!function_exists('get_field') || ($sub_field && !function_exists('get_sub_field'))) {
        return '';
    }

    $color = $sub_field ? get_sub_field("{$selector_prefix}_cta_color") : get_field("{$selector_prefix}_cta_color", $post_id);
    $type = $sub_field ? get_sub_field("{$selector_prefix}_cta_type") : get_field("{$selector_prefix}_cta_type", $post_id);

    $text_cta = $sub_field ? get_sub_field("{$selector_prefix}_cta_text") : get_field("{$selector_prefix}_cta_text", $post_id);
    $text_icon = $sub_field ? get_sub_field("{$selector_prefix}_cta_text_icon") : get_field("{$selector_prefix}_cta_text_icon", $post_id);
    $text_icon_direction = $sub_field ? get_sub_field("{$selector_prefix}_cta_text_icon_direction") : get_field("{$selector_prefix}_cta_text_icon_direction", $post_id);
    $image_cta = $sub_field ? get_sub_field("{$selector_prefix}_cta_image") : get_field("{$selector_prefix}_cta_image", $post_id);

    $text_cta = is_array($text_cta) ? $text_cta : array();
    $image_cta = is_array($image_cta) ? $image_cta : array();

    $color = in_array($color, array('primary', 'black', 'outline'), true) ? $color : 'primary';
    $type = $type ?: 'text';
    $text_icon = in_array($text_icon, array('none', 'arrow-right'), true) ? $text_icon : 'none';
    $text_icon_direction = $text_icon_direction === 'icon-before' ? 'icon-before' : 'icon-after';

    if (!$text_cta && empty($image_cta['image'])) {
        return '';
    }

    if ($type === 'text' && !empty($text_cta['title']) && !empty($text_cta['url']) && esc_url($text_cta['url'])) {
        $target = ($text_cta['target'] ?? '') === '_blank' ? '_blank' : '_self';
        $rel = $target === '_blank' ? ' rel="noopener noreferrer"' : '';

        return sprintf(
            '<a class="btn btn-%1$s btn-icon-%2$s %3$s" href="%4$s" target="%5$s"%6$s>%7$s</a>',
            esc_attr($color),
            esc_attr($text_icon),
            esc_attr($text_icon_direction),
            esc_url($text_cta['url']),
            esc_attr($target),
            $rel,
            esc_html($text_cta['title'])
        );
    } elseif ($type === 'image' && !empty($image_cta['image']) && !empty($image_cta['url']) && !empty($image_cta['title']) && esc_url($image_cta['url'])) {
        $target = ($image_cta['target'] ?? '') === '_blank' ? '_blank' : '_self';
        $rel = $target === '_blank' ? ' rel="noopener noreferrer"' : '';

        $image_url = is_string($image_cta['image']) ? esc_url($image_cta['image']) : '';
        if (!$image_url) {
            return '';
        }

        return sprintf(
            '<a class="btn btn-%1$s btn-image" href="%2$s" title="%3$s" aria-label="%3$s" target="%4$s"%5$s>
                <img src="%6$s" alt="%3$s" />
            </a>',
            esc_attr($color),
            esc_url($image_cta['url']),
            esc_attr($image_cta['title']),
            esc_attr($target),
            $rel,
            $image_url
        );
    }

    return '';
}

// Echo a reusable CTA from cloned ACF button fields.
function den_render_cta($selector_prefix, $post_id = false, $sub_field = false)
{
    echo den_get_cta($selector_prefix, $post_id, $sub_field);
}
