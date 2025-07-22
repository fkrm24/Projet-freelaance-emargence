# STACK TECHNIQUE – freelance-collab

## 1. Présentation Générale

Le projet **freelance-collab** est une application web développée pour faciliter la gestion des candidatures de freelances et la gestion administrative des sociétés partenaires. Il s’agit d’un outil destiné à deux types d’utilisateurs bien distincts :

- **Utilisateurs Freelance** : Ils accèdent à la plateforme pour soumettre leur candidature via un formulaire dédié, renseigner leurs expériences, et suivre l’état de leur dossier. L’interface freelance est épurée, orientée formulaire et consultation.
- **Administrateurs** : Ils disposent d’une interface d’administration sécurisée permettant de :
    - Gérer les sociétés (création, édition, suppression)
    - Gérer les contacts rattachés à chaque société
    - Suivre et gérer les candidatures reçues
    - Gérer les expériences et références des freelances
    - Exporter des listes de contacts au format Excel
    - Accéder à un tableau de bord synthétique

L’application est pensée pour séparer clairement ces deux espaces (public/freelance et privé/admin), chacun avec ses propres routes, contrôleurs et vues Blade.

Le projet est conçu pour être facilement déployable grâce à Docker et docker-compose, ce qui simplifie la gestion de l’environnement (PHP, MySQL, Node.js, etc.) et garantit une portabilité maximale.

## 2. Stack Technique

### Backend
- **Framework** : Laravel 12.x
- **Langage** : PHP (>=8.2 recommandé)
- **Gestionnaire de dépendances** : Composer
- **Principaux packages** :
    - Authentification Laravel (native, Breeze ou Jetstream)
    - maatwebsite/excel (export Excel)
    - Autres packages à vérifier dans `composer.json`
- **Structure** : MVC (contrôleurs, modèles, vues séparés)
- **Migrations** : gestion du schéma BDD
- **Seeders** : (à compléter si utilisés)

## 2. Stack Technique

### Backend
- **Framework** : Laravel (vérifier la version exacte dans `composer.json`)
- **Langage** : PHP (>=8.1 recommandé)
- **Gestionnaire de dépendances** : Composer
- **Principaux packages** :
    - Authentification Laravel (native, Breeze ou Jetstream)
    - maatwebsite/excel (export Excel)
    - Autres packages à vérifier dans `composer.json`
- **Structure** : MVC (contrôleurs, modèles, vues séparés)
- **Migrations** : gestion du schéma BDD
- **Seeders** : (à compléter si utilisés)

### Frontend
- **Moteur de templates** : Blade
- **CSS/JS** : Bootstrap, jQuery (à préciser selon `package.json`)
- **Gestion des assets** : Laravel Mix (Webpack)

### Base de données
- **Type** : MySQL/MariaDB
- **Gestion** : Migrations Laravel
- **Variables sensibles** : `.env`

### Sécurité
- **Authentification** : Laravel Auth (sessions, middleware)
- **Protection CSRF** : Native Laravel
- **Validation des données** : Form Requests ou contrôleurs

### Docker
- **Orchestration** : docker-compose (voir `docker-compose.yml`)
- **Services** :
    - `laravel.test` : conteneur principal de l’application Laravel, ports exposés pour HTTP et Vite.
    - `mysql` : conteneur base de données MySQL, persistance via volume.
- **Volumes** : synchronisation du code source et persistance BDD.
- **Utilisation** :
    - Lancer l’environnement : `docker-compose up -d`
    - Les variables d’environnement sont gérées via `.env`.
    - Les assets sont buildés via les scripts npm dans le conteneur ou en local.

## 3. Fonctionnalités principales

### Partie Utilisateur (Freelance)
- Formulaire de candidature (accès public)
- Création de compte/utilisateur
- Suivi de sa candidature/expérience

### Partie Admin
- Authentification requise
- Dashboard d’administration
- Gestion des sociétés, contacts, expériences, références
- Export Excel des contacts d’une société (bouton “Exporter” dans `societe-detail.blade.php`)
- Gestion des rôles et permissions (si utilisé)

## 4. Points techniques importants
- **Export Excel** : Laravel Excel, route dédiée pour l’export des contacts d’une société
- **Relations Eloquent** : sociétés, contacts, expériences, références (relations à bien vérifier)
- **Gestion des fichiers** : (à compléter si upload)
- **Personnalisation du middleware/policies** : (à compléter si utilisé)
- **Configuration environnement** : `.env` (DB, mail, etc.)

