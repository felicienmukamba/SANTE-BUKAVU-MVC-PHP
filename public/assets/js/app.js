document.addEventListener('DOMContentLoaded', function () {

  /* ═══ Confirm dialogs ═══ */
  document.querySelectorAll('[data-confirm]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      if (!window.confirm(el.dataset.confirm)) e.preventDefault();
    });
  });

  /* ═══ Sidebar ═══ */
  var sidebar   = document.getElementById('sidebar');
  var backdrop  = document.getElementById('sidebarBackdrop');
  var toggle    = document.getElementById('sidebarToggle');

  if (!sidebar || !toggle) return; // login page — no sidebar

  var STORAGE_KEY = 'sante_sidebar_collapsed';
  var isMobile = function () { return window.innerWidth < 992; };

  // Restore state on desktop
  if (!isMobile() && localStorage.getItem(STORAGE_KEY) === '1') {
    sidebar.classList.add('collapsed');
  }

  // Toggle button
  toggle.addEventListener('click', function () {
    if (isMobile()) {
      sidebar.classList.toggle('mobile-open');
      backdrop.classList.toggle('show');
      document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
    } else {
      sidebar.classList.toggle('collapsed');
      localStorage.setItem(STORAGE_KEY, sidebar.classList.contains('collapsed') ? '1' : '0');
    }
  });

  // Backdrop click closes mobile sidebar
  if (backdrop) {
    backdrop.addEventListener('click', function () {
      sidebar.classList.remove('mobile-open');
      backdrop.classList.remove('show');
      document.body.style.overflow = '';
    });
  }

  // Handle resize: clear mobile state when going to desktop
  window.addEventListener('resize', function () {
    if (!isMobile()) {
      sidebar.classList.remove('mobile-open');
      if (backdrop) backdrop.classList.remove('show');
      document.body.style.overflow = '';
    }
  });

});
