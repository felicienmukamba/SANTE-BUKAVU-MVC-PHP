<?php
$pageHeaderTitle = $title;
$title = $title . ' | Santé+';
require dirname(__DIR__) . '/layouts/header.php';

$tables = [
    'hospitals' => 'hopitaux',
    'consultations' => 'consultations',
    'exams' => 'examens_medicaux',
    'prescriptions' => 'prescriptions_medicales',
    'medicaments' => 'medicaments',
    'deliveries' => 'delivrances',
    'interactions' => 'interactions_medicamenteuses',
    'laboratories' => 'resultats_laboratoire',
    'appointments' => 'rendez_vous',
    'alerts' => 'alertes_sanitaires'
];

$editRoutes = [
    'hospitals' => 'hospital-edit',
    'consultations' => 'consultation-edit',
    'exams' => 'exam-edit',
    'prescriptions' => 'prescription-edit',
    'medicaments' => 'medicament-edit',
    'deliveries' => 'delivery-edit',
    'interactions' => 'interaction-edit',
    'laboratories' => 'lab-result-edit',
    'appointments' => 'appointment-edit',
    'alerts' => 'alert-edit',
];

$editRoles = [
    'hospitals' => ['admin'],
    'alerts' => ['admin'],
    'consultations' => ['admin', 'medecin'],
    'exams' => ['admin', 'medecin'],
    'prescriptions' => ['admin', 'medecin'],
    'medicaments' => ['admin', 'medecin', 'pharmacien'],
    'deliveries' => ['admin', 'medecin', 'pharmacien'],
    'interactions' => ['admin', 'medecin', 'pharmacien'],
    'laboratories' => ['admin', 'medecin', 'laborantin'],
    'appointments' => ['admin', 'medecin', 'patient'],
];

$table = $tables[$type] ?? $type;
$editRoute = $editRoutes[$type] ?? null;
$canEdit = has_role($editRoles[$type] ?? ['admin']);
$canDelete = has_role('admin');
$hasActions = ($type !== 'reports') && ($canEdit || $canDelete);
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <p class="eyebrow">GESTION MÉDICALE</p>
        <h1 class="h2 mb-0"><?= e($pageHeaderTitle) ?></h1>
    </div>
    <?php if ($createUrl): ?>
        <a class="btn btn-primary" href="<?= e($createUrl) ?>">+ <?= e($createLabel) ?></a>
    <?php endif; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <?php foreach ($columns as $label): ?>
                            <th><?= e($label) ?></th>
                        <?php endforeach; ?>
                        <?php if ($hasActions): ?>
                            <th class="text-end">Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <?php foreach ($columns as $key => $label): ?>
                                <td><?= e((string) ($row[$key] ?? '')) ?></td>
                            <?php endforeach; ?>
                            <?php if ($hasActions): ?>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <?php if ($canEdit && $editRoute && !empty($row['id'])): ?>
                                            <a class="btn btn-sm btn-outline-secondary" href="<?= url('?page=' . e($editRoute) . '&id=' . e((string)$row['id'])) ?>">Modifier</a>
                                        <?php endif; ?>
                                        <?php if ($canDelete && !empty($row['id'])): ?>
                                            <form action="<?= url('?page=delete&table=' . e($table) . '&id=' . e((string)$row['id'])) ?>" method="post" class="d-inline" data-confirm="Êtes-vous sûr de vouloir supprimer cet élément ?">
                                                <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (!$rows): ?>
                        <tr>
                            <td colspan="<?= count($columns) + ($hasActions ? 1 : 0) ?>" class="text-center text-muted py-5">Aucune donnée enregistrée.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
