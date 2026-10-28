<?php
/**
 * Theme bootstrap. Keep implementations in focused modules.
 *
 * @package FoxDen
 */

defined('ABSPATH') || exit;

$den_modules = array(
    'helpers/buttons',
    'helpers/breadcrumbs',
    'core/setup',
    'core/assets',
    'core/blocks',
    'core/cleanup',
    'core/comments',
    'integrations/acf',
    'integrations/contact-form-7',
    'admin/branding',
);

foreach ($den_modules as $den_module) {
    require_once get_template_directory() . '/inc/' . $den_module . '.php';
}
unset($den_modules, $den_module);
