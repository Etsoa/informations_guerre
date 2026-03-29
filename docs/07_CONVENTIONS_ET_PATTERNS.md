# 07 — Conventions & Patterns

> **Ce fichier résume les conventions de code et les patterns à suivre** pour maintenir la cohérence du projet lors de l'ajout de nouvelles fonctionnalités.

---

## Langages et style

| Aspect            | Convention                                           |
|-------------------|------------------------------------------------------|
| Backend           | JavaScript (CommonJS : `require` / `module.exports`) |
| Frontend          | JavaScript + JSX (ES Modules : `import` / `export`)  |
| Commentaires      | Français (dans tout le projet)                       |
| Nommage variables | camelCase                                            |
| Nommage classes   | PascalCase                                           |
| Nommage fichiers  | Voir table ci-dessous                                |
| Indentation       | 2 espaces                                            |
| Guillemets        | Double quotes (`"..."`)                              |

---

## Nommage des fichiers

### Backend

| Type        | Pattern                     | Exemple                |
|-------------|------------------------------|------------------------|
| Contrôleur  | `nomEntite.controller.js`    | `user.controller.js`   |
| Service     | `nomEntite.service.js`       | `auth.service.js`      |
| Modèle      | `NomEntite.js` (PascalCase)  | `User.js`              |
| Route       | `nomEntite.route.js`         | `user.route.js`        |
| Middleware  | `nomAction.js` (camelCase)   | `authentification.js`  |
| Utilitaire  | `NomUtilitaire.js`           | `ApiResponse.js`       |

### Frontend

| Type        | Pattern                       | Exemple                 |
|-------------|-------------------------------|-------------------------|
| Composant   | `NomComposant.jsx` (PascalCase) | `Header.jsx`          |
| Page        | `NomPage.jsx` (PascalCase)    | `Dashboard.jsx`         |
| Hook        | `useNomHook.js` (camelCase)   | `useAuthorization.js`   |
| Context     | `nomContext.context.jsx`      | `auth.context.jsx`      |
| Utilitaire  | `useNomUtil.js` ou `nomUtil.js` | `useApi.js`           |

---

## Barrel Exports (fichiers `index.js`)

Chaque dossier a un fichier `index.js` qui centralise les exports. C'est le seul point d'import pour les consommateurs externes :

```js
// ✅ Bon — importer depuis le barrel
const { userController } = require("../controller");

// ❌ Mauvais — importer directement le fichier
const userController = require("../controller/user.controller");
```

**Pour ajouter un nouveau module**, il faut :
1. Créer le fichier dans le bon dossier
2. L'ajouter au `index.js` du dossier

---

## Pattern complet : Ajouter une entité CRUD

Voici le workflow pour ajouter une nouvelle entité (ex: `Article`) :

### Étape 1 — Modèle (`model/Article.js`)

```js
const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const Article = sequelize.define("article", {
  // colonnes...
}, { tableName: "article", timestamps: true, underscored: true });

module.exports = Article;
```

→ Ajouter dans `model/index.js`

### Étape 2 — Service (`service/article.service.js`)

```js
const { Article } = require("../model");

const findAll = async () => Article.findAll();
const create = async (data) => Article.create(data);
// ...

module.exports = { findAll, create };
```

→ Ajouter dans `service/index.js`

### Étape 3 — Contrôleur (`controller/article.controller.js`)

```js
const asyncHandler = require("../util/asyncHandler");
const ApiResponse = require("../util/ApiResponse");
const { articleService } = require("../service");

const getAll = asyncHandler(async (req, res) => {
  const articles = await articleService.findAll();
  return ApiResponse.success(res, articles);
});

module.exports = { getAll };
```

→ Ajouter dans `controller/index.js`

### Étape 4 — Route (`route/article.route.js`)

```js
const express = require("express");
const router = express.Router();
const { articleController } = require("../controller");

router.get("/", articleController.getAll);

module.exports = router;
```

→ Monter dans `route/index.js` : `router.use("/articles", articleRoutes);`

### Étape 5 — Script SQL (`database/script.sql`)

```sql
CREATE TABLE IF NOT EXISTS article (
  id SERIAL PRIMARY KEY,
  -- colonnes...
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## Format des réponses API

Toute réponse de l'API doit suivre ce format standardisé :

```json
// Succès
{
  "success": true,
  "message": "Description du succès",
  "data": { ... }
}

// Erreur
{
  "success": false,
  "message": "Description de l'erreur"
}
```

Utiliser **exclusivement** la classe `ApiResponse` pour formater les réponses.

---

## Authentification

### Flow actuel

```
Client → Authorization: Bearer <token> → Middleware authentification → Contrôleur
```

- Le token est stocké dans `localStorage` côté frontend
- L'intercepteur Axios l'injecte automatiquement dans chaque requête
- Le middleware backend extrait et valide le token
- Sur erreur 401, le frontend supprime le token et redirige vers `/login`

### TODO

- [ ] Implémenter `jwt.verify()` dans `middleware/authentification.js`
- [ ] Ajouter `JWT_SECRET` aux variables d'environnement
- [ ] Créer le service d'authentification (`login`, `register`, etc.)

---

## Gestion des erreurs

### Backend

1. **Contrôleurs** : Wrappés avec `asyncHandler()` — les erreurs async sont automatiquement capturées
2. **Middleware `errorHandler`** : Catch-all en fin de chaîne Express, formate l'erreur en JSON
3. **Stack trace** : Incluse dans la réponse uniquement en mode `development`

### Frontend

1. **Intercepteur Axios** : Gère les erreurs 401 automatiquement
2. **Hook `useApi`** : Expose `loading` et `error` pour chaque appel API

---

## Communication Frontend ↔ Backend

| Environnement | Frontend        | Backend         | Mécanisme                      |
|---------------|-----------------|-----------------|--------------------------------|
| Développement | `localhost:5173` | `localhost:3000` | Proxy Vite (`/api` → `:3000`) |
| Production    | Apache `:80`    | Node.js `:3000`  | Proxy Apache (`/api` → `api:3000`) |

Le frontend utilise toujours des URLs relatives (`/api/...`), ce qui fonctionne dans les deux environnements grâce aux proxies.
