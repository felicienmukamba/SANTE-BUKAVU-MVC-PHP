<?php
$isEdit = !empty($patient['id']);
$pageTitle = $isEdit ? 'Modifier le patient' : 'Nouveau patient';
$title = $pageTitle . ' | Santé+';
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="mb-4">
    <a href="<?= url('?page=patients') ?>" class="text-decoration-none">&larr; Retour aux patients</a>
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
                    <label class="form-label">Prénom</label>
                    <input class="form-control" name="prenom" value="<?= e($patient['prenom'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nom</label>
                    <input class="form-control" name="nom" value="<?= e($patient['nom'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="<?= e($patient['email'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mot de passe <?= $isEdit ? '<span class="text-muted small fw-normal">(optionnel)</span>' : 'initial' ?></label>
                    <input class="form-control" type="password" name="password" minlength="8" <?= $isEdit ? 'placeholder="Laisser vide pour ne pas modifier"' : 'required' ?>>
                </div>
                <div class="col-md-6">
                    <label class="form-label">N° national</label>
                    <input class="form-control" name="numero_national" value="<?= e($patient['numero_national'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date de naissance</label>
                    <input class="form-control" type="date" name="date_naissance" value="<?= e($patient['date_naissance'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Lieu de naissance</label>
                    <input class="form-control" name="lieu_naissance" value="<?= e($patient['lieu_naissance'] ?? '') ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sexe</label>
                    <select class="form-select" name="sexe" required>
                        <option value="F" <?= (($patient['sexe'] ?? '') === 'F') ? 'selected' : '' ?>>Féminin</option>
                        <option value="M" <?= (($patient['sexe'] ?? '') === 'M') ? 'selected' : '' ?>>Masculin</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Situation</label>
                    <select class="form-select" name="situation_matrimoniale" required>
                        <?php $currentSit = $patient['situation_matrimoniale'] ?? 'Célibataire'; ?>
                        <option value="Célibataire" <?= ($currentSit === 'Célibataire') ? 'selected' : '' ?>>Célibataire</option>
                        <option value="Marié(e)" <?= ($currentSit === 'Marié(e)') ? 'selected' : '' ?>>Marié(e)</option>
                        <option value="Divorcé(e)" <?= ($currentSit === 'Divorcé(e)') ? 'selected' : '' ?>>Divorcé(e)</option>
                        <option value="Veuf(ve)" <?= ($currentSit === 'Veuf(ve)') ? 'selected' : '' ?>>Veuf(ve)</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary"><?= $isEdit ? 'Mettre à jour le patient' : 'Enregistrer le patient' ?></button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
