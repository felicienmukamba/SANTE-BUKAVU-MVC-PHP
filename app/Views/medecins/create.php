<?php
$isEdit = !empty($medecin['id']);
$pageTitle = $isEdit ? 'Modifier le médecin' : 'Nouveau médecin';
$title = $pageTitle . ' | Santé+';
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="mb-4">
    <a href="<?= url('?page=medecins') ?>" class="text-decoration-none">&larr; Retour aux médecins</a>
    <h1 class="h2 mt-3"><?= e($pageTitle) ?></h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom complet</label>
                    <input class="form-control" name="name" value="<?= e($medecin['name'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="<?= e($medecin['email'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mot de passe <?= $isEdit ? '<span class="text-muted small fw-normal">(optionnel)</span>' : 'initial' ?></label>
                    <input class="form-control" type="password" name="password" minlength="8" <?= $isEdit ? 'placeholder="Laisser vide pour ne pas modifier"' : 'required' ?>>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Spécialité</label>
                    <input class="form-control" name="specialite" value="<?= e($medecin['specialite'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Numéro de licence</label>
                    <input class="form-control" name="licence" value="<?= e($medecin['licence'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Hôpital d'affectation</label>
                    <select class="form-select" name="hopitalId" required>
                        <option value="">Sélectionner un hôpital</option>
                        <?php foreach ($hospitals as $hospital): ?>
                            <option value="<?= e((string) $hospital['id']) ?>" <?= ((string)($medecin['hopitalId'] ?? '') === (string)$hospital['id']) ? 'selected' : '' ?>>
                                <?= e($hospital['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary"><?= $isEdit ? 'Mettre à jour le médecin' : 'Enregistrer le médecin' ?></button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
