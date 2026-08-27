<?php $title = 'Nouveau médecin | Santé+'; require dirname(__DIR__) . '/layouts/header.php'; ?>
<div class="mb-4">
    <a href="/?page=medecins" class="text-decoration-none">&larr; Retour aux médecins</a>
    <h1 class="h2 mt-3">Nouveau médecin</h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom complet</label>
                    <input class="form-control" name="name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mot de passe initial</label>
                    <input class="form-control" type="password" name="password" minlength="8" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Spécialité</label>
                    <input class="form-control" name="specialite" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Numéro de licence</label>
                    <input class="form-control" name="licence" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Hôpital d'affectation</label>
                    <select class="form-select" name="hopitalId" required>
                        <option value="">Sélectionner un hôpital</option>
                        <?php foreach ($hospitals as $hospital): ?>
                            <option value="<?= e((string) $hospital['id']) ?>"><?= e($hospital['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Enregistrer le médecin</button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
