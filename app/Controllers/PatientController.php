<?php
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            verify_csrf();
            try {
                db()->beginTransaction();
                $userId = bin2hex(random_bytes(12));
                $user = db()->prepare("INSERT INTO users (id, name, email, role, password, mustChangePassword) VALUES (?, ?, ?, 'patient', ?, 1)");
                $user->execute([$userId, trim($_POST['prenom'] . ' ' . $_POST['nom']), trim($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT)]);
                $stmt = db()->prepare('INSERT INTO patients (userId, numero_national, nom, prenom, date_naissance, lieu_naissance, sexe, situation_matrimoniale) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$userId, trim($_POST['numero_national']), trim($_POST['nom']), trim($_POST['prenom']), $_POST['date_naissance'], trim($_POST['lieu_naissance']), $_POST['sexe'], $_POST['situation_matrimoniale']]);
                db()->commit(); redirect(url('?page=patients'));
            } catch (Throwable $exception) { if (db()->inTransaction()) db()->rollBack(); $error = 'Impossible de créer le patient. Vérifiez les données.'; }
        }
        require dirname(__DIR__) . '/Views/patients/create.php';
    }

    public function show(): void
    {
        require_auth();
        $stmt = db()->prepare('SELECT * FROM patients WHERE id = ?');
        $stmt->execute([(int) ($_GET['id'] ?? 0)]);
        $patient = $stmt->fetch();
        if (!$patient) { http_response_code(404); exit('Patient introuvable'); }
        $history = db()->prepare('SELECT c.*, u.name AS medecin FROM consultations c JOIN medecins m ON m.id=c.medecinId JOIN users u ON u.id=m.userId WHERE c.patientId=? ORDER BY c.dateConsultation DESC');
        $history->execute([$patient['id']]);
        $consultations = $history->fetchAll();
        require dirname(__DIR__) . '/Views/patients/show.php';
    }
}
