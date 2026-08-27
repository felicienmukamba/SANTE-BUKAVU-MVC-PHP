<?php $title = 'Nouvelle prescription | Santé+'; require dirname(__DIR__) . '/layouts/header.php'; ?>
<div class="mb-4">
    <a href="/?page=prescriptions" class="text-decoration-none">&larr; Retour aux prescriptions</a>
    <h1 class="h2 mt-3">Nouvelle prescription</h1>
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
                    <label class="form-label">Consultation</label>
                    <select class="form-select" name="consultationId" required>
                        <option value="">Sélectionner une consultation</option>
                        <?php foreach ($options['consultationId'] as $option): ?>
                            <option value="<?= e((string) $option['id']) ?>"><?= e($option['label']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Posologie</label>
                    <textarea class="form-control" name="posologie" rows="3" required placeholder="Ex: 1 comprimé matin et soir"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Durée du traitement</label>
                    <input class="form-control" name="dureeTraitement" required placeholder="Ex: 7 jours">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Quantité</label>
                    <input class="form-control" name="quantite" required placeholder="Ex: 14 comprimés">
                </div>
                <div class="col-12">
                    <label class="form-label">Instructions</label>
                    <textarea class="form-control" name="instruction" rows="2" placeholder="Instructions supplémentaires pour le patient"></textarea>
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Enregistrer la prescription</button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
