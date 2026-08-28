<?php $title = 'Nouvelle alerte sanitaire | Santé+'; require dirname(__DIR__) . '/layouts/header.php'; ?>
<div class="mb-4">
    <a href="<?= url('?page=alerts') ?>" class="text-decoration-none">&larr; Retour aux alertes</a>
    <h1 class="h2 mt-3">Nouvelle alerte sanitaire</h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Titre</label>
                    <input class="form-control" name="titre" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="4" required></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Niveau</label>
                    <select class="form-select" name="niveau" required>
                        <option value="Information">Information</option>
                        <option value="Vigilance">Vigilance</option>
                        <option value="Critique">Critique</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Statut</label>
                    <select class="form-select" name="statut" required>
                        <option value="Active">Active</option>
                        <option value="Résolue">Résolue</option>
                        <option value="Archivée">Archivée</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date de fin</label>
                    <input class="form-control" type="datetime-local" name="dateFin">
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Enregistrer l'alerte</button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
