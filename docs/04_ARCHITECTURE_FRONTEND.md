# 04 — Architecture Frontend (Frontoffice)

> **Ce fichier détaille l'architecture du frontend React/Vite,** les patterns utilisés et le rôle de chaque module.

---

## Vue d'ensemble

Le frontend est une **Single Page Application (SPA)** construite avec React 18 et Vite, servie en production via Apache.

```
Point d'entrée
    │
    ▼
┌───────────────────┐
│   main.jsx        │  → Monte React dans le DOM, importe le CSS global
└────────┬──────────┘
         │
         ▼
┌───────────────────┐
│   App.jsx         │  → Wrapping avec BrowserRouter, rend AppRoutes
└────────┬──────────┘
         │
         ▼
┌───────────────────┐
│   routes/         │  → Définition des routes (publiques, protégées, 404)
└────────┬──────────┘
         │
    ┌────┴────────────────────────────┐
    │                                 │
    ▼                                 ▼
┌──────────────┐            ┌──────────────────┐
│  Pages       │            │  Layouts         │
│  (@pages/)   │            │  (@components/   │
│              │            │   layouts/)      │
└──────┬───────┘            └──────────────────┘
       │
       ▼
┌──────────────────┐
│  Components      │  → Composants réutilisables (@components/commons/)
└──────┬───────────┘
       │
       ├──── contexts/    → État global (Auth, etc.)
       ├──── hooks/       → Hooks personnalisés (useAuthorization, etc.)
       ├──── utils/       → Utilitaires (useApi, etc.)
       └──── api/         → Configuration Axios + intercepteurs
```

---

## Détail de chaque module

### `main.jsx` — Point d'entrée

- Monte l'application React dans le `<div id="root">`
- Wrapping avec `React.StrictMode`
- Importe le CSS global (`@assets/styles/global.css`)

### `App.jsx` — Composant racine

- Wrapping avec `<BrowserRouter>` pour le routage côté client
- Rend le composant `<AppRoutes />`

### `routes/index.jsx` — Routage

Structure prévue pour 3 types de routes :
1. **Routes publiques** — Accessibles sans authentification (ex: `/login`)
2. **Routes protégées** — Wrappées dans un `<Layout>` avec authentification requise
3. **Route 404** — Catch-all pour les URLs inexistantes

**Pattern pour ajouter une route :**
```jsx
import Login from "@pages/Login";
import Dashboard from "@pages/Dashboard";
import { Layout } from "@components/layouts";

<Routes>
  <Route path="/login" element={<Login />} />
  <Route element={<Layout />}>
    <Route path="/" element={<Dashboard />} />
  </Route>
  <Route path="*" element={<NotFound />} />
</Routes>
```

### `api/index.js` — Client HTTP (Axios)

- Instance Axios avec `baseURL` configurée via `VITE_API_BASE_URL` (défaut : `/api`)
- **Intercepteur de requête** : Injecte automatiquement le token JWT depuis `localStorage` dans le header `Authorization: Bearer <token>`
- **Intercepteur de réponse** : Sur une erreur 401, supprime le token et redirige vers `/login`

### `contexts/auth.context.jsx` — Contexte d'authentification

Fournit un `AuthProvider` avec :

| Propriété/Méthode | Type       | Description                              |
|--------------------|-----------|------------------------------------------|
| `user`             | Object    | Données de l'utilisateur connecté        |
| `token`            | String    | Token JWT d'accès                        |
| `isAuthenticated`  | Boolean   | `true` si un token existe                |
| `login(userData, token)` | Function | Connecte l'utilisateur + stocke le token |
| `logout()`         | Function  | Déconnecte + supprime le token           |

Utilisation : `const { user, login, logout } = useAuth();`

### `hooks/useAuthorization.js` — Hook d'autorisation

Fournit des utilitaires de vérification de permissions :

| Méthode                  | Description                              |
|--------------------------|------------------------------------------|
| `hasRole(role)`          | Vérifie si `user.role === role`           |
| `hasPermission(perm)`   | Vérifie si `user.permissions` contient `perm` |
| `isAuthenticated`        | Booléen d'état d'authentification        |

### `utils/useApi.js` — Hook d'appels API

Hook personnalisé qui encapsule les appels Axios avec gestion du loading et des erreurs :

| Propriété/Méthode | Type       | Description                              |
|--------------------|-----------|------------------------------------------|
| `loading`          | Boolean   | `true` pendant un appel en cours         |
| `error`            | String    | Message d'erreur (ou `null`)             |
| `get(url)`         | Function  | Requête GET                              |
| `post(url, data)`  | Function  | Requête POST                             |
| `put(url, data)`   | Function  | Requête PUT                              |
| `del(url)`         | Function  | Requête DELETE                           |

### `components/` — Composants

Organisé en 2 sous-dossiers :

- **`commons/`** — Composants réutilisables (boutons, inputs, modals, etc.)
- **`layouts/`** — Composants de mise en page (Header, Footer, Navbar, Layout principal)

Chaque sous-dossier a un `index.js` qui sert de **barrel export**.

### `assets/` — Ressources statiques

- **`color/color.js`** — Palette de couleurs centralisée (primary, secondary, gray scale, etc.)
- **`styles/global.css`** — Reset CSS + styles globaux de base

---

## Alias de chemins (Vite + IDE)

Configurés dans `vite.config.js` et `jsconfig.json` :

| Alias           | Chemin réel         | Usage                      |
|-----------------|---------------------|----------------------------|
| `@`             | `src/`              | Racine source              |
| `@api`          | `src/api/`          | Client HTTP Axios          |
| `@assets`       | `src/assets/`       | Couleurs, styles, images   |
| `@components`   | `src/components/`   | Composants UI              |
| `@contexts`     | `src/contexts/`     | Contextes React            |
| `@hooks`        | `src/hooks/`        | Hooks personnalisés        |
| `@pages`        | `src/pages/`        | Pages/vues                 |
| `@routes`       | `src/routes/`       | Configuration des routes   |
| `@utils`        | `src/utils/`        | Utilitaires                |

> **Note** : Ces alias fonctionnent à la fois dans Vite (build/dev) et dans l'IDE (navigation). Utiliser `@pages` pour les imports de pages même si le dossier n'existe pas encore.

---

## Proxy en développement

Le `vite.config.js` configure un proxy pour rediriger les appels `/api` vers le backend :

```
Frontend (localhost:5173)  →  /api/*  →  Backend (localhost:3000)
```

Cela évite les problèmes CORS en développement local.
