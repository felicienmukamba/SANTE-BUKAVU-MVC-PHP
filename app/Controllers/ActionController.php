<?php
declare(strict_types=1);

class ActionController
{
    public function delete(): void
    {
        require_role('admin');
        verify_csrf();

        $table = $_GET['table'] ?? '';
        $id = $_GET['id'] ?? '';
        
        // Allowed tables to prevent SQL injection
        $allowedTables = [
            'patients', 'medecins', 'consultations', 'examens_medicaux', 
            'prescriptions_medicales', 'rendez_vous', 'delivrances', 
            'interactions_medicamenteuses', 'resultats_laboratoire', 'alertes_sanitaires',
            'hopitaux', 'medicaments', 'laboratoires'
        ];

        if (!in_array($table, $allowedTables) || !is_numeric($id)) {
            redirect(url('?page=dashboard'), 'Paramètres de suppression invalides.', 'danger');
        }

        try {
            $stmt = db()->prepare('DELETE FROM ' . $table . ' WHERE id = ?');
            $stmt->execute([(int)$id]);
            
            // Go back to the referrer or dashboard
            $back = $_SERVER['HTTP_REFERER'] ?? url('?page=dashboard');
            redirect($back, 'Suppression effectuée avec succès.', 'success');
        } catch (PDOException $e) {
            $back = $_SERVER['HTTP_REFERER'] ?? url('?page=dashboard');
            redirect($back, 'Impossible de supprimer cet élément (il est probablement utilisé ailleurs).', 'danger');
        }
    }
}
