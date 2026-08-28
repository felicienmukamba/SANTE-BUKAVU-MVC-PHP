<?php
class MedicalController
{
    private function page(string $type, string $title, array $rows, array $columns, ?string $createUrl = null, ?string $createLabel = null, array $extra = []): void
    {
        require_auth();
        require dirname(__DIR__) . '/Views/medical/index.php';
    }

    private function save(string $sql, array $values, string $redirectPage): void
    {
        verify_csrf();
        db()->prepare($sql)->execute($values);
        redirect(url('?page=' . $redirectPage));
    }

    public function hospitals(): void
    {
        $rows = db()->query('SELECT *, CASE WHEN lits > 0 THEN ROUND((litsOccupes / lits) * 100, 1) ELSE 0 END AS occupation FROM hopitaux ORDER BY nom')->fetchAll();
        $this->page('hospitals', 'Hôpitaux', $rows, ['nom' => 'Établissement', 'adresse' => 'Adresse', 'telephone' => 'Téléphone', 'lits' => 'Lits', 'litsOccupes' => 'Occupés', 'occupation' => 'Occupation %', 'services' => 'Services'], url('?page=hospital-create'), 'Nouvel hôpital');
    }

    public function hospitalCreate(): void
    {
        require_auth(); $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { try { $this->save('INSERT INTO hopitaux (nom, adresse, telephone, email, lits, litsOccupes, services, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)', [trim($_POST['nom']), trim($_POST['adresse']), trim($_POST['telephone']), trim($_POST['email']), (int) $_POST['lits'], (int) $_POST['litsOccupes'], trim($_POST['services']), $_POST['latitude'] ?: null, $_POST['longitude'] ?: null], 'hospitals'); } catch (Throwable $exception) { $error = 'Impossible d’enregistrer cet établissement.'; } }
        require dirname(__DIR__) . '/Views/medical/hospital-create.php';
    }

    public function consultations(): void
    { $rows = db()->query('SELECT c.*, CONCAT(p.prenom, " ", p.nom) patient, u.name medecin FROM consultations c JOIN patients p ON p.id=c.patientId JOIN medecins m ON m.id=c.medecinId JOIN users u ON u.id=m.userId ORDER BY c.dateConsultation DESC')->fetchAll(); $this->page('consultations', 'Consultations', $rows, ['dateConsultation'=>'Date','patient'=>'Patient','medecin'=>'Médecin','motif'=>'Motif','diagnostique'=>'Diagnostic'], url('?page=consultation-create'), 'Nouvelle consultation'); }
    public function consultationCreate(): void
    { $this->relationForm('consultation', 'Nouvelle consultation', [['patientId','Patient','patients'],['medecinId','Médecin','medecins']], [['motif','Motif','textarea'],['diagnostique','Diagnostic','textarea'],['notes','Notes médicales','textarea'],['prix','Prix','number']], 'consultations', 'consultation-create'); }
    public function reports(): void
    { $rows = db()->query('SELECT DATE_FORMAT(dateConsultation, "%Y-%m") periode, COUNT(*) consultations, COUNT(DISTINCT patientId) patients, COALESCE(SUM(prix), 0) revenus FROM consultations GROUP BY periode ORDER BY periode DESC')->fetchAll(); $this->page('reports', 'Rapports statistiques', $rows, ['periode'=>'Période','consultations'=>'Consultations','patients'=>'Patients suivis','revenus'=>'Revenus'], null, null); }

    public function exams(): void
    { $rows = db()->query('SELECT e.*, e.typeExamen, CONCAT(p.prenom, " ", p.nom) patient FROM examens_medicaux e JOIN consultations c ON c.id=e.consultationId JOIN patients p ON p.id=c.patientId ORDER BY e.dateExamen DESC')->fetchAll(); $this->page('exams', 'Examens médicaux', $rows, ['dateExamen'=>'Date','patient'=>'Patient','typeExamen'=>'Type','statut'=>'Statut','resultat'=>'Résultat'], url('?page=exam-create'), 'Demander un examen'); }
    public function examCreate(): void
    { $this->relationForm('exam', 'Demander un examen', [['consultationId','Consultation','consultations']], [['typeExamen','Type d’examen','text'],['prix','Prix','number']], 'exams', 'exam-create'); }

    public function prescriptions(): void
    { $rows = db()->query('SELECT p.*, CONCAT(pa.prenom, " ", pa.nom) patient FROM prescriptions_medicales p JOIN consultations c ON c.id=p.consultationId JOIN patients pa ON pa.id=c.patientId ORDER BY p.datePrescription DESC')->fetchAll(); $this->page('prescriptions', 'Prescriptions médicales', $rows, ['datePrescription'=>'Date','patient'=>'Patient','posologie'=>'Posologie','dureeTraitement'=>'Durée','statut'=>'Statut'], url('?page=prescription-create'), 'Nouvelle prescription'); }
    public function prescriptionCreate(): void
    { $this->relationForm('prescription', 'Nouvelle prescription', [['consultationId','Consultation','consultations']], [['posologie','Posologie','textarea'],['dureeTraitement','Durée du traitement','text'],['quantite','Quantité','text'],['instruction','Instructions','textarea']], 'prescriptions', 'prescription-create'); }

