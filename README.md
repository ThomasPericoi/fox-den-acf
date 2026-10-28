# Fox Den (ACF)

A classic WordPress starter theme for custom projects. Requires WordPress 6.5+, PHP 8.1+ and ACF Pro for custom fields, options and blocks. Templates remain usable without ACF; an admin notice explains the missing dependency. Contact Form 7 is optional.

## PHP structure

```text
functions.php                  Explicit module loader; no implementation here
inc/
  core/
    setup.php                  Translations, theme supports and menu locations
    assets.php                 CSS/JS loading, font connections and asset versions
    blocks.php                 Block discovery and editor category
    cleanup.php                Emoji assets and legacy discovery links
    comments.php               Comment-free site policy, public and admin hooks
  admin/
    branding.php               Login, admin bar, footer credits and dashboard
  integrations/
    acf.php                    Local JSON, dependency notice and options page
    contact-form-7.php          Optional form markup customization
  helpers/
    fields.php                 Optional ACF field access with a fallback
    buttons.php                Reusable text/image CTA rendering
    breadcrumbs.php            Breadcrumbs for singular content and its ancestors
blocks/
  button/
    block.json                 Block metadata
    button.php                 ACF render template
acf-json/                      Versioned ACF field groups
header.php / footer.php        Document wrappers and WordPress lifecycle hooks
page.php / single.php          Singular loops
index.php                      Archive, search and fallback loop
404.php                        Not-found template
template-parts/
  layout/header.php            Site identity and navigation
  layout/footer.php            Footer options and navigation
  content-singular.php         Shared page/post content
  item-content.php             Archive card
  content-none.php             Empty state
```

Module order is explicit: helpers, core hooks, integrations, administration. Within each module, keep related functions together and register their hooks directly after their definitions. Use named `den_` callbacks so individual behaviors can be removed from a project or child theme. Keep business data types and taxonomies in a project plugin so changing the theme does not hide them.

## Starting a project

1. Activate the theme and ACF Pro. Synchronize field groups from `acf-json` if ACF offers a sync. Field and group keys are stable; do not rename them for cosmetic reasons.
2. Set the site logo and assign Header Menu, Header Submenu and Footer Submenu under Appearance. Configure header/footer fields in Theme options (requires `edit_theme_options`).
3. Customize `inc/admin/branding.php`, local media, typography and styles. Urbanist is currently loaded from Google Fonts; change its enqueue in `inc/core/assets.php` if the project uses local fonts. The supplied CSS provides a neutral responsive baseline for the existing templates.
4. Keep or remove the `core/comments` entry in `functions.php` according to the project. Removing it restores WordPress comment behavior, but comment-enabled projects must also add a comments template. Emoji cleanup and branding are separate removable modules.
5. Add blocks under `blocks/<name>/` with `block.json` and a render template; registration discovers these folders automatically. Keep the ACF location rule equal to the block's `name`. The button block uses `acf/den-button`.

## Helpers and output conventions

Footer logos use `wp_get_attachment_image()` directly with attachment IDs. Image buttons render an escaped image URL, matching their ACF return format.

- `get_field($selector, $post_id = false, $default = '')` returns raw ACF values or a fallback when ACF/the value is unavailable. Escape values at the point of output. Explicit `0` and empty strings are preserved.
- `den_get_cta($prefix, $post_id = false, $sub_field = false)` returns escaped markup for cloned button fields. `den_render_cta()` echoes it. New-window links include `noopener noreferrer`.
- `den_render_breadcrumbs()` outputs a home link, ancestor links and the current singular title, excluding the front page. This intentionally does not implement archive/taxonomy breadcrumbs.

All PHP UI strings use English source text and the `fox-den` text domain. Put translation files in `languages/`. ACF JSON labels also use English; field names and keys remain unchanged.

The stylesheet version includes imported parent CSS timestamps. JavaScript paths use WordPress child-theme-aware file resolution. A child theme's entry stylesheet is loaded after the parent stylesheet; JSON loading includes both themes. Create a writable `acf-json/` folder in a child theme before saving its field groups. PHP modules are loaded from the parent; customize behavior through hooks rather than copying bootstrap files.

## Cleanup performed

