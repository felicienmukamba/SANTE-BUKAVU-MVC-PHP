<?php
$title = 'Connexion | Santé+';
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="login-page">
  <div class="login-card">
    <div class="login-header">
      <img src="<?= asset('brand/logo.png') ?>" alt="Logo Santé+" class="login-logo">
      <h1>Portail Santé+</h1>
      <p>Système de gestion hospitalière & médicale</p>
    </div>
    <div class="login-body">
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger mb-3"><?= e($error) ?></div>
      <?php endif; ?>
      <form method="post">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <div class="mb-3">
          <label class="form-label">Adresse email</label>
          <input class="form-control" type="email" name="email" required autofocus placeholder="admin@sante.cd">
        </div>
        <div class="mb-4">
          <label class="form-label">Mot de passe</label>
          <input class="form-control" type="password" name="password" required placeholder="••••••••">
        </div>
        <button class="btn btn-primary w-100 py-2">Se connecter</button>
      </form>
    </div>
    <div class="login-footer">
      <p class="small text-muted mb-0">Comptes démo : <code>admin@sante.cd</code> | <code>medecin@sante.cd</code> | <code>patient@sante.cd</code></p>
    </div>
  </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
