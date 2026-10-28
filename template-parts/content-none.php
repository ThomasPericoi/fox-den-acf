<?php
defined('ABSPATH') || exit;
?>
<div class="formatted">
    <p><?= esc_html__('No content found.', 'fox-den'); ?></p>
    <?php if (is_search()): ?>
        <?php get_search_form(); ?>
    <?php endif; ?>
</div>
