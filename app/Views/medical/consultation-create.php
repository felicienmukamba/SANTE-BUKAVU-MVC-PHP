<?php

/** @var array $form */
/** @var array $options */
/** @var string|null $error */
/** @var array $data */
$form = $form ?? [];
$options = $options ?? $form['options'] ?? [];
$data = $data ?? [];
$error = $error ?? null;

$isEdit = !empty($form['isEdit']) || !empty($form['data']['id']) || !empty($data['id']);
$pageTitle = $isEdit ? 'Modifier la consultation' : 'Nouvelle consultation';
$title = $pageTitle . ' | Santé+';
$formData = $form['data'] ?? $data ?? [];
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="mb-4">
    <a href="<?= url('?page=consultations') ?>" class="text-decoration-none">&larr; Retour aux consultations</a>
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
                    <label class="form-label">Patient</label>
                    <select class="form-select" name="patientId" required>
                        <option value="">Sélectionner un patient</option>
                        <?php foreach (($options['patientId'] ?? []) as $option): ?>
                            <option value="<?= e((string) $option['id']) ?>" <?= ((string)($formData['patientId'] ?? '') === (string)$option['id']) ? 'selected' : '' ?>>
                                <?= e($option['label'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Médecin</label>
                    <select class="form-select" name="medecinId" required>
                        <option value="">Sélectionner un médecin</option>
                        <?php foreach (($options['medecinId'] ?? []) as $option): ?>
                            <option value="<?= e((string) $option['id']) ?>" <?= ((string)($formData['medecinId'] ?? '') === (string)$option['id']) ? 'selected' : '' ?>>
                                <?= e($option['label'] ?? '') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Motif de consultation</label>
                    <textarea class="form-control" name="motif" rows="3" required><?= e($formData['motif'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Diagnostic</label>
                    <textarea class="form-control" name="diagnostique" rows="3"><?= e($formData['diagnostique'] ?? '') ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Notes médicales</label>
                    <textarea class="form-control" name="notes" rows="3"><?= e($formData['notes'] ?? '') ?></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Prix (CDF)</label>
                    <input class="form-control" type="number" name="prix" min="0" step="0.01" value="<?= e((string)($formData['prix'] ?? '')) ?>">
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary"><?= $isEdit ? 'Mettre à jour la consultation' : 'Enregistrer la consultation' ?></button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>