<?php $title = 'Demander un examen | Santé+'; require dirname(__DIR__) . '/layouts/header.php'; ?>
<div class="mb-4">
    <a href="<?= url('?page=exams') ?>" class="text-decoration-none">&larr; Retour aux examens</a>
    <h1 class="h2 mt-3">Demander un examen</h1>
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
                <div class="col-md-8">
                    <label class="form-label">Type d'examen</label>
                    <input class="form-control" name="typeExamen" required placeholder="Ex: Analyse sanguine, Radiographie, Échographie">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix (FCFA)</label>
                    <input class="form-control" type="number" name="prix" min="0" step="0.01">
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Demander l'examen</button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
