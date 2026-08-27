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
    'patient-view' => ['PatientController', 'show'],
    'medecins' => ['MedecinController', 'index'],
    'medecin-create' => ['MedecinController', 'create'],
    'hospitals' => ['MedicalController', 'hospitals'],
    'hospital-create' => ['MedicalController', 'hospitalCreate'],
    'consultations' => ['MedicalController', 'consultations'],
    'reports' => ['MedicalController', 'reports'],
    'consultation-create' => ['MedicalController', 'consultationCreate'],
    'exams' => ['MedicalController', 'exams'],
    'exam-create' => ['MedicalController', 'examCreate'],
    'prescriptions' => ['MedicalController', 'prescriptions'],
    'prescription-create' => ['MedicalController', 'prescriptionCreate'],
    'medicaments' => ['MedicalController', 'medicaments'],
    'medicament-create' => ['MedicalController', 'medicamentCreate'],
    'deliveries' => ['MedicalController', 'deliveries'],
    'delivery-create' => ['MedicalController', 'deliveryCreate'],
    'interactions' => ['MedicalController', 'interactions'],
    'interaction-create' => ['MedicalController', 'interactionCreate'],
    'laboratories' => ['MedicalController', 'laboratories'],
    'lab-result-create' => ['MedicalController', 'labResultCreate'],
    'appointments' => ['MedicalController', 'appointments'],
    'appointment-create' => ['MedicalController', 'appointmentCreate'],
    'alerts' => ['MedicalController', 'alerts'],
    'alert-create' => ['MedicalController', 'alertCreate'],
];

if (!isset($routes[$page])) { http_response_code(404); exit('Page introuvable'); }
[$class, $method] = $routes[$page];
require dirname(__DIR__) . '/app/Controllers/' . $class . '.php';
$controller = new $class();
$controller->$method();
