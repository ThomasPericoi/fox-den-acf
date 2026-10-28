<?php
defined('ABSPATH') || exit;

$post_id = get_the_ID();
$content = trim(get_the_content());
?>

<!-- Page header -->
<header id="page-header-<?= esc_attr($post_id); ?>"
    class="page-header<?= $content ? ' page-header-has-content' : ''; ?>">
    <div class="container container-sm">
        <?php den_render_breadcrumbs(); ?>
        <h1><?= esc_html(get_the_title()); ?></h1>
        <?php if (has_post_thumbnail() && !post_password_required()): ?>
            <figure class="page-media">
                <?php the_post_thumbnail('full'); ?>
            </figure>
        <?php endif; ?>
    </div>
</header>

<?php if ($content): ?>
    <!-- Content -->
    <section id="content-<?= esc_attr($post_id); ?>" class="page-content">
        <div class="container container-sm formatted">
            <?php the_content(); ?>
            <?php
            wp_link_pages(array(
                'before' => '<nav class="page-links" aria-label="' . esc_attr__('Page navigation', 'fox-den') . '">',
                'after' => '</nav>',
            ));
            ?>
        </div>
    </section>
<?php endif; ?>