    public function medicaments(): void
    { $rows = db()->query('SELECT * FROM medicaments ORDER BY nomCommercial')->fetchAll(); $this->page('medicaments', 'Stock de médicaments', $rows, ['nomCommercial'=>'Nom commercial','nomGenerique'=>'Nom générique','dosage'=>'Dosage','formePharmaceutique'=>'Forme','quantiteEnStock'=>'Stock','prix'=>'Prix'], url('?page=medicament-create'), 'Nouveau médicament'); }
    public function medicamentCreate(): void
    { $this->simpleForm('Nouveau médicament', 'medicaments', [['nomCommercial','Nom commercial','text'],['nomGenerique','Nom générique','text'],['dosage','Dosage','text'],['formePharmaceutique','Forme pharmaceutique','text'],['voieAdministration','Voie d’administration','text'],['prix','Prix','number'],['quantiteEnStock','Quantité en stock','number'],['description','Description','textarea']], 'medicaments'); }

    public function deliveries(): void
    { $rows = db()->query('SELECT d.*, m.nomCommercial medicament, d.quantite, d.dateDelivrance FROM delivrances d JOIN medicaments m ON m.id=d.medicamentId ORDER BY d.dateDelivrance DESC')->fetchAll(); $this->page('deliveries', 'Délivrances', $rows, ['dateDelivrance'=>'Date','medicament'=>'Médicament','quantite'=>'Quantité'], url('?page=delivery-create'), 'Enregistrer une délivrance'); }
    public function deliveryCreate(): void
    { $this->relationForm('delivery', 'Enregistrer une délivrance', [['prescriptionId','Prescription','prescriptions'],['medicamentId','Médicament','medicaments']], [['quantite','Quantité délivrée','number']], 'deliveries'); }

    public function interactions(): void
    { $rows = db()->query('SELECT i.*, m.nomCommercial medicament, a.nomCommercial associe FROM interactions_medicamenteuses i JOIN medicaments m ON m.id=i.medicamentId JOIN medicaments a ON a.id=i.medicamentAssocieId ORDER BY m.nomCommercial')->fetchAll(); $this->page('interactions', 'Interactions médicamenteuses', $rows, ['medicament'=>'Médicament','associe'=>'Associé','niveau'=>'Niveau','description'=>'Description'], url('?page=interaction-create'), 'Nouvelle interaction'); }
    public function interactionCreate(): void
    { $this->relationForm('interaction', 'Nouvelle interaction', [['medicamentId','Médicament','medicaments'],['medicamentAssocieId','Médicament associé','medicaments']], [['niveau','Niveau','text'],['description','Description','textarea']], 'interactions'); }

    public function laboratories(): void
    { $rows = db()->query('SELECT r.*, l.nom laboratoire, e.typeExamen, r.statut FROM resultats_laboratoire r JOIN laboratoires l ON l.id=r.laboratoireId JOIN examens_medicaux e ON e.id=r.examenId ORDER BY r.id DESC')->fetchAll(); $this->page('laboratories', 'Suivi laboratoire', $rows, ['typeExamen'=>'Examen','laboratoire'=>'Laboratoire','referenceExterne'=>'Référence','statut'=>'Statut','resultat'=>'Résultat'], url('?page=lab-result-create'), 'Ajouter un résultat'); }
    public function labResultCreate(): void
    { $this->relationForm('labresult', 'Ajouter un résultat laboratoire', [['examenId','Examen','exams'],['laboratoireId','Laboratoire','laboratories']], [['referenceExterne','Référence externe','text'],['resultat','Résultat','textarea'],['statut','Statut','text']], 'laboratories'); }

    public function appointments(): void
    { $rows = db()->query('SELECT r.*, CONCAT(p.prenom, " ", p.nom) patient, u.name medecin FROM rendez_vous r JOIN patients p ON p.id=r.patientId JOIN medecins m ON m.id=r.medecinId JOIN users u ON u.id=m.userId ORDER BY r.date')->fetchAll(); $this->page('appointments', 'Rendez-vous', $rows, ['date'=>'Date','patient'=>'Patient','medecin'=>'Médecin','motif'=>'Motif','statut'=>'Statut'], url('?page=appointment-create'), 'Nouveau rendez-vous'); }
    public function appointmentCreate(): void
    { $this->relationForm('appointment', 'Nouveau rendez-vous', [['patientId','Patient','patients'],['medecinId','Médecin','medecins']], [['date','Date et heure','datetime-local'],['motif','Motif','textarea']], 'appointments'); }

