<?php
$currentPage = $_GET['page'] ?? 'login';
$isLoginPage = !auth();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title ?? 'Santé+') ?></title>
  <link href="<?= asset('dist/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= asset('css/app.css') ?>" rel="stylesheet">
</head>
<body>
<?php if ($isLoginPage): ?>
<!-- ═══ LOGIN LAYOUT (no sidebar) ═══ -->
<?php else: ?>
<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar" id="sidebar">
  <a class="sidebar-brand" href="<?= url('?page=dashboard') ?>">
    <div class="sidebar-brand-icon">+</div>
    <div class="sidebar-brand-text">SANTÉ<span>+</span></div>
  </a>

  <nav class="sidebar-nav">
    <span class="sidebar-section-label">Principal</span>

    <a class="sidebar-link <?= $currentPage === 'dashboard' ? 'active' : '' ?>" href="<?= url('?page=dashboard') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      <span class="sidebar-link-text">Tableau de bord</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['patients','patient-create','patient-view']) ? 'active' : '' ?>" href="<?= url('?page=patients') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      <span class="sidebar-link-text">Patients</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['medecins','medecin-create']) ? 'active' : '' ?>" href="<?= url('?page=medecins') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6 6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"/><path d="M8 15v1a6 6 0 0 0 6 6 6 6 0 0 0 6-6v-4"/><circle cx="20" cy="10" r="2"/></svg>
      <span class="sidebar-link-text">Médecins</span>
    </a>

    <span class="sidebar-section-label">Activité médicale</span>

    <a class="sidebar-link <?= in_array($currentPage, ['consultations','consultation-create']) ? 'active' : '' ?>" href="<?= url('?page=consultations') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      <span class="sidebar-link-text">Consultations</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['exams','exam-create']) ? 'active' : '' ?>" href="<?= url('?page=exams') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
      <span class="sidebar-link-text">Examens</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['prescriptions','prescription-create']) ? 'active' : '' ?>" href="<?= url('?page=prescriptions') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 20H4a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2h3.93a2 2 0 0 1 1.66.9l.82 1.2a2 2 0 0 0 1.66.9H20a2 2 0 0 1 2 2v2"/><circle cx="18" cy="18" r="3"/><path d="m19.5 16.5-3 3"/></svg>
      <span class="sidebar-link-text">Prescriptions</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['medicaments','medicament-create']) ? 'active' : '' ?>" href="<?= url('?page=medicaments') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg>
      <span class="sidebar-link-text">Stock médicaments</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['deliveries','delivery-create']) ? 'active' : '' ?>" href="<?= url('?page=deliveries') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
      <span class="sidebar-link-text">Délivrances</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['interactions','interaction-create']) ? 'active' : '' ?>" href="<?= url('?page=interactions') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      <span class="sidebar-link-text">Interactions</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['appointments','appointment-create']) ? 'active' : '' ?>" href="<?= url('?page=appointments') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <span class="sidebar-link-text">Rendez-vous</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['laboratories','lab-result-create']) ? 'active' : '' ?>" href="<?= url('?page=laboratories') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 2v17.5A2.5 2.5 0 0 1 6.5 22 2.5 2.5 0 0 1 4 19.5V17"/><path d="M15 2v17.5a2.5 2.5 0 0 0 2.5 2.5 2.5 2.5 0 0 0 2.5-2.5V17"/><path d="M5 2h14"/><path d="M4 17h16"/></svg>
      <span class="sidebar-link-text">Laboratoire</span>
    </a>

    <span class="sidebar-section-label">Gestion</span>

    <a class="sidebar-link <?= in_array($currentPage, ['hospitals','hospital-create']) ? 'active' : '' ?>" href="<?= url('?page=hospitals') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M9 8h1"/><path d="M9 12h1"/><path d="M9 16h1"/><path d="M14 8h1"/><path d="M14 12h1"/><path d="M14 16h1"/><path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>
      <span class="sidebar-link-text">Hôpitaux</span>
    </a>

    <a class="sidebar-link <?= in_array($currentPage, ['alerts','alert-create']) ? 'active' : '' ?>" href="<?= url('?page=alerts') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
      <span class="sidebar-link-text">Alertes</span>
    </a>

    <a class="sidebar-link <?= $currentPage === 'reports' ? 'active' : '' ?>" href="<?= url('?page=reports') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      <span class="sidebar-link-text">Rapports</span>
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="sidebar-avatar"><?= strtoupper(mb_substr(auth()['name'] ?? '', 0, 1)) ?></div>
      <div class="sidebar-user-info">
        <div class="sidebar-user-name"><?= e(auth()['name']) ?></div>
        <div class="sidebar-user-role">Administrateur</div>
      </div>
    </div>
    <a class="sidebar-logout" href="<?= url('?page=logout') ?>">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      <span class="sidebar-link-text">Déconnexion</span>
    </a>
  </div>
</aside>

<!-- ═══ BACKDROP (mobile) ═══ -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<!-- ═══ TOP BAR ═══ -->
<header class="topbar" id="topbar">
  <div class="topbar-left">
    <button class="topbar-toggle" id="sidebarToggle" title="Basculer le menu">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
  </div>
  <div class="topbar-right">
    <span class="topbar-date"><?= date('d/m/Y') ?></span>
  </div>
</header>

<!-- ═══ MAIN CONTENT ═══ -->
<main class="main-content" id="mainContent">
<?php endif; ?>
