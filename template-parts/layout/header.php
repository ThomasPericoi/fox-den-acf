<?php
defined('ABSPATH') || exit;

$header_cta = den_get_cta('header', 'options');
$header_has_menu = has_nav_menu('header-menu');
$header_has_submenu = has_nav_menu('header-submenu');
$header_has_navigation = $header_has_menu || $header_cta || $header_has_submenu;
?>

<!-- Header -->
<header id="header" class="header">
    <div class="container container-lg">
        <div class="inner-header">
            <div class="header-identity">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    <a href="<?= esc_url(home_url('/')); ?>"
                        class="sitename logo-link"><?= esc_html(get_bloginfo('name')); ?></a>
                <?php endif; ?>
            </div>

            <?php if ($header_has_navigation): ?>
                <button id="menu-toggle" class="menu-toggle" type="button"
                    aria-controls="header-navigation" aria-expanded="false"
                    data-label-open="<?= esc_attr__('Open menu', 'fox-den'); ?>"
                    data-label-close="<?= esc_attr__('Close menu', 'fox-den'); ?>">
                    <span
                        class="screen-reader-text"><?= esc_html__('Open menu', 'fox-den'); ?></span>
                    <span class="menu-toggle-label"
                        aria-hidden="true"><?= esc_html__('Close', 'fox-den'); ?></span>
                    <span class="menu-toggle-wrapper" aria-hidden="true">
                        <span class="menu-toggle-open"></span>
                    </span>
                </button>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($header_has_navigation): ?>
        <!-- Navigation -->
        <nav id="header-navigation" class="nav-wrapper"
            aria-label="<?= esc_attr__('Main navigation', 'fox-den'); ?>">
            <?php if ($header_has_menu): ?>
                <?php wp_nav_menu(array(
                    'theme_location' => 'header-menu',
                    'menu_class' => 'menu menu-header',
                    'container' => false,
                    'depth' => 1,
                    'fallback_cb' => false,
                )); ?>
            <?php endif; ?>

            <?php if ($header_cta || $header_has_submenu): ?>
                <div class="header-actions">
                    <?php if ($header_cta): ?>
                        <div class="btn-wrapper"><?= $header_cta; ?></div>
                    <?php endif; ?>
                    <?php if ($header_has_submenu): ?>
                        <?php wp_nav_menu(array(
                            'theme_location' => 'header-submenu',
                            'menu_class' => 'menu menu-header-submenu',
                            'container' => false,
                            'depth' => 1,
                            'fallback_cb' => false,
                        )); ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</header>
