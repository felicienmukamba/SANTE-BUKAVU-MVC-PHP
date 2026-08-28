<?php
declare(strict_types=1);
session_start();
require dirname(__DIR__) . '/config/config.php';

$page = $_GET['page'] ?? (auth() ? 'dashboard' : 'login');
$routes = [
    'login' => ['AuthController', 'login'],
    'logout' => ['AuthController', 'logout'],
    'dashboard' => ['DashboardController', 'index'],
    'patients' => ['PatientController', 'index'],
    'patient-create' => ['PatientController', 'create'],
    'patient-edit' => ['PatientController', 'edit'],
    'patient-view' => ['PatientController', 'show'],
    'medecins' => ['MedecinController', 'index'],
    'medecin-create' => ['MedecinController', 'create'],
    'medecin-edit' => ['MedecinController', 'edit'],
    'hospitals' => ['MedicalController', 'hospitals'],
    'hospital-create' => ['MedicalController', 'hospitalCreate'],
    'hospital-edit' => ['MedicalController', 'hospitalEdit'],
    'consultations' => ['MedicalController', 'consultations'],
    'consultation-create' => ['MedicalController', 'consultationCreate'],
    'consultation-edit' => ['MedicalController', 'consultationEdit'],
    'reports' => ['MedicalController', 'reports'],
    'exams' => ['MedicalController', 'exams'],
    'exam-create' => ['MedicalController', 'examCreate'],
    'exam-edit' => ['MedicalController', 'examEdit'],
    'prescriptions' => ['MedicalController', 'prescriptions'],
    'prescription-create' => ['MedicalController', 'prescriptionCreate'],
    'prescription-edit' => ['MedicalController', 'prescriptionEdit'],
    'medicaments' => ['MedicalController', 'medicaments'],
    'medicament-create' => ['MedicalController', 'medicamentCreate'],
    'medicament-edit' => ['MedicalController', 'medicamentEdit'],
    'deliveries' => ['MedicalController', 'deliveries'],
    'delivery-create' => ['MedicalController', 'deliveryCreate'],
    'delivery-edit' => ['MedicalController', 'deliveryEdit'],
    'interactions' => ['MedicalController', 'interactions'],
    'interaction-create' => ['MedicalController', 'interactionCreate'],
    'interaction-edit' => ['MedicalController', 'interactionEdit'],
    'laboratories' => ['MedicalController', 'laboratories'],
    'lab-result-create' => ['MedicalController', 'labResultCreate'],
    'lab-result-edit' => ['MedicalController', 'labResultEdit'],
    'appointments' => ['MedicalController', 'appointments'],
    'appointment-create' => ['MedicalController', 'appointmentCreate'],
    'appointment-edit' => ['MedicalController', 'appointmentEdit'],
    'alerts' => ['MedicalController', 'alerts'],
    'alert-create' => ['MedicalController', 'alertCreate'],
    'alert-edit' => ['MedicalController', 'alertEdit'],
    'delete' => ['ActionController', 'delete'],
];

if (!isset($routes[$page])) {
    http_response_code(404);
    exit('Page introuvable');
}

[$class, $method] = $routes[$page];
require dirname(__DIR__) . '/app/Controllers/' . $class . '.php';
$controller = new $class();
$controller->$method();
