<?php
class MedecinController
{
    public function index(): void
    {
        require_auth();
        $medecins = db()->query('SELECT m.*, u.name, u.email, h.nom AS hopital FROM medecins m JOIN users u ON u.id=m.userId JOIN hopitaux h ON h.id=m.hopitalId ORDER BY u.name')->fetchAll();
        require dirname(__DIR__) . '/Views/medecins/index.php';
    }

    public function create(): void
    {
        require_auth();
        $error = null;
        $hospitals = db()->query('SELECT id, nom FROM hopitaux ORDER BY nom')->fetchAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                verify_csrf();
                db()->beginTransaction();
                $userId = bin2hex(random_bytes(12));
                db()->prepare("INSERT INTO users (id, name, email, role, password, mustChangePassword) VALUES (?, ?, ?, 'medecin', ?, 1)")->execute([$userId, trim($_POST['name']), trim($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT)]);
                db()->prepare('INSERT INTO medecins (userId, specialite, licence, hopitalId) VALUES (?, ?, ?, ?)')->execute([$userId, trim($_POST['specialite']), trim($_POST['licence']), (int) $_POST['hopitalId']]);
                db()->commit();
                redirect('/?page=medecins');
            } catch (Throwable $exception) {
                if (db()->inTransaction()) db()->rollBack();
                $error = 'Email, licence ou hôpital déjà utilisé.';
            }
        }
        require dirname(__DIR__) . '/Views/medecins/create.php';
    }
}
