<?php
$title = 'Médecins | Santé+';
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="eyebrow">ÉQUIPE MÉDICALE</p>
        <h1 class="h2 mb-0">Médecins</h1>
    </div>
    <a class="btn btn-primary" href="<?= url('?page=medecin-create') ?>">+ Nouveau médecin</a>
</div>

<div class="row g-3">
    <?php foreach ($medecins as $medecin): ?>
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="avatar"><?= e(strtoupper(substr($medecin['name'], 0, 1))) ?></div>
                        <div>
                            <h2 class="h5 mb-1"><?= e($medecin['name']) ?></h2>
                            <p class="text-primary mb-0"><?= e($medecin['specialite']) ?></p>
                        </div>
                    </div>
                    <hr>
                    <p class="small text-muted mb-1">Licence : <?= e($medecin['licence']) ?></p>
                    <p class="small text-muted mb-3"><?= e($medecin['hopital']) ?> · <?= e($medecin['email']) ?></p>
                    <div class="d-flex justify-content-end gap-2">
                        <a class="btn btn-sm btn-outline-secondary" href="<?= url('?page=medecin-edit&id=' . e((string) $medecin['id'])) ?>">Modifier</a>
                        <form action="<?= url('?page=delete&table=medecins&id=' . e((string) $medecin['id'])) ?>" method="post" class="d-inline" data-confirm="Êtes-vous sûr de vouloir supprimer ce médecin ?">
                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (!$medecins): ?>
        <div class="col-12">
            <div class="alert alert-light">Aucun médecin enregistré.</div>
        </div>
    <?php endif; ?>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
