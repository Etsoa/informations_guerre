# 01 — Structure du Projet

> **Ce fichier décrit l'arborescence du projet.** Il sert de carte de navigation pour tout nouveau développeur ou IA devant comprendre l'organisation des fichiers.

## Vue d'ensemble

Le projet **"Informations Guerre"** est une application web full-stack monorepo organisée en 4 dossiers principaux :

```
informations_guerre/
│
├── backoffice/          → API REST (Node.js / Express / Sequelize)
├── frontoffice/         → Application web SPA (React / Vite)
├── database/            → Scripts SQL d'initialisation PostgreSQL
├── docs/                → Documentation du projet (ce dossier)
│
├── .env.example         → Variables d'environnement globales (template)
├── .gitignore           → Fichiers/dossiers ignorés par Git
└── docker-compose.yml   → Orchestration des 3 services Docker
```

---

## Arborescence détaillée

### `backoffice/` — API Backend

```
backoffice/
├── src/
│   ├── config/
│   │   └── database.js          → Configuration Sequelize (connexion PostgreSQL)
│   ├── controller/
│   │   └── index.js             → Point d'entrée des contrôleurs (barrel export)
│   ├── middleware/
│   │   ├── index.js             → Point d'entrée des middlewares
│   │   ├── authentification.js  → Middleware d'authentification (Bearer token)
│   │   └── errorHandler.js      → Middleware de gestion globale des erreurs
│   ├── model/
│   │   └── index.js             → Point d'entrée des modèles Sequelize + associations
│   ├── route/
│   │   └── index.js             → Routeur principal Express (/api/*)
│   ├── service/
│   │   └── index.js             → Point d'entrée des services (logique métier)
│   ├── util/
│   │   ├── ApiResponse.js       → Classe utilitaire pour formater les réponses API
│   │   └── asyncHandler.js      → Wrapper async pour les contrôleurs (try/catch auto)
│   └── server.js                → Point d'entrée de l'application Express
│
├── .dockerignore
├── .env.example                 → Template des variables d'environnement backend
├── .gitattributes
├── .gitignore
├── Dockerfile                   → Image Docker Node.js 20 Alpine
├── jsconfig.json                → Alias de chemins pour IDE (@controller, @model, etc.)
└── package.json                 → Dépendances et scripts npm
```

### `frontoffice/` — Application Frontend

```
frontoffice/
├── src/
│   ├── api/
│   │   └── index.js             → Instance Axios configurée (intercepteurs auth + erreurs)
│   ├── assets/
│   │   ├── color/
│   │   │   └── color.js         → Palette de couleurs de l'application
│   │   └── styles/
│   │       └── global.css       → CSS global (reset + styles de base)
│   ├── components/
│   │   ├── commons/
│   │   │   └── index.js         → Barrel export des composants réutilisables
│   │   └── layouts/
│   │       └── index.js         → Barrel export des layouts (Header, Footer, Navbar, etc.)
│   ├── contexts/
│   │   └── auth.context.jsx     → Context React pour l'authentification (AuthProvider, useAuth)
│   ├── hooks/
│   │   └── useAuthorization.js  → Hook de vérification des rôles et permissions
│   ├── routes/
│   │   └── index.jsx            → Définition des routes React Router
│   ├── utils/
│   │   └── useApi.js            → Hook utilitaire pour les appels API (loading, error, CRUD)
│   ├── App.jsx                  → Composant racine (BrowserRouter + AppRoutes)
│   └── main.jsx                 → Point d'entrée React (ReactDOM.createRoot)
│
├── .dockerignore
├── .env.example                 → Template des variables d'environnement frontend
├── .gitignore
├── .htaccess                    → Réécriture URL pour SPA React (Apache)
├── apache.conf                  → Configuration Apache (proxy /api → backend)
├── Dockerfile                   → Build multi-étapes : Node (build) → Apache (serve)
├── eslint.config.js             → Configuration ESLint
├── index.html                   → Page HTML racine
├── jsconfig.json                → Alias de chemins pour IDE (@api, @components, etc.)
├── package.json                 → Dépendances et scripts npm
└── vite.config.js               → Configuration Vite (alias, proxy dev)
```

### `database/` — Scripts SQL

```
database/
├── script.sql    → Création des tables (exécuté en 1er au init Docker)
├── data.sql      → Insertion des données initiales (exécuté en 2ème)
└── reset.sql     → Script de réinitialisation (vide pour l'instant)
```

---

## Convention de nommage des fichiers

| Couche       | Convention                                | Exemple                   |
|--------------|-------------------------------------------|---------------------------|
| Contrôleur   | `nomEntite.controller.js`                 | `user.controller.js`      |
| Service      | `nomEntite.service.js`                    | `auth.service.js`         |
| Modèle       | `NomEntite.js` (PascalCase)               | `User.js`                 |
| Route        | `nomEntite.route.js`                      | `user.route.js`           |
| Composant    | `NomComposant.jsx` (PascalCase)           | `Header.jsx`              |
| Page         | `NomPage.jsx` (PascalCase)               | `Dashboard.jsx`           |
| Hook         | `useNomHook.js` (camelCase avec `use`)    | `useAuthorization.js`     |
| Context      | `nomContext.context.jsx`                  | `auth.context.jsx`        |
