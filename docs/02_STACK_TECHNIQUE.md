# 02 — Stack Technique

> **Ce fichier liste toutes les technologies, versions et dépendances utilisées dans le projet.**

---

## Vue d'ensemble de la stack

| Couche         | Technologie         | Version   | Rôle                                    |
|----------------|---------------------|-----------|------------------------------------------|
| **Base de données** | PostgreSQL      | 16 Alpine | Base de données relationnelle            |
| **ORM**        | Sequelize           | ^6.37.3   | Mapping objet-relationnel (Node.js → PG) |
| **Backend**    | Node.js             | 20 Alpine | Runtime JavaScript serveur               |
| **Framework API** | Express          | ^4.21.0   | Framework HTTP pour l'API REST           |
| **Frontend**   | React               | ^18.3.1   | Bibliothèque UI (composants)             |
| **Bundler**    | Vite                | ^5.4.7    | Build tool + dev server frontend         |
| **Serveur web** | Apache (httpd)     | 2.4 Alpine | Serveur de production frontend           |
| **Conteneurs** | Docker Compose      | 3.8       | Orchestration multi-conteneurs           |

---

## Dépendances Backend (`backoffice/package.json`)

### Production

| Package       | Version   | Rôle                                         |
|---------------|-----------|-----------------------------------------------|
| `express`     | ^4.21.0   | Framework web HTTP                            |
| `sequelize`   | ^6.37.3   | ORM pour PostgreSQL                           |
| `pg`          | ^8.13.0   | Driver PostgreSQL natif pour Node.js          |
| `pg-hstore`   | ^2.3.4    | Sérialisation/désérialisation hstore pour PG  |
| `cors`        | ^2.8.5    | Middleware Cross-Origin Resource Sharing       |
| `dotenv`      | ^16.4.5   | Chargement des variables d'environnement .env |

### Développement

| Package       | Version   | Rôle                                         |
|---------------|-----------|-----------------------------------------------|
| `nodemon`     | ^3.1.4    | Redémarrage automatique du serveur en dev     |

---

## Dépendances Frontend (`frontoffice/package.json`)

### Production

| Package            | Version   | Rôle                                    |
|--------------------|-----------|------------------------------------------|
| `react`            | ^18.3.1   | Bibliothèque UI                          |
| `react-dom`        | ^18.3.1   | Rendu React dans le DOM                  |
| `react-router-dom` | ^6.26.2   | Routage côté client (SPA)               |
| `axios`            | ^1.7.7    | Client HTTP pour les appels API          |

### Développement

| Package                | Version   | Rôle                                |
|------------------------|-----------|--------------------------------------|
| `vite`                 | ^5.4.7    | Build tool + HMR                     |
| `@vitejs/plugin-react` | ^4.3.1   | Plugin Vite pour React (JSX, HMR)   |
| `eslint`               | ^9.10.0  | Linting du code JavaScript           |
| `@types/react`         | ^18.3.8  | Types TypeScript pour React (IDE)    |
| `@types/react-dom`     | ^18.3.0  | Types TypeScript pour React DOM      |

---

## Variables d'environnement

### Racine (`.env.example`)

```env
DB_NAME=informations_guerre
DB_USER=postgres
DB_PASSWORD=postgres
DB_PORT=5432
```

### Backend (`backoffice/.env.example`)

```env
PORT=3000
NODE_ENV=development
DB_HOST=localhost
DB_PORT=5432
DB_NAME=nom_de_la_base
DB_USER=postgres
DB_PASSWORD=mot_de_passe
```

### Frontend (`frontoffice/.env.example`)

```env
VITE_API_BASE_URL=http://localhost:3000/api
```

> **Important** : En mode Docker, le backend utilise `DB_HOST=db` (nom du service Docker). En local, utiliser `DB_HOST=localhost`.

---

## Scripts npm

### Backend

| Script        | Commande                  | Usage                          |
|---------------|---------------------------|--------------------------------|
| `npm start`   | `node src/server.js`      | Lancement en production        |
| `npm run dev` | `nodemon src/server.js`   | Lancement en développement     |

### Frontend

| Script            | Commande        | Usage                          |
|-------------------|-----------------|--------------------------------|
| `npm run dev`     | `vite`          | Serveur de développement (HMR) |
| `npm run build`   | `vite build`    | Build de production            |
| `npm run preview` | `vite preview`  | Preview du build local         |
