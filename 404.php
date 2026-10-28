<?php
defined('ABSPATH') || exit;
 get_header(); ?>

<!-- Page content -->
<section class="error-page">
    <div class="container container-sm">
        <h1><?= esc_html__('Page not found', 'fox-den'); ?></h1>
        <p><?= esc_html__('This page does not exist or has moved.', 'fox-den'); ?></p>
        <a class="btn btn-primary"
            href="<?= esc_url(home_url('/')); ?>"><?= esc_html__('Back to home', 'fox-den'); ?></a>
    </div>
</section>

<?php get_footer(); ?>
