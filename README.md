<p align="center">
  <img src="public/images/logo-sicilylines.png" alt="Logo Sicily Lines" height="90">
</p>

<h1 align="center">Sicily Lines — Gestion de flotte de ferries</h1>

<p align="center">
  Application web Laravel (architecture MVC) pour gérer la flotte de ferries d'une compagnie maritime fictive desservant la Sicile.<br>
  Projet individuel réalisé de A à Z dans le cadre du <strong>BTS SIO option SLAM</strong> (2024-2026).
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white" alt="MySQL 8">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?logo=tailwindcss&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Tests-Pest-F7A41D" alt="Pest">
</p>

---

## Sommaire

- [Contexte](#contexte)
- [Fonctionnalités](#fonctionnalités)
- [Stack technique](#stack-technique)
- [Choix techniques](#choix-techniques)
- [Architecture MVC](#architecture-mvc)
- [Modèle de données](#modèle-de-données)
- [Installation](#installation)
- [Tests](#tests)
- [Pistes d'amélioration](#pistes-damélioration)
- [Auteur](#auteur)

---

## Contexte

**Sicily Lines** est une compagnie maritime (cas d'étude du BTS SIO) qui exploite plusieurs ferries entre le continent et la Sicile. Le personnel avait besoin d'un outil interne pour :

- tenir à jour la fiche technique de chaque bateau (dimensions, vitesse, photo) ;
- savoir quels équipements sont disponibles à bord (Wifi, bar, restaurant, accès handicapés…) ;
- produire rapidement des **fiches PDF** à transmettre aux agences ou aux passagers.

L'objectif était de livrer une application web sécurisée (accès réservé au personnel connecté), simple à prendre en main et structurée proprement pour pouvoir évoluer.

## Fonctionnalités

| Domaine | Ce que fait l'application |
|---|---|
| **Accueil public** | Page vitrine avec logo, carrousel de photos de la Sicile et bouton de connexion |
| **Authentification** | Inscription, connexion, vérification d'e-mail, mot de passe oublié, modification et suppression du profil |
| **Gestion des ferries (CRUD)** | Liste paginée, création, consultation, modification et suppression (avec confirmation) |
| **Équipements** | Association de plusieurs équipements à un ferry via des cases à cocher (relation plusieurs-à-plusieurs) |
| **Photos** | Upload d'une image par ferry, stockée sur le disque `public` de Laravel |
| **Export PDF** | Fiche détaillée d'un ferry en PDF, ou liste complète de la flotte en un seul PDF |
| **Validation** | Messages d'erreur affichés dans les formulaires et anciennes valeurs conservées (`old()`) |

## Stack technique

| Couche | Technologie |
|---|---|
| Back-end | PHP 8.2+, Laravel 12 |
| Base de données | MySQL 8 (administrée via phpMyAdmin), ORM Eloquent |
| Authentification | Laravel Breeze |
| Front-end | Blade, Tailwind CSS, Alpine.js, Bootstrap 5 (page d'accueil) |
| Génération PDF | barryvdh/laravel-dompdf |
| Build front | Vite |
| Tests | Pest |

## Choix techniques

**Laravel plutôt que du PHP « from scratch »**
Le projet devait respecter une architecture MVC claire. Laravel l'impose naturellement (routes → contrôleurs → modèles → vues) et fournit d'emblée la protection CSRF, la validation des formulaires, le stockage de fichiers et la pagination. Ça m'a permis de me concentrer sur le métier plutôt que de réécrire ces briques.

**Laravel Breeze pour l'authentification**
L'application est un outil interne : aucune page de gestion ne doit être accessible sans compte. Breeze apporte un système d'authentification complet et testé (connexion, vérification d'e-mail, réinitialisation de mot de passe). Toutes les routes de gestion sont protégées par les middlewares `auth` et `verified`.

**MySQL et une table pivot pour les équipements**
Un ferry possède plusieurs équipements et un même équipement se retrouve sur plusieurs ferries. J'ai donc modélisé une relation **plusieurs-à-plusieurs** avec une table pivot `equipment_ferry`. Les clés étrangères sont en `ON DELETE CASCADE` : supprimer un ferry supprime automatiquement ses associations, ce qui évite les données orphelines.

**Contrôleur de ressource**
`Route::resource('ferries', FerryController::class)` génère en une ligne les 7 routes REST du CRUD (index, create, store, show, edit, update, destroy). Les URL sont prévisibles et le code reste lisible.

**dompdf pour les fiches PDF**
Les PDF sont générés à partir de vues Blade dédiées (`resources/views/pdf/`). Je réutilise donc le même moteur de templates que pour le site, sans dépendance externe ni service payant.

**Stockage des images sur le disque `public`**
Les photos sont enregistrées dans `storage/app/public/ferries` et seul le chemin est conservé en base (`image_path`). La base reste légère et les images sont servies directement par le serveur web.

**Tailwind CSS + Bootstrap**
L'espace connecté utilise Tailwind (fourni par Breeze) pour des formulaires cohérents. La page d'accueil vitrine utilise Bootstrap pour son composant carrousel prêt à l'emploi.

## Architecture MVC

```
Navigateur
   │  requête HTTP
   ▼
routes/web.php ──► Middleware auth / verified
   │
   ▼
FerryController (Contrôleur)
   │  ├─ valide les données du formulaire
   │  ├─ enregistre l'image sur le disque public
   │  └─ synchronise les équipements (table pivot)
   ▼
Ferry / Equipment (Modèles Eloquent) ◄──► MySQL
   │
   ▼
Vues Blade : ferries/*  (HTML)   ou   pdf/*  (PDF via dompdf)
```

Principales routes :

| Méthode | URL | Action |
|---|---|---|
| GET | `/` | Page d'accueil |
| GET | `/dashboard` | Liste des ferries (après connexion) |
| GET / POST | `/ferries`, `/ferries/create` | Lister, afficher le formulaire, créer |
| GET / PUT / DELETE | `/ferries/{ferry}` | Consulter, modifier, supprimer |
| GET | `/ferry/{id}/pdf` | Fiche PDF d'un ferry |
| GET | `/all-ferries-pdf` | PDF de toute la flotte |

## Modèle de données

```
ferries                     equipment_ferry                equipment
─────────────               ─────────────────              ─────────────
id (PK)          1 ───── *  ferry_id (FK)                  id (PK)
name                        equipment_id (FK)  * ───── 1   name
length  (m)                                                
width   (m)
speed   (nœuds)
capacity
image_path
```

Équipements fournis : Accès handicapés, Wifi, Bar, Restaurant, Toilettes, Climatisation, Pont promenade.

## Installation

**Prérequis :** PHP 8.2+, Composer, Node.js 18+, MySQL 8.

```bash
# 1. Cloner le projet
git clone https://github.com/Vazoumana/SicilyLines.git
cd SicilyLines

# 2. Installer les dépendances
composer install
npm install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate
```

Dans `.env`, renseigner la connexion MySQL :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sicilylines
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 4. Créer la base puis importer le jeu de données fourni (dump phpMyAdmin)
mysql -u root -p -e "CREATE DATABASE sicilylines CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p sicilylines < SicilyLines.db

# 5. Rendre les images accessibles et lancer l'application
php artisan storage:link
npm run build
php artisan serve
```

L'application est ensuite disponible sur `http://127.0.0.1:8000`. Créez un compte via **Connexion → S'inscrire**.

## Tests

Les tests de fonctionnalité (authentification, profil, réinitialisation de mot de passe…) sont écrits avec **Pest** :

```bash
php artisan test
```

## Pistes d'amélioration

- Gestion des **liaisons** (ports de départ et d'arrivée) et des **traversées** avec leurs horaires
- Réservation de billets côté passager
- Rôles (administrateur / employé) pour limiter la suppression de ferries
- Tests de fonctionnalité dédiés au CRUD des ferries

## Auteur

**Vazoumana BAMBA** — étudiant en Bachelor 3 Web & IA à l'EFREI, à la recherche d'une alternance en développement full-stack.

- GitHub : [@Vazoumana](https://github.com/Vazoumana)
- Portfolio : [portfolio-vazoumana.netlify.app](https://portfolio-vazoumana.netlify.app/)
- LinkedIn : [vazoumana-bamba](https://www.linkedin.com/in/vazoumana-bamba)
