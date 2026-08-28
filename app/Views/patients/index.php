<?php
$title = 'Patients | Santé+';
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="eyebrow">DOSSIER PATIENT</p>
        <h1 class="h2">Patients</h1>
    </div>
    <?php if (has_role(['admin', 'medecin'])): ?>
        <a class="btn btn-primary" href="<?= url('?page=patient-create') ?>">+ Nouveau patient</a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Identité</th>
                        <th>N° national</th>
                        <th>Date de naissance</th>
                        <th>Sexe</th>
                        <th>Situation</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td class="fw-semibold"><?= e($patient['prenom'] . ' ' . $patient['nom']) ?></td>
                            <td><?= e($patient['numero_national']) ?></td>
                            <td><?= date('d/m/Y', strtotime($patient['date_naissance'])) ?></td>
                            <td><?= e($patient['sexe']) ?></td>
                            <td><?= e($patient['situation_matrimoniale']) ?></td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a class="btn btn-sm btn-outline-primary" href="<?= url('?page=patient-view&id=' . e((string) $patient['id'])) ?>">Voir</a>
                                    <?php if (has_role(['admin', 'medecin'])): ?>
                                        <a class="btn btn-sm btn-outline-secondary" href="<?= url('?page=patient-edit&id=' . e((string) $patient['id'])) ?>">Modifier</a>
                                    <?php endif; ?>
                                    <?php if (has_role('admin')): ?>
                                        <form action="<?= url('?page=delete&table=patients&id=' . e((string) $patient['id'])) ?>" method="post" class="d-inline" data-confirm="Êtes-vous sûr de vouloir supprimer ce patient ?">
                                            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$patients): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">Aucun patient enregistré.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
