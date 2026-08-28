<?php
declare(strict_types=1);

class PatientController
{
    public function index(): void
    {
        require_auth();
        $patients = db()->query('SELECT * FROM patients ORDER BY createdAt DESC')->fetchAll();
        require dirname(__DIR__) . '/Views/patients/index.php';
    }

    public function create(): void
    {
        require_auth();
        $error = null;
        $patient = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            try {
                db()->beginTransaction();
                $userId = bin2hex(random_bytes(12));
                $user = db()->prepare("INSERT INTO users (id, name, email, role, password, mustChangePassword) VALUES (?, ?, ?, 'patient', ?, 1)");
                $user->execute([$userId, trim($_POST['prenom'] . ' ' . $_POST['nom']), trim($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT)]);
                $stmt = db()->prepare('INSERT INTO patients (userId, numero_national, nom, prenom, date_naissance, lieu_naissance, sexe, situation_matrimoniale) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$userId, trim($_POST['numero_national']), trim($_POST['nom']), trim($_POST['prenom']), $_POST['date_naissance'], trim($_POST['lieu_naissance']), $_POST['sexe'], $_POST['situation_matrimoniale']]);
                db()->commit();
                redirect(url('?page=patients'), 'Patient créé avec succès.', 'success');
            } catch (Throwable $exception) {
                if (db()->inTransaction()) db()->rollBack();
                $error = 'Impossible de créer le patient. Vérifiez les données.';
                $patient = $_POST;
            }
        }
        require dirname(__DIR__) . '/Views/patients/create.php';
    }

    public function edit(): void
    {
        require_auth();
        $id = (int) ($_GET['id'] ?? 0);
        $stmt = db()->prepare('SELECT p.*, u.email FROM patients p JOIN users u ON u.id = p.userId WHERE p.id = ?');
        $stmt->execute([$id]);
        $patient = $stmt->fetch();
        if (!$patient) {
            redirect(url('?page=patients'), 'Patient introuvable.', 'danger');
        }

        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            try {
                db()->beginTransaction();
                if (!empty($_POST['password'])) {
                    $stmt = db()->prepare('UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?');
                    $stmt->execute([trim($_POST['prenom'] . ' ' . $_POST['nom']), trim($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT), $patient['userId']]);
                } else {
                    $stmt = db()->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
                    $stmt->execute([trim($_POST['prenom'] . ' ' . $_POST['nom']), trim($_POST['email']), $patient['userId']]);
                }
                $stmt = db()->prepare('UPDATE patients SET numero_national = ?, nom = ?, prenom = ?, date_naissance = ?, lieu_naissance = ?, sexe = ?, situation_matrimoniale = ? WHERE id = ?');
                $stmt->execute([
                    trim($_POST['numero_national']),
                    trim($_POST['nom']),
                    trim($_POST['prenom']),
                    $_POST['date_naissance'],
                    trim($_POST['lieu_naissance']),
                    $_POST['sexe'],
                    $_POST['situation_matrimoniale'],
                    $id
                ]);
                db()->commit();
                redirect(url('?page=patients'), 'Patient mis à jour avec succès.', 'success');
            } catch (Throwable $exception) {
                if (db()->inTransaction()) db()->rollBack();
                $error = 'Impossible de mettre à jour le patient. Vérifiez les données.';
                $patient = array_merge($patient, $_POST);
            }
        }
        require dirname(__DIR__) . '/Views/patients/create.php';
    }

    public function show(): void
    {
        require_auth();
        $stmt = db()->prepare('SELECT * FROM patients WHERE id = ?');
        $stmt->execute([(int) ($_GET['id'] ?? 0)]);
        $patient = $stmt->fetch();
        if (!$patient) {
            http_response_code(404);
            exit('Patient introuvable');
        }
        $history = db()->prepare('SELECT c.*, u.name AS medecin FROM consultations c JOIN medecins m ON m.id=c.medecinId JOIN users u ON u.id=m.userId WHERE c.patientId=? ORDER BY c.dateConsultation DESC');
        $history->execute([$patient['id']]);
        $consultations = $history->fetchAll();
        require dirname(__DIR__) . '/Views/patients/show.php';
    }
}