- Split the former `inc/init.php` into setup, assets, cleanup and comments modules.
- Moved rendering helpers, admin branding, integrations, blocks and field groups into dedicated directories.
- Added the missing field and breadcrumb helpers, plus a single-post template and shared layout/content parts.
- Fixed the unregistered header submenu, missing CSS enqueues, inconsistent text domain, obsolete project names and mismatched ACF button location rule.
- Fixed ACF editor previews by avoiding front-end wrapper attributes during preview.
- Removed the unused `realisation` post type, empty post-type loader and unnecessary rewrite flush. It was never registered by the original empty list.
- Removed the obsolete required-CF7 homepage notice; preserved the optional CF7 paragraph filter.
- Removed global login-error replacement, generator hiding and the XML-RPC authentication filter. These are not a substitute for authentication protection; the login replacement also discarded useful core feedback. WordPress defaults now apply to those behaviors.
- Restricted theme options to users with `edit_theme_options`; editors with only `edit_pages` no longer have access by default.

No stored content, database options, ACF keys or menu-location identifiers were migrated. Existing content that actually uses an older `acf/gv-button` block needs a separate content migration; the supplied block metadata already used `acf/den-button` before this reorganization.

## Validation

PHP syntax was checked using PHP 8.3. Standalone smoke checks with WordPress stubs covered module loading, hook callbacks, asset paths, missing/present ACF behavior and escaped text/image buttons. JSON checks covered group filenames, clone references and the block location rule. These checks do not replace a live WordPress/ACF editor test; the local HTTP server was unavailable during this pass.


## CSS foundation

`style.css` imports foundations, layout/components, templates, then motion overrides. The conventions come from Around the Wereld, with project colors, decorative effects and specialized templates removed. The PHP template structure is unchanged.

- `base/variables.css`: neutral palette, font families, spacing scale (`--spacing-2xs` through `--spacing-2xl`), fluid section spacing, container widths, radius and motion.
- `base/reset.css`, `base/base.css`: small reset, visible focus, skip link and document defaults.
- `base/typography.css`, `base/content.css`, `base/wordpress.css`: heading sizes, formatted content, native lists (including `start`, `reversed` and `value`), images, quotes, tables and WordPress alignment classes. Wide/full blocks have bounded breakout widths to preserve viewport gutters.
- `elements/`: containers, grids, columns, buttons, forms, media, breadcrumbs, header and footer.
- `pages/`, `template-parts/`, `blocks/`: styling for the existing page/single, archive/search, 404, cards and button block.
- `base/animations.css`: optional reveal animation, reduced-motion preferences, CSS rescue and print rules.

Reusable classes:

```html
<div class="container container-sm">Reading width</div>
<div class="container container-lg">Wide layout</div>
<div class="grid grid-3">…</div>
<div class="cols-wrapper">
    <div class="col col-1-3">…</div>
    <div class="col col-2-3">…</div>
</div>
<div class="btn-wrapper">
    <a class="btn btn-primary btn-icon-arrow-right icon-after" href="/">Primary action</a>
    <a class="btn btn-outline" href="/">Secondary action</a>
</div>
```

Buttons support `btn-primary`, `btn-black`, `btn-white`, `btn-outline`, `btn-sm`, `btn-lg`, `btn-full`, `btn-image`, and the supplied `btn-icon-arrow-right` with `icon-before`/`icon-after`. ACF already outputs the matching primary/black/outline classes. Use native `disabled` on buttons; `aria-disabled` on a link only provides semantics and styling, not click prevention. Typography utilities include `h1-size` through `h6-size`, `p-size`, `eyebrow`, `text-small` and `text-muted`.

## JavaScript enhancements

`assets/js/main.js` contains independent initializers for navigation, reveal and the existing console signature. No library is needed for navigation or reveal. The header stays in document flow, so there is no scroll listener, header-height measurement or page scroll lock.

Navigation remains visible without JavaScript. Once initialized, it becomes a mobile disclosure below `62rem`, with `aria-expanded`, Escape, outside-click/focus closing and desktop breakpoint reset. It is not a modal: keyboard focus continues naturally through the document. Update the breakpoint in both `elements/header.css` and `main.js` if needed.

Direct sections inside `#main` and elements marked `data-reveal` are eligible for reveal. Add `js-alwaysInView` to exclude an element and its descendants. Content is visible by default; only successfully observed, below-the-fold elements receive `reveal-pending`. Initial viewport content and anchor targets stay visible. Focus, printing, reduced-motion changes and back/forward restoration reveal content immediately. Missing/broken IntersectionObserver leaves it visible. Independent CSS and JS safeguards reveal everything after four seconds, deliberately favoring readable content over animations on a long page.

Validation for this CSS/JS pass: Node syntax and simulated-DOM interaction checks passed (mobile/desktop menu, focus/Escape, breakpoint changes, reveal, missing/throwing observer, reduced motion and safety timer). All CSS imports, local asset paths and variable references were checked. These are not browser-rendering tests: the installed browser could not complete its headless startup in this environment. Verify the live theme at mobile/desktop widths, with keyboard navigation and JavaScript disabled.
