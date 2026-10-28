<?php
defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <a class="skip-link screen-reader-text"
        href="#main"><?= esc_html__('Skip to content', 'fox-den'); ?></a>

    <?php get_template_part('template-parts/layout/header'); ?>

    <main id="main" tabindex="-1">
