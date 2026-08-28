<?php
$title = ($form['title'] ?? 'Formulaire') . ' | Santé+';
$isEdit = !empty($form['isEdit']) || !empty($form['data']['id']) || !empty($data['id']);
$formData = $form['data'] ?? $data ?? [];
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="mb-4">
    <a href="<?= url('?page=' . e($form['back'] ?? 'dashboard')) ?>" class="text-decoration-none">&larr; Retour</a>
    <h1 class="h2 mt-3"><?= e($form['title'] ?? 'Formulaire') ?></h1>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= e($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="row g-3">
                <?php foreach (($form['relations'] ?? []) as [$key, $label, $source]): ?>
                    <?php $selectedVal = $formData[$key] ?? ''; ?>
                    <div class="col-md-6">
                        <label class="form-label"><?= e($label) ?></label>
                        <select class="form-select" name="<?= e($key) ?>" required>
                            <option value="">Sélectionner <?= e($label) ?></option>
                            <?php foreach (($form['options'][$key] ?? $options[$key] ?? []) as $option): ?>
                                <option value="<?= e((string) $option['id']) ?>" <?= ((string)$selectedVal === (string)$option['id']) ? 'selected' : '' ?>>
                                    <?= e($option['label'] ?? $option['nom'] ?? '') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endforeach; ?>

                <?php foreach (($form['fields'] ?? []) as [$key, $label, $type]): ?>
                    <?php $val = $formData[$key] ?? ''; ?>
                    <div class="col-md-<?= $type === 'textarea' ? '12' : '6' ?>">
                        <label class="form-label"><?= e($label) ?></label>
                        <?php if ($type === 'textarea'): ?>
                            <textarea class="form-control" name="<?= e($key) ?>" rows="3"><?= e((string)$val) ?></textarea>
                        <?php else: ?>
                            <input class="form-control" type="<?= e($type) ?>" name="<?= e($key) ?>" value="<?= e((string)$val) ?>" required>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary"><?= $isEdit ? 'Mettre à jour' : 'Enregistrer' ?></button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
