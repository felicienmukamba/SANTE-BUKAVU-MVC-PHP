# 🏥 Guide & Présentation de l'Application Santé+

---

## 📌 1. Introduction & Présentation Générale

Bienvenue dans la documentation de présentation de **Santé+**, une plateforme web intégrée de gestion hospitalière, médicale et pharmaceutique conçue pour centraliser et sécuriser l'ensemble des opérations de santé.

Nous avons travaillé sur la conception et le développement d'un système complet de gestion médicale en architecture **MVC (Modèle - Vue - Contrôleur) avec PHP et MySQL**. Cette application répond aux besoins quotidiens du personnel soignant, des gestionnaires d'établissements et des patients en garantissant une traçabilité complète des soins.

---

## 🚀 2. Démarrage & Lancement avec WampServer

Pour utiliser l'application sur votre environnement local, suivez ces étapes simples :

### Étape 1 : Démarrer WampServer
1. Lancez **WampServer** depuis votre menu Démarrer ou votre bureau Windows.
2. Attendez que l'icône WampServer dans la barre des tâches devienne **verte** (ce qui indique qu'Apache et MySQL fonctionnent correctement).

### Étape 2 : Accéder à l'application
1. Ouvrez votre navigateur web préféré (Google Chrome, Firefox, Edge, etc.).
2. Saisissez l'adresse suivante dans la barre d'adresse :
   ```
   http://localhost/sante/
   ```
3. L'application charge automatiquement le portail de connexion sécurisé.

---

## 🔑 3. Connexion au Portail Santé+

Pour vous connecter à l'application :

1. Sur la page d'accueil, saisissez votre adresse email et votre mot de passe.
2. Cliquez sur le bouton **Se connecter**.

### Identifiants de démonstration disponibles :
* **Compte Administrateur :**
  * **Email :** `admin@sante.cd`
  * **Mot de passe :** `admin123`
* **Compte Médecin :**
  * **Email :** `medecin@sante.cd`
  * **Mot de passe :** `medecin123`
* **Compte patient :**
  * **Email :** `patient@sante.cd`
  * **Mot de passe :** `patient123`

---

## 📖 4. Guide Pédagogique Pas-à-Pas

### 🧑‍🤝‍🧑 A. Gestion des Patients

#### 1. Enregistrer un nouveau patient :
1. Dans le menu de navigation à gauche ou en haut, cliquez sur **Patients**.
2. Sur la page des patients, cliquez sur le bouton bleu **`+ Nouveau patient`** situé en haut à droite.
3. Remplissez le formulaire avec les données du patient :
   * **Prénom** et **Nom**
   * **Adresse email** (servira pour son compte utilisateur)
   * **Mot de passe initial** (sécurisé, minimum 8 caractères)
   * **Numéro national d'identité**
   * **Date de naissance** et **Lieu de naissance**
   * **Sexe** (Féminin / Masculin)
   * **Situation matrimoniale** (Célibataire, Marié(e), Divorcé(e), Veuf(ve))
4. Cliquez sur le bouton **`Enregistrer le patient`**. Le système crée à la fois la fiche patient et son compte utilisateur lié.

#### 2. Consulter le dossier médical :
* Dans la liste des patients, cliquez sur le bouton **`Voir`** en face du patient pour afficher l'historique complet de ses consultations et antécédents.

#### 3. Modifier les informations d'un patient :
* Cliquez sur le bouton **`Modifier`** en face du patient.
* Le formulaire s'ouvre avec toutes les informations existantes pré-remplies.
* Mettez à jour les données souhaitées (le mot de passe peut être laissé vide si vous ne souhaitez pas le changer).
* Cliquez sur **`Mettre à jour le patient`**.

---

### 👨‍⚕️ B. Gestion de l'Équipe Médicale (Médecins)

1. Cliquez sur le menu **Médecins**.
2. Pour ajouter un médecin, cliquez sur **`+ Nouveau médecin`**.
3. Renseignez :
   * Le **Nom complet** du médecin
   * Son **Email professionnel** et un mot de passe
   * Sa **Spécialité** (ex: *Médecine générale, Cardiologie, Pédiatrie*)
   * Son **Numéro de licence** médicale
   * Son **Hôpital d'affectation** dans la liste déroulante
4. Cliquez sur **`Enregistrer le médecin`**.
5. Pour modifier les informations ou réaffecter un médecin à un autre établissement, cliquez simplement sur **`Modifier`** sur la carte du médecin.

---

### 🏥 C. Gestion des Établissements Hospitaliers

1. Cliquez sur le menu **Hôpitaux**.
2. Vous pouvez visualiser en direct :
   * Le nombre total de lits
   * Le nombre de lits occupés
   * Le **taux d'occupation en pourcentage (%)**
   * Les coordonnées et les services disponibles
3. Cliquez sur **`+ Nouvel hôpital`** pour créer un établissement ou sur **`Modifier`** pour ajuster la capacité des lits et les services.

---

### 🩺 D. Consultations, Examens & Prescriptions

#### 1. Enregistrer une Consultation :
* Allez dans **Consultations** &rarr; cliquez sur **`+ Nouvelle consultation`**.
* Choisissez le **Patient** et le **Médecin** dans les listes déroulantes.
* Décrivez le **Motif**, le **Diagnostic**, les **Notes médicales** et le **Prix**.
* Cliquez sur **`Enregistrer la consultation`**.

#### 2. Demander un Examen Médical :
* Allez dans **Examens** &rarr; cliquez sur **`+ Demander un examen`**.
* Sélectionnez la consultation concernée et indiquez le type d'examen (*Analyse sanguine, Radiographie, etc.*).

#### 3. Prescrire une ordonnance médicale :
* Allez dans **Prescriptions** &rarr; cliquez sur **`+ Nouvelle prescription`**.
* Renseignez la posologie, la durée du traitement, la quantité et les instructions spéciales.

---

### 💊 E. Pharmacie, Médicaments & Délivrances

1. **Stock de Médicaments :**
   * Dans **Médicaments**, suivez en temps réel la quantité en stock, les formes pharmaceutiques, les dosages et les prix.
2. **Délivrance sécurisée :**
   * Lors d'une délivrance dans **Délivrances**, le système déduit automatiquement les quantités délivrées du stock de médicaments disponible et bloque l'opération en cas de stock insuffisant.
3. **Interactions médicamenteuses :**
   * Dans **Interactions**, enregistrez les incompatibilités entre médicaments pour prévenir les risques thérapeutiques.

---

### 🔔 F. Alertes Sanitaires & Statistiques

* **Alertes Sanitaires :** Créez des alertes (*Information, Vigilance, Critique*) avec date de fin pour notifier le personnel soignant.
* **Rapports & Statistiques :** Visualisez les indicateurs de performance clés (nombre de consultations par période, nombre de patients uniques suivis et revenus générés).

---

## 🛠️ 5. Architecture Technique & Bonnes Pratiques

* **Modèle MVC :** Séparation claire entre la logique métier (`app/Controllers`), l'accès aux données (PDO MySQL) et l'interface utilisateur (`app/Views`).
* **Sécurité renforcée :**
  * Protection contre les failles **CSRF** sur tous les formulaires avec jetons de session.
  * Requêtes préparées systématiques contre les injections **SQL**.
  * Échappement HTML systématique (`e()`) contre les failles **XSS**.
  * Hachage fort des mots de passe avec `PASSWORD_DEFAULT` (Bcrypt).
* **Système d'Édition universel :** Formulaires dynamiques pré-remplis avec contrôles d'intégrité et transactions SQL.

---

*L'équipe Santé+ vous souhaite une excellente utilisation du système !*