## 5. Déploiement & Hébergement
- **Dépendances** : PHP, Composer, Node.js, MySQL, Docker
- **Pré-requis serveur** :
    - Docker & docker-compose installés
    - Accès SSH recommandé
    - Ports HTTP (80) et DB (3306/3307) ouverts
- **Procédure de déploiement** :
    1. Cloner le repo
    2. Copier `.env.example` en `.env` et configurer les variables
    3. Lancer `docker-compose up -d`
    4. Installer les dépendances dans le conteneur : `composer install`, `npm install`, `npm run prod`
    5. Générer la clé : `php artisan key:generate`
    6. Lancer les migrations : `php artisan migrate`
    7. (Optionnel) Lancer les seeders : `php artisan db:seed`
    8. Vérifier les permissions sur `storage/` et `bootstrap/cache/`

- **Sauvegardes** : prévoir backup régulier de la BDD (volume docker) et du dossier `storage/`
- **Sécurité** : forcer HTTPS, limiter accès SSH, tenir les dépendances à jour

## 6. Architecture du projet

L’application suit une architecture MVC typique Laravel :
- **Backend** : Contrôleurs, modèles et migrations dans `app/Http/Controllers`, `app/Models`, `database/migrations`.
- **Frontend** : Vues Blade dans `resources/views`, organisées par modules (`auth`, `dashboard`, `layouts`, etc.).
- **Séparation des espaces** :
    - **Espace Freelance** : accès public, routes sans préfixe particulier, vues dédiées au formulaire de candidature, au suivi de profil, etc.
    - **Espace Admin** : accès restreint, routes préfixées `/admin`, contrôlées par le middleware d’authentification et d’autorisation, vues spécifiques à la gestion (sociétés, contacts, profils, exports…)
- **Docker** : Facilite le déploiement et la reproductibilité de l’environnement (PHP, MySQL, Node.js, etc.) via `docker-compose.yml`.

## 7. Schéma simplifié de la base de données

Les principales tables et relations :
- **users** : informations de connexion, lien 1-N avec `profils`
- **profils** : informations personnelles et professionnelles d’un freelance, appartient à un `user`, a plusieurs `experiences`, `references`, `confidence_indices`
- **experiences** : expériences professionnelles, liées à un `profil`, peuvent avoir plusieurs `references`
- **references** : références professionnelles, liées à un `profil` et/ou une `experience`, peuvent être associées à plusieurs sociétés (via table pivot)
- **contacts** : sociétés/entreprises, peuvent avoir plusieurs actions (table `societe_actions`), plusieurs références et contacts manuels (tables pivot)
- **manual_contacts** : contacts ajoutés manuellement, liés à des sociétés
- **societe_actions** : actions/événements liés à une société
- **Tables pivots** :
    - `contact_societe` (référence <-> société)
    - `contact_societe_manuel` (contact manuel <-> société)

## 8. Organisation des routes

- **Routes Freelance (utilisateur)** :
    - Pas de préfixe particulier, accès public ou protégé par `auth`
    - Exemples :
        - `/` : page d’accueil
        - `/profil/submit` : soumission du formulaire de candidature
        - `/merci` : page de remerciement
        - `/profile` : gestion du profil (authentifié)
- **Routes Admin** :
    - Préfixe `/admin`, protégées par les middlewares `auth` et `App\Http\Middleware\Admin`
    - Exemples :
        - `/admin/dashboard` : tableau de bord admin
        - `/admin/societes` : gestion des sociétés
        - `/admin/contacts` : gestion des contacts
        - `/admin/contacts/{type}/{id}` : détail contact
        - `/admin/societes/{contact}/export-contacts` : export des contacts d’une société
        - `/admin/manualcontacts/...` : gestion des contacts manuels
    - Utilisation de groupes de routes, de préfixes et de noms (`name('admin.*')`) pour organiser l’espace admin
- **Routes API** :
    - Si présentes, définies dans `routes/api.php` (non détaillées ici)
- **Authentification** :
    - Gérée via les routes de `routes/auth.php` et les middlewares Laravel standards

## 9. Informations complémentaires
- **Documentation du code** : structure MVC Laravel classique
- **Contact technique** : (à compléter)
- **Difficultés connues** :
    - Association automatique de certaines relations à vérifier (voir mémoire précédente)

---

Ce document doit être mis à jour si la stack ou les fonctionnalités évoluent. Pour toute question technique, se référer au code ou contacter le développeur principal.
