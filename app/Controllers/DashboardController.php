<?php
declare(strict_types=1);

class DashboardController
{
    public function index(): void
    {
        require_auth();

        if (has_role('patient')) {
            $patientStmt = db()->prepare('SELECT id FROM patients WHERE userId = ?');
            $patientStmt->execute([auth()['id']]);
            $patientId = (int) ($patientStmt->fetchColumn() ?: 0);

            $stats = [
                'consultations' => (int) db()->query("SELECT COUNT(*) FROM consultations WHERE patientId = {$patientId}")->fetchColumn(),
                'prescriptions' => (int) db()->query("SELECT COUNT(*) FROM prescriptions_medicales p JOIN consultations c ON c.id=p.consultationId WHERE c.patientId = {$patientId}")->fetchColumn(),
                'rendezVous' => (int) db()->query("SELECT COUNT(*) FROM rendez_vous WHERE patientId = {$patientId} AND date >= CURDATE() AND statut = 'Planifié'")->fetchColumn(),
                'examens' => (int) db()->query("SELECT COUNT(*) FROM examens_medicaux e JOIN consultations c ON c.id=e.consultationId WHERE c.patientId = {$patientId}")->fetchColumn(),
            ];

            $upcoming = db()->query("SELECT r.date, r.motif, p.nom, p.prenom, u.name AS medecin FROM rendez_vous r JOIN patients p ON p.id=r.patientId JOIN medecins m ON m.id=r.medecinId JOIN users u ON u.id=m.userId WHERE r.patientId = {$patientId} AND r.date >= NOW() ORDER BY r.date LIMIT 5")->fetchAll();
            $statCards = [
                ['consultations', 'Mes Consultations', 'text-primary'],
                ['prescriptions', 'Mes Ordonnances', 'text-success'],
                ['rendezVous', 'Rendez-vous à venir', 'text-info'],
                ['examens', 'Mes Examens', 'text-warning']
            ];
        } else {
            $stats = [
                'patients' => (int) db()->query('SELECT COUNT(*) FROM patients')->fetchColumn(),
                'medecins' => (int) db()->query('SELECT COUNT(*) FROM medecins')->fetchColumn(),
                'consultations' => (int) db()->query('SELECT COUNT(*) FROM consultations')->fetchColumn(),
                'rendezVous' => (int) db()->query("SELECT COUNT(*) FROM rendez_vous WHERE date >= CURDATE() AND statut = 'Planifié'")->fetchColumn(),
            ];

            $upcoming = db()->query("SELECT r.date, r.motif, p.nom, p.prenom, u.name AS medecin FROM rendez_vous r JOIN patients p ON p.id=r.patientId JOIN medecins m ON m.id=r.medecinId JOIN users u ON u.id=m.userId WHERE r.date >= NOW() ORDER BY r.date LIMIT 5")->fetchAll();
            $statCards = [
                ['patients', 'Patients enregistrés', 'text-primary'],
                ['medecins', 'Corps médical', 'text-success'],
                ['consultations', 'Consultations', 'text-warning'],
                ['rendezVous', 'Rendez-vous à venir', 'text-info']
            ];
        }

        require dirname(__DIR__) . '/Views/dashboard/index.php';
    }
}
