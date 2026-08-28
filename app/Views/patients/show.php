<?php
/** @var array $patient */
/** @var array $consultations */
$patient = $patient ?? [];
$consultations = $consultations ?? [];
$title = 'Dossier patient | Santé+';
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="mb-4">
    <a href="<?= url('?page=patients') ?>" class="text-decoration-none">&larr; Retour aux patients</a>
    <h1 class="h2 mt-3"><?= e(($patient['prenom'] ?? '') . ' ' . ($patient['nom'] ?? '')) ?></h1>
    <p class="text-muted mb-0">N° national : <?= e($patient['numero_national'] ?? 'Non renseigné') ?></p>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Informations personnelles</h2>
                <dl class="row mb-0">
                    <dt class="col-6 text-muted">Naissance</dt>
                    <dd class="col-6 fw-semibold"><?= !empty($patient['date_naissance']) ? date('d/m/Y', strtotime($patient['date_naissance'])) : '-' ?></dd>

                    <dt class="col-6 text-muted">Lieu</dt>
                    <dd class="col-6"><?= e($patient['lieu_naissance'] ?? '-') ?></dd>

                    <dt class="col-6 text-muted">Sexe</dt>
                    <dd class="col-6"><?= e($patient['sexe'] ?? '-') ?></dd>

                    <dt class="col-6 text-muted">Situation</dt>
                    <dd class="col-6"><?= e($patient['situation_matrimoniale'] ?? '-') ?></dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="h5 mb-3">Historique des consultations</h2>
                <?php foreach ($consultations as $item): ?>
                    <div class="border-start border-3 border-info ps-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong><?= e($item['motif'] ?? '') ?></strong>
                            <small class="text-muted"><?= !empty($item['dateConsultation']) ? date('d/m/Y H:i', strtotime($item['dateConsultation'])) : '' ?></small>
                        </div>
                        <div class="small text-muted">Dr <?= e($item['medecin'] ?? 'Non spécifié') ?></div>
                        <?php if (!empty($item['diagnostique'])): ?>
                            <p class="mb-0 mt-1"><strong>Diagnostic :</strong> <?= e($item['diagnostique']) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($consultations)): ?>
                    <p class="text-muted mb-0">Aucune consultation enregistrée.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
