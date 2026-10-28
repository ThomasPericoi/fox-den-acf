<?php
defined('ABSPATH') || exit;

/** Singular page template. */
get_header();

while (have_posts()) {
    the_post();
    get_template_part('template-parts/content-singular');
}

get_footer();