    public function alerts(): void
    { $rows = db()->query('SELECT * FROM alertes_sanitaires ORDER BY dateDebut DESC')->fetchAll(); $this->page('alerts', 'Alertes sanitaires', $rows, ['titre'=>'Titre','niveau'=>'Niveau','statut'=>'Statut','description'=>'Description','dateDebut'=>'Début'], url('?page=alert-create'), 'Nouvelle alerte'); }
    public function alertCreate(): void
    { require_auth(); $error = null; if ($_SERVER['REQUEST_METHOD'] === 'POST') { try { $this->save('INSERT INTO alertes_sanitaires (titre, description, niveau, statut, dateFin) VALUES (?, ?, ?, ?, ?)', [trim($_POST['titre']), trim($_POST['description']), $_POST['niveau'], $_POST['statut'], $_POST['dateFin'] ?: null], 'alerts'); } catch (Throwable $exception) { $error = 'Impossible d’enregistrer l’alerte.'; } } require dirname(__DIR__) . '/Views/medical/alert-create.php'; }

    private function simpleForm(string $title, string $table, array $fields, string $redirectPage): void
    { require_auth(); $error = null; if ($_SERVER['REQUEST_METHOD'] === 'POST') { try { $this->save('INSERT INTO ' . $table . ' (' . implode(',', array_column($fields, 0)) . ') VALUES (' . implode(',', array_fill(0, count($fields), '?')) . ')', array_map(fn($field) => $_POST[$field[0]] ?? null, $fields), $redirectPage); } catch (Throwable $exception) { $error = 'Vérifiez les données saisies.'; } } $form = ['title'=>$title,'back'=>$redirectPage,'fields'=>$fields]; require dirname(__DIR__) . '/Views/medical/form.php'; }

    private function relationForm(string $kind, string $title, array $relations, array $fields, string $redirectPage, ?string $view = null): void
    { require_auth(); $error = null; $options = []; foreach ($relations as [$key, $label, $source]) { $options[$key] = match ($source) { 'patients' => db()->query('SELECT id, CONCAT(prenom, " ", nom) label FROM patients ORDER BY nom')->fetchAll(), 'medecins' => db()->query('SELECT m.id, u.name label FROM medecins m JOIN users u ON u.id=m.userId ORDER BY u.name')->fetchAll(), 'consultations' => db()->query('SELECT c.id, CONCAT("#", c.id, " - ", p.prenom, " ", p.nom) label FROM consultations c JOIN patients p ON p.id=c.patientId ORDER BY c.id DESC')->fetchAll(), 'prescriptions' => db()->query('SELECT id, CONCAT("#", id, " - ", datePrescription) label FROM prescriptions_medicales ORDER BY id DESC')->fetchAll(), 'medicaments' => db()->query('SELECT id, nomCommercial label FROM medicaments ORDER BY nomCommercial')->fetchAll(), 'exams' => db()->query('SELECT id, CONCAT("#", id, " - ", typeExamen) label FROM examens_medicaux ORDER BY id DESC')->fetchAll(), 'laboratories' => db()->query('SELECT id, nom label FROM laboratoires WHERE actif=1 ORDER BY nom')->fetchAll(), }; } if ($_SERVER['REQUEST_METHOD'] === 'POST') { try { $data = array_merge(array_map(fn($relation) => $_POST[$relation[0]], $relations), array_map(fn($field) => $_POST[$field[0]] ?? null, $fields)); $table = ['consultation'=>'consultations','exam'=>'examens_medicaux','prescription'=>'prescriptions_medicales','appointment'=>'rendez_vous','delivery'=>'delivrances','interaction'=>'interactions_medicamenteuses','labresult'=>'resultats_laboratoire'][$kind]; $columns = array_merge(array_column($relations, 0), array_column($fields, 0)); if ($kind === 'delivery') { db()->beginTransaction(); $stock = db()->prepare('SELECT quantiteEnStock FROM medicaments WHERE id=? FOR UPDATE'); $stock->execute([(int) $_POST['medicamentId']]); $available = (int) $stock->fetchColumn(); $quantity = (int) $_POST['quantite']; if ($quantity < 1 || $available < $quantity) throw new RuntimeException('Stock insuffisant.'); db()->prepare('INSERT INTO delivrances (prescriptionId, medicamentId, quantite, delivrePar) VALUES (?, ?, ?, ?)')->execute([(int) $_POST['prescriptionId'], (int) $_POST['medicamentId'], $quantity, auth()['id']]); db()->prepare('UPDATE medicaments SET quantiteEnStock=quantiteEnStock-? WHERE id=?')->execute([$quantity, (int) $_POST['medicamentId']]); db()->commit(); redirect(url('?page=deliveries')); } $this->save('INSERT INTO ' . $table . ' (' . implode(',', $columns) . ') VALUES (' . implode(',', array_fill(0, count($columns), '?')) . ')', $data, $redirectPage); } catch (Throwable $exception) { if (db()->inTransaction()) db()->rollBack(); $error = $exception->getMessage() ?: 'Vérifiez les données saisies et les relations sélectionnées.'; } } if ($view) { require dirname(__DIR__) . '/Views/medical/' . $view . '.php'; } else { $form = ['title'=>$title,'back'=>$redirectPage,'fields'=>$fields,'relations'=>$relations]; require dirname(__DIR__) . '/Views/medical/form.php'; } }
}
