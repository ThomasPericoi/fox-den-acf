(() => {
    'use strict';

    // A disclosure menu stays in document flow; no focus trap or page scroll lock.
    const initMenu = () => {
        const header = document.getElementById('header');
        const nav = document.getElementById('header-navigation');
        const toggle = document.getElementById('menu-toggle');
        if (!header || !nav || !toggle) return;

        // Keep this breakpoint aligned with elements/header.css.
        const desktop = window.matchMedia('(min-width: 62rem)');
        const label = toggle.querySelector('.screen-reader-text');
        let opened = false;
        const setOpen = (value) => {
            opened = value && !desktop.matches;
            nav.hidden = !desktop.matches && !opened;
            toggle.setAttribute('aria-expanded', String(opened));
            if (label) label.textContent = opened ? toggle.dataset.labelClose : toggle.dataset.labelOpen;
        };
        const close = (restoreFocus = false) => {
            // Move focus before hiding its current container.
            if (restoreFocus) toggle.focus();
            setOpen(false);
        };

        toggle.addEventListener('click', () => setOpen(!opened));
        header.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && opened) {
                event.preventDefault();
                close(true);
            }
        });
        nav.addEventListener('click', (event) => {
            if (opened && event.target.closest('a[href]')) close(true);
        });
        document.addEventListener('click', (event) => {
            if (opened && !header.contains(event.target)) close(nav.contains(document.activeElement));
        });
        document.addEventListener('focusin', (event) => {
            if (opened && !header.contains(event.target)) close();
        });
        desktop.addEventListener('change', () => {
            if (!desktop.matches && nav.contains(document.activeElement)) toggle.focus();
            if (desktop.matches && document.activeElement === toggle) nav.querySelector('a[href]')?.focus();
            setOpen(false);
        });
        window.addEventListener('pageshow', () => setOpen(false));

        // Enhance only after every interaction has been registered successfully.
        setOpen(false);
        header.classList.add('menu-ready');
    };

    const initReveal = () => {
        const main = document.getElementById('main');
        if (!main) return;
        const targets = [...main.querySelectorAll(':scope > section, [data-reveal]')]
            .filter((element) => !element.closest('.js-alwaysInView'));
        const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
        if (!targets.length || motion.matches || !('IntersectionObserver' in window)) return;

        let observer;
        let safetyTimer;
        const reveal = (element) => {
            element.classList.add('js-inView');
            observer?.unobserve(element);
        };
        const revealAll = () => {
            targets.forEach(reveal);
            observer?.disconnect();
            window.clearTimeout(safetyTimer);
        };

        try {
            observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) reveal(entry.target);
                });
            }, { threshold: 0 });

            // Register rescue paths before applying any hidden state.
            safetyTimer = window.setTimeout(revealAll, 4000);
            motion.addEventListener('change', (event) => { if (event.matches) revealAll(); });
            window.addEventListener('beforeprint', revealAll);
            window.addEventListener('pageshow', (event) => { if (event.persisted) revealAll(); });
            main.addEventListener('focusin', (event) => {
                targets.filter((element) => element.contains(event.target)).forEach(reveal);
            });

            targets.forEach((element) => {
                const rect = element.getBoundingClientRect();
                // Never hide above-the-fold content, an anchor target or its parent.
                if (rect.top < window.innerHeight || element.matches(':target') || element.querySelector(':target')) {
                    reveal(element);
                    return;
                }
                observer.observe(element);
                element.classList.add('reveal-pending');
            });
        } catch (error) {
            revealAll();
            console.warn('Fox Den: reveal disabled.', error);
        }
    };

    const initSignature = () => {
        console.info('This theme was made by Thomas Pericoi - https://thomaspericoi.com/');
        window.AsciiPrinter?.printRandom?.();
    };

    const init = () => {
        // An optional enhancement must not prevent the other modules from starting.
        [initMenu, initReveal, initSignature].forEach((initialize) => {
            try { initialize(); } catch (error) { console.warn('Fox Den: enhancement unavailable.', error); }
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init, { once: true });
    } else {
        init();
    }
})();
