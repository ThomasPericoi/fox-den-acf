<?php
defined('ABSPATH') || exit;

/**
 * Button Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param bool $is_preview True during backend preview render.
 */

$button = den_get_cta('block');
if (!$button && empty($is_preview)) {
    return;
}
?>

<!-- Block - Button -->
<div <?= !empty($is_preview) ? 'class="button-block"' : get_block_wrapper_attributes(array('class' => 'button-block')); ?>>
    <?php if ($button): ?>
            <?= $button; ?>
    <?php else: ?>
            <p><?= esc_html__('Choose a link to display the button.', 'fox-den'); ?></p>
    <?php endif; ?>
</div>
