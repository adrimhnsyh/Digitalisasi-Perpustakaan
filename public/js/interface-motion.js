(() => {
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isAdmin = document.body.classList.contains('admin-body');

    document.body.classList.add('interface-ready');

    const navbar = document.querySelector('.public-navbar');
    if (navbar) {
        const syncNavbar = () => navbar.classList.toggle('is-scrolled', window.scrollY > 18);
        syncNavbar();
        window.addEventListener('scroll', syncNavbar, { passive: true });

        const navigation = navbar.querySelector('.navbar-collapse');
        navigation?.querySelectorAll('a:not(.dropdown-toggle)').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth >= 992 || !navigation.classList.contains('show') || !window.bootstrap?.Collapse) {
                    return;
                }

                window.bootstrap.Collapse.getOrCreateInstance(navigation).hide();
            });
        });
    }

    if (reducedMotion) {
        document.body.classList.add('motion-reduced');
        return;
    }

    document.body.classList.add('motion-enabled');

    const selectors = isAdmin
        ? ['.page-content > *', '.side-nav li', '.sidebar-footer']
        : [
            'main > section:not(.library-hero):not(.explore-hero):not(.page-hero)',
            '.quick-access__item',
            '.public-footer .row > [class*="col-"]',
        ];

    const targets = [...new Set(selectors.flatMap((selector) => [...document.querySelectorAll(selector)]))];

    targets.forEach((element, index) => {
        element.classList.add('motion-reveal');
        element.style.setProperty('--motion-delay', `${(index % 4) * 55}ms`);
    });

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, {
            rootMargin: '0px 0px -8% 0px',
            threshold: 0.08,
        });

        targets.forEach((element) => observer.observe(element));
    } else {
        targets.forEach((element) => element.classList.add('is-visible'));
    }

    if (!isAdmin) {
        const numberFormatter = new Intl.NumberFormat('id-ID');
        const counters = [...document.querySelectorAll('[data-count]')];
        const animateCounter = (element) => {
            const target = Number(element.dataset.count ?? 0);
            const duration = 950;
            const startedAt = performance.now();

            const update = (now) => {
                const progress = Math.min((now - startedAt) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                element.textContent = numberFormatter.format(Math.round(target * eased));

                if (progress < 1) {
                    requestAnimationFrame(update);
                }
            };

            requestAnimationFrame(update);
        };

        if ('IntersectionObserver' in window) {
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                });
            }, { threshold: 0.65 });

            counters.forEach((counter) => counterObserver.observe(counter));
        }
    }
})();
