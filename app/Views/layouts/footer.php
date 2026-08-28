<?php if (auth()): ?>
</main>
<?php endif; ?>
<?php if (isset($_SESSION['flash'])): $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div class="toast align-items-center text-bg-<?= e($flash['type']) ?> border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
    <div class="d-flex">
      <div class="toast-body"><?= e($flash['message']) ?></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>
<?php endif; ?>
<script src="<?= asset('dist/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>
