<?php $title = 'Nouvel hôpital | Santé+'; require dirname(__DIR__) . '/layouts/header.php'; ?>
<div class="mb-4">
    <a href="/?page=hospitals" class="text-decoration-none">&larr; Retour aux hôpitaux</a>
    <h1 class="h2 mt-3">Nouvel hôpital</h1>
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
                    <label class="form-label">Nom de l'établissement</label>
                    <input class="form-control" name="nom" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Téléphone</label>
                    <input class="form-control" name="telephone" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Adresse</label>
                    <input class="form-control" name="adresse" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nombre de lits</label>
                    <input class="form-control" type="number" name="lits" min="0" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Lits occupés</label>
                    <input class="form-control" type="number" name="litsOccupes" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Services (séparés par des virgules)</label>
                    <input class="form-control" name="services" placeholder="Urgences, Chirurgie, Pédiatrie">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Latitude</label>
                    <input class="form-control" type="number" step="any" name="latitude">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Longitude</label>
                    <input class="form-control" type="number" step="any" name="longitude">
                </div>
            </div>
            <div class="mt-4">
                <button class="btn btn-primary">Enregistrer l'hôpital</button>
            </div>
        </form>
    </div>
</div>
<?php require dirname(__DIR__) . '/layouts/footer.php'; ?>
