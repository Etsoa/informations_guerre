# 03 — Architecture Backend (Backoffice)

> **Ce fichier détaille l'architecture du backend Express/Sequelize,** le flux des requêtes et le rôle de chaque couche.

---

## Pattern architectural : MVC + Service Layer

Le backend suit une architecture en couches inspirée du MVC avec une couche service :

```
Requête HTTP
    │
    ▼
┌─────────────────┐
│   server.js     │  → Point d'entrée, middlewares globaux (cors, json, urlencoded)
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   route/        │  → Routage : associe URL + méthode HTTP → contrôleur
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   middleware/    │  → Authentification, validation (avant le contrôleur)
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   controller/   │  → Reçoit req/res, valide les entrées, appelle le service
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   service/      │  → Logique métier pure, appelle le modèle
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   model/        │  → Modèles Sequelize (schéma, validations, associations)
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   PostgreSQL    │  → Base de données
└─────────────────┘
```

---

## Détail de chaque couche

### `server.js` — Point d'entrée

- Charge les variables d'environnement (`dotenv`)
- Initialise Express avec middlewares globaux : `cors()`, `express.json()`, `express.urlencoded()`
- Monte les routes sous le préfixe `/api`
- Connecte Sequelize à PostgreSQL et synchronise les modèles en dev (`sequelize.sync({ alter: true })`)
- Démarre le serveur sur le port configuré (défaut : `3000`)

### `config/database.js` — Configuration Sequelize

- Crée une instance `Sequelize` configurée via variables d'environnement
- Dialect : `postgres`
- Pool de connexions : max 5, idle 10s, acquire 30s
- Logging SQL activé uniquement en `development`

### `route/` — Routage

- Utilise `express.Router()`
- Chaque entité doit avoir son propre fichier : `nomEntite.route.js`
- Les routes sont montées dans `route/index.js` via `router.use("/entite", entiteRoutes)`
- Le routeur est monté sous `/api` dans `server.js`

**Pattern pour ajouter une route :**
```js
// route/user.route.js
const express = require("express");
const router = express.Router();
const { userController } = require("../controller");

router.get("/", userController.getAll);
router.post("/", userController.create);
// ...

module.exports = router;
```

### `controller/` — Contrôleurs

- Reçoivent `req` et `res`
- Valident les données d'entrée
- Appellent le service correspondant
- Retournent la réponse via `ApiResponse`
- Doivent être wrappés avec `asyncHandler` pour la gestion d'erreurs

**Pattern pour un contrôleur :**
```js
const asyncHandler = require("../util/asyncHandler");
const ApiResponse = require("../util/ApiResponse");
const { userService } = require("../service");

const getAll = asyncHandler(async (req, res) => {
  const users = await userService.findAll();
  return ApiResponse.success(res, users);
});

module.exports = { getAll };
```

### `service/` — Services (logique métier)

- Contiennent la logique métier pure
- Appellent les modèles Sequelize pour les opérations BDD
- Ne manipulent jamais `req` ni `res`
- Sont réutilisables et testables indépendamment

### `model/` — Modèles Sequelize

- Chaque modèle définit le schéma d'une table
- Les associations (hasMany, belongsTo, etc.) sont définies dans `model/index.js`
- `model/index.js` exporte tous les modèles + l'instance `sequelize`

### `middleware/` — Middlewares

#### `authentification.js`
- Vérifie la présence du header `Authorization: Bearer <token>`
- Renvoie 401 si le token est absent ou mal formaté
- **TODO** : Intégrer `jwt.verify()` pour décoder et valider le token JWT

#### `errorHandler.js`
- Middleware Express 4 arguments `(err, req, res, next)`
- Renvoie le `statusCode` de l'erreur (ou 500 par défaut)
- Inclut la stack trace en mode `development` uniquement

---

## Utilitaires (`util/`)

### `ApiResponse.js` — Format standard des réponses

Toutes les réponses API suivent ce format JSON :

```json
{
  "success": true | false,
  "message": "Description",
  "data": { ... } | null
}
```

Méthodes disponibles :

| Méthode                  | Code HTTP | Usage                     |
|--------------------------|-----------|---------------------------|
| `ApiResponse.success()`  | 200       | Succès standard           |
| `ApiResponse.created()`  | 201       | Création réussie          |
| `ApiResponse.error()`    | 500       | Erreur serveur            |
| `ApiResponse.notFound()` | 404       | Ressource non trouvée     |
| `ApiResponse.badRequest()` | 400     | Requête invalide          |

### `asyncHandler.js` — Wrapper async

Enveloppe les fonctions async des contrôleurs pour capturer automatiquement les erreurs et les passer au `errorHandler` via `next()`.

```js
const asyncHandler = (fn) => (req, res, next) => {
  Promise.resolve(fn(req, res, next)).catch(next);
};
```

---

## Alias de chemins (IDE)

Définis dans `jsconfig.json` pour la navigation dans l'IDE :

| Alias            | Chemin réel        |
|------------------|--------------------|
| `@controller/*`  | `src/controller/*` |
| `@middleware/*`   | `src/middleware/*`  |
| `@model/*`       | `src/model/*`      |
| `@route/*`       | `src/route/*`      |
| `@service/*`     | `src/service/*`    |
| `@util/*`        | `src/util/*`       |

> **Note** : Ces alias sont pour l'IDE uniquement. Node.js utilise les chemins relatifs classiques (`require("../model")`).
