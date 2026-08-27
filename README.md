# Santé+

Application de gestion médicale en PHP natif, jQuery/Bootstrap et MySQL, structurée en MVC.

## Fonctionnalités disponibles

- Authentification par session avec mot de passe hashé et protection CSRF
- Tableau de bord avec compteurs et prochains rendez-vous
- Liste et création de patients
- Liste des médecins et de leur établissement
- Hôpitaux avec capacité, occupation, services et coordonnées géographiques
- Consultations, examens, prescriptions, rendez-vous et alertes sanitaires
- Tables d'intégration laboratoire, délivrance et interactions médicamenteuses
- Schéma MySQL converti depuis le modèle Prisma fourni

## Installation locale

1. Créer une base MySQL en exécutant `database/schema.sql`.
2. Copier `.env.example` vers `.env` et renseigner les accès MySQL.
3. Depuis la racine du projet, lancer :

```powershell
php -S localhost:8000 -t public
```

4. Ouvrir http://localhost:8000.

Comptes de test créés :

- Admin: `admin@sante.cd` / `admin123`
- Médecin: `medecin@sante.cd` / `medecin123`
- Patient: `patient@sante.cd` / `patient123`

Vous pouvez maintenant vous connecter à l'application avec ces comptes pour tester toutes les fonctionnalités.

Bootstrap et jQuery sont servis depuis `public/assets`, donc aucun gestionnaire de dépendances ni accès CDN n'est requis pour démarrer.
