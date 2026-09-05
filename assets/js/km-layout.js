(function () {
    function applyLayoutClasses() {
        var body = document.body;
        if (!body) {
            return;
        }
        body.classList.add(
            'demo1',
            'kt-sidebar-fixed',
            'kt-header-fixed',
            'antialiased',
            'flex',
            'h-full',
            'text-base',
            'text-foreground',
            'bg-background'
        );
    }

    if (document.body) {
        applyLayoutClasses();
    } else {
        document.addEventListener('DOMContentLoaded', applyLayoutClasses);
    }

    function isMobileSidebar() {
        return window.matchMedia('(max-width: 1023px)').matches;
    }

    function initSidebarToggle() {
        var sidebar = document.getElementById('sidebar');
        var toggle = document.getElementById('header_sidebar_toggle');
        if (!sidebar || !toggle) {
            return;
        }

        toggle.addEventListener('click', function () {
            if (isMobileSidebar()) {
                sidebar.classList.toggle('open');
                sidebar.classList.toggle('kt-drawer-open');
                return;
            }
            document.body.classList.toggle('km-sidebar-collapsed');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebarToggle);
    } else {
        initSidebarToggle();
    }

    function initScrollToTop() {
        var button = document.querySelector('.scroll-to-top');
        if (!button) {
            return;
        }

        var offset = 300;

        function toggleVisibility() {
            if (window.scrollY > offset) {
                button.classList.add('is-visible');
            } else {
                button.classList.remove('is-visible');
            }
        }

        function scrollToTop(event) {
            if (event) {
                event.preventDefault();
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        window.addEventListener('scroll', toggleVisibility, { passive: true });
        button.addEventListener('click', scrollToTop);
        button.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                scrollToTop(event);
            }
        });
        toggleVisibility();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollToTop);
    } else {
        initScrollToTop();
    }
})();
