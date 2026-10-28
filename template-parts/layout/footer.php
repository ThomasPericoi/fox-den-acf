<?php
defined('ABSPATH') || exit;

$footer_contacts = get_field('footer_contacts', 'options', array());
$footer_contacts = is_array($footer_contacts) ? array_filter($footer_contacts, function ($contact) {
    return !empty($contact['footer_contact_email']) && is_email($contact['footer_contact_email']);
}) : array();
$footer_logo = wp_get_attachment_image((int) get_field('footer_logo', 'options'), 'medium_large');
$footer_has_custom_logo = !empty($footer_logo);
if (!$footer_has_custom_logo) {
    $footer_logo = wp_get_attachment_image((int) get_theme_mod('custom_logo'), 'medium_large');
}
$footer_address = get_field('footer_address', 'options');
$footer_copyright = get_field('footer_copyright', 'options');
$footer_has_menu = has_nav_menu('footer-submenu');
$footer_has_identity = $footer_logo || $footer_address;
$footer_has_legal = $footer_copyright || $footer_has_menu;
$footer_has_content = $footer_contacts || $footer_has_identity || $footer_has_legal;
?>

<?php if ($footer_has_content): ?>
    <!-- Footer -->
    <footer id="footer">
        <div class="container container-lg">
            <?php if ($footer_contacts): ?>
                <!-- Main Footer -->
                <div id="main-footer">
                    <div class="footer-contacts">
                        <?php foreach ($footer_contacts as $contact): ?>
                            <div class="footer-contact">
                                <a
                                    href="mailto:<?= esc_attr(sanitize_email($contact['footer_contact_email'])); ?>"><?= esc_html($contact['footer_contact_email']); ?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($footer_has_identity || $footer_has_legal): ?>
                <!-- Sub Footer -->
                <div id="sub-footer">
                    <?php if ($footer_has_identity): ?>
                        <div class="footer-identity">
                            <?php if ($footer_logo): ?>
                                <div
                                    class="footer-logo<?= !$footer_has_custom_logo ? ' footer-logo-default' : ''; ?>">
                                    <?= $footer_logo; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($footer_address): ?>
                                <address class="footer-address"><?= nl2br(esc_html($footer_address)); ?></address>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($footer_has_legal): ?>
                        <div class="footer-legal">
                            <?php if ($footer_copyright): ?>
                                <p class="footer-copyright">&copy; <?= esc_html(wp_date('Y')); ?>
                                    <?= esc_html($footer_copyright); ?>
                                </p>
                            <?php endif; ?>
                            <?php if ($footer_has_menu): ?>
                                <nav aria-label="<?= esc_attr__('Footer navigation', 'fox-den'); ?>">
                                    <?php wp_nav_menu(array(
                                        'theme_location' => 'footer-submenu',
                                        'menu_class' => 'menu menu-footer',
                                        'container' => false,
                                        'depth' => 1,
                                        'fallback_cb' => false,
                                    )); ?>
                                </nav>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </footer>
<?php endif; ?>
