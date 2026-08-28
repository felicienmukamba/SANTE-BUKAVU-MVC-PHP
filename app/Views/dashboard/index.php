<?php
$title = 'Tableau de bord | Santé+';
require dirname(__DIR__) . '/layouts/header.php';
?>
<div class="d-flex justify-content-between align-items-end mb-4">
    <div>
        <p class="eyebrow">CENTRE DE PILOTAGE</p>
        <h1 class="h2 mb-1">Bonjour, <?= e(auth()['name'] ?? 'Utilisateur') ?></h1>
        <p class="text-muted mb-0">
            <?= has_role('patient') ? 'Bienvenue sur votre espace santé personnel.' : 'Voici l’activité de votre établissement de santé.' ?>
        </p>
    </div>
</div>

<div class="row g-3 mb-4">
    <?php foreach (($statCards ?? []) as $stat): ?>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="small text-muted"><?= e($stat[1]) ?></div>
                <div class="display-6 fw-bold <?= e($stat[2]) ?>"><?= (int)($stats[$stat[0]] ?? 0) ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h5 mb-0">Prochains rendez-vous</h2>
            <?php if (has_role(['admin', 'medecin'])): ?>
                <a href="<?= url('?page=patients') ?>" class="btn btn-sm btn-outline-primary">Voir les patients</a>
            <?php else: ?>
                <a href="<?= url('?page=appointments') ?>" class="btn btn-sm btn-outline-primary">Mes rendez-vous</a>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Médecin</th>
                        <th>Motif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($upcoming ?? []) as $item): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($item['date'])) ?></td>
                            <td><?= e(($item['prenom'] ?? '') . ' ' . ($item['nom'] ?? '')) ?></td>
                            <td><?= e($item['medecin'] ?? '') ?></td>
                            <td><?= e($item['motif'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($upcoming)): ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">Aucun rendez-vous planifié.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
