<?php
declare(strict_types=1);

class MedecinController
{
    public function index(): void
    {
        require_role('admin');
        $medecins = db()->query('SELECT m.*, u.name, u.email, h.nom AS hopital FROM medecins m JOIN users u ON u.id=m.userId JOIN hopitaux h ON h.id=m.hopitalId ORDER BY u.name')->fetchAll();
        require dirname(__DIR__) . '/Views/medecins/index.php';
    }

    public function create(): void
    {
        require_role('admin');
        $error = null;
        $medecin = null;
        $hospitals = db()->query('SELECT id, nom FROM hopitaux ORDER BY nom')->fetchAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                verify_csrf();
                db()->beginTransaction();
                $userId = bin2hex(random_bytes(12));
                db()->prepare("INSERT INTO users (id, name, email, role, password, mustChangePassword) VALUES (?, ?, ?, 'medecin', ?, 1)")->execute([
                    $userId,
                    trim($_POST['name']),
                    trim($_POST['email']),
                    password_hash($_POST['password'], PASSWORD_DEFAULT)
                ]);
                db()->prepare('INSERT INTO medecins (userId, specialite, licence, hopitalId) VALUES (?, ?, ?, ?)')->execute([
                    $userId,
                    trim($_POST['specialite']),
                    trim($_POST['licence']),
                    (int) $_POST['hopitalId']
                ]);
                db()->commit();
                redirect(url('?page=medecins'), 'Médecin créé avec succès.', 'success');
            } catch (Throwable $exception) {
                if (db()->inTransaction()) db()->rollBack();
                $error = 'Email, licence ou hôpital déjà utilisé.';
                $medecin = $_POST;
            }
        }
        require dirname(__DIR__) . '/Views/medecins/create.php';
    }

    public function edit(): void
    {
        require_role('admin');
        $id = (int) ($_GET['id'] ?? 0);
        $stmt = db()->prepare('SELECT m.*, u.name, u.email FROM medecins m JOIN users u ON u.id = m.userId WHERE m.id = ?');
        $stmt->execute([$id]);
        $medecin = $stmt->fetch();
        if (!$medecin) {
            redirect(url('?page=medecins'), 'Médecin introuvable.', 'danger');
        }

        $error = null;
        $hospitals = db()->query('SELECT id, nom FROM hopitaux ORDER BY nom')->fetchAll();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            try {
                db()->beginTransaction();
                if (!empty($_POST['password'])) {
                    $stmt = db()->prepare('UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?');
                    $stmt->execute([trim($_POST['name']), trim($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT), $medecin['userId']]);
                } else {
                    $stmt = db()->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
                    $stmt->execute([trim($_POST['name']), trim($_POST['email']), $medecin['userId']]);
                }
                $stmt = db()->prepare('UPDATE medecins SET specialite = ?, licence = ?, hopitalId = ? WHERE id = ?');
                $stmt->execute([
                    trim($_POST['specialite']),
                    trim($_POST['licence']),
                    (int) $_POST['hopitalId'],
                    $id
                ]);
                db()->commit();
                redirect(url('?page=medecins'), 'Médecin mis à jour avec succès.', 'success');
            } catch (Throwable $exception) {
                if (db()->inTransaction()) db()->rollBack();
                $error = 'Impossible de mettre à jour le médecin. Vérifiez les informations saisies.';
                $medecin = array_merge($medecin, $_POST);
            }
        }
        require dirname(__DIR__) . '/Views/medecins/create.php';
    }
}
