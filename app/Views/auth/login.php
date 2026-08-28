<?php $title = 'Connexion | Santé+'; require dirname(__DIR__) . '/layouts/header.php'; ?>
<div class="login-page">
  <div class="login-card">
    <div class="login-header">
      <div class="brand-mark">+</div>
      <h1>Portail Santé+</h1>
      <p>Gestion médicale centralisée</p>
    </div>
    <div class="login-body">
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= e($error) ?></div>
      <?php endif; ?>
      <form method="post">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <div class="mb-3">
          <label class="form-label">Adresse email</label>
          <input class="form-control" type="email" name="email" required autofocus placeholder="nom@etablissement.cd">
        </div>
        <div class="mb-4">
          <label class="form-label">Mot de passe</label>
          <input class="form-control" type="password" name="password" required placeholder="••••••••">
        </div>
        <button class="btn btn-primary w-100">Se connecter</button>
      </form>
    </div>
    <div class="login-footer">
      <p class="small text-muted mb-0">Compte démo : admin@sante.local / password</p>
    </div>
  </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
