<?php
$isEdit = !empty($alert['id']);
$pageTitle = $isEdit ? 'Modifier l’alerte sanitaire' : 'Nouvelle alerte sanitaire';
$title = $pageTitle . ' | Santé+';
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="mb-4">
    <a href="<?= url('?page=alerts') ?>" class="text-decoration-none">&larr; Retour aux alertes</a>
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
                <div class="col-12">
                    <label class="form-label">Titre</label>
                    <input class="form-control" name="titre" value="<?= e($alert['titre'] ?? '') ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="4" required><?= e($alert['description'] ?? '') ?></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Niveau</label>
                    <select class="form-select" name="niveau" required>
                        <?php $niv = $alert['niveau'] ?? 'Information'; ?>
                        <option value="Information" <?= ($niv === 'Information') ? 'selected' : '' ?>>Information</option>
                        <option value="Vigilance" <?= ($niv === 'Vigilance') ? 'selected' : '' ?>>Vigilance</option>
                        <option value="Critique" <?= ($niv === 'Critique') ? 'selected' : '' ?>>Critique</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Statut</label>
                    <select class="form-select" name="statut" required>
                        <?php $stat = $alert['statut'] ?? 'Active'; ?>
                        <option value="Active" <?= ($stat === 'Active') ? 'selected' : '' ?>>Active</option>
                        <option value="Résolue" <?= ($stat === 'Résolue') ? 'selected' : '' ?>>Résolue</option>
                        <option value="Archivée" <?= ($stat === 'Archivée') ? 'selected' : '' ?>>Archivée</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date de fin</label>
                    <?php
                    $dateFinVal = '';
                    if (!empty($alert['dateFin'])) {
                        $dateFinVal = date('Y-m-d\TH:i', strtotime($alert['dateFin']));
                    }
                    ?>
                    <input class="form-control" type="datetime-local" name="dateFin" value="<?= e($dateFinVal) ?>">
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary"><?= $isEdit ? 'Mettre à jour l’alerte' : 'Enregistrer l’alerte' ?></button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
