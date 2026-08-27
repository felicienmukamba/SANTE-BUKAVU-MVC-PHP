<?php
class DashboardController
{
    public function index(): void
    {
        require_auth();
        $stats = [
            'patients' => (int) db()->query('SELECT COUNT(*) FROM patients')->fetchColumn(),
            'medecins' => (int) db()->query('SELECT COUNT(*) FROM medecins')->fetchColumn(),
            'consultations' => (int) db()->query('SELECT COUNT(*) FROM consultations')->fetchColumn(),
            'rendezVous' => (int) db()->query("SELECT COUNT(*) FROM rendez_vous WHERE date >= CURDATE() AND statut = 'Planifié'")->fetchColumn(),
        ];
        $upcoming = db()->query("SELECT r.date, r.motif, p.nom, p.prenom, u.name AS medecin FROM rendez_vous r JOIN patients p ON p.id=r.patientId JOIN medecins m ON m.id=r.medecinId JOIN users u ON u.id=m.userId WHERE r.date >= NOW() ORDER BY r.date LIMIT 5")->fetchAll();
        require dirname(__DIR__) . '/Views/dashboard/index.php';
    }
}
