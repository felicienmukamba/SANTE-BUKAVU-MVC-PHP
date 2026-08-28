<?php $title = 'Nouvelle consultation | Santé+'; require dirname(__DIR__) . '/layouts/header.php'; ?>
<div class="mb-4">
    <a href="<?= url('?page=consultations') ?>" class="text-decoration-none">&larr; Retour aux consultations</a>
    <h1 class="h2 mt-3">Nouvelle consultation</h1>
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
                    <label class="form-label">Patient</label>
                    <select class="form-select" name="patientId" required>
                        <option value="">Sélectionner un patient</option>
                        <?php foreach ($options['patientId'] as $option): ?>
                            <option value="<?= e((string) $option['id']) ?>"><?= e($option['label']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Médecin</label>
                    <select class="form-select" name="medecinId" required>
                        <option value="">Sélectionner un médecin</option>
                        <?php foreach ($options['medecinId'] as $option): ?>
                            <option value="<?= e((string) $option['id']) ?>"><?= e($option['label']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Motif de consultation</label>
                    <textarea class="form-control" name="motif" rows="3" required></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Diagnostic</label>
                    <textarea class="form-control" name="diagnostique" rows="3"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Notes médicales</label>
                    <textarea class="form-control" name="notes" rows="3"></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix (FCFA)</label>
                    <input class="form-control" type="number" name="prix" min="0" step="0.01">
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Enregistrer la consultation</button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
