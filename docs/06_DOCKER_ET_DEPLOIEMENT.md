# 06 — Docker & Déploiement

> **Ce fichier décrit l'infrastructure Docker,** les 3 services, leur configuration et les commandes utiles.

---

## Architecture des services

```
┌─────────────────────────────────────────────────────────┐
│                    docker-compose.yml                    │
│                                                          │
│  ┌────────────────┐   ┌──────────────┐   ┌────────────┐ │
│  │  ig_frontend   │   │   ig_api      │   │ ig_postgres│ │
│  │  (Apache 2.4)  │──▶│  (Node.js)   │──▶│ (PG 16)    │ │
│  │  Port: 80      │   │  Port: 3000   │   │ Port: 5432 │ │
│  └────────────────┘   └──────────────┘   └────────────┘ │
│                                                          │
│  Réseau : app-network (bridge)                           │
└─────────────────────────────────────────────────────────┘
```

---

## Les 3 services

### 1. `db` — PostgreSQL

| Propriété       | Valeur                                |
|-----------------|----------------------------------------|
| Image           | `postgres:16-alpine`                  |
| Container name  | `ig_postgres`                         |
| Port exposé     | `5432:5432`                           |
| Volume          | `pg_data:/var/lib/postgresql/data`    |
| Scripts init    | `database/script.sql`, `database/data.sql` |
| Restart policy  | `unless-stopped`                      |

### 2. `api` — Backend Node.js

| Propriété       | Valeur                                |
|-----------------|----------------------------------------|
| Build context   | `./backoffice`                        |
| Container name  | `ig_api`                              |
| Port exposé     | `3000:3000`                           |
| Dépend de       | `db`                                  |
| Restart policy  | `unless-stopped`                      |

Variables d'environnement injectées :
- `NODE_ENV=development`
- `PORT=3000`
- `DB_HOST=db` (nom du service Docker)
- `DB_PORT=5432`
- `DB_NAME`, `DB_USER`, `DB_PASSWORD` (depuis `.env`)

### 3. `frontend` — React + Apache

| Propriété       | Valeur                                |
|-----------------|----------------------------------------|
| Build context   | `./frontoffice`                       |
| Container name  | `ig_frontend`                         |
| Port exposé     | `80:80`                               |
| Dépend de       | `api`                                 |
| Restart policy  | `unless-stopped`                      |

---

## Dockerfiles

### Backend (`backoffice/Dockerfile`)

Build simple en une étape :
1. Base : `node:20-alpine`
2. `npm install` des dépendances
3. Copie du code source
4. Expose le port `3000`
5. Commande : `node src/server.js`

### Frontend (`frontoffice/Dockerfile`)

Build **multi-étapes** :

| Étape | Base            | Action                                       |
|-------|-----------------|-----------------------------------------------|
| 1     | `node:20-alpine` | `npm install` + `npm run build` (Vite → `dist/`) |
| 2     | `httpd:2.4-alpine` | Copie du build dans Apache, config URL rewriting |

Configuration Apache appliquée :
- Activation des modules : `rewrite`, `proxy`, `proxy_http`
- `AllowOverride All` pour le `.htaccess`
- Proxy `/api` → `http://api:3000/api` (communication inter-conteneurs)
- `.htaccess` : Redirige toutes les requêtes non-fichier vers `index.html` (SPA)

---

## Réseau Docker

Tous les services partagent le réseau `app-network` (driver bridge) :
- Le frontend accède au backend via le nom de service : `http://api:3000`
- Le backend accède à PostgreSQL via : `db:5432`
- Depuis l'hôte : `localhost:80` (frontend), `localhost:3000` (API), `localhost:5432` (BDD)

---

## Commandes utiles

### Gestion Docker

```bash
# Démarrer tous les services
docker compose up -d

# Démarrer avec rebuild des images
docker compose up -d --build

# Arrêter tous les services
docker compose down

# Arrêter + supprimer les volumes (RESET complet de la BDD)
docker compose down -v

# Voir les logs d'un service
docker compose logs -f api
docker compose logs -f db
docker compose logs -f frontend

# Accéder au shell d'un conteneur
docker compose exec api sh
docker compose exec db psql -U postgres -d informations_guerre
```

### Développement local (sans Docker)

```bash
# Backend
cd backoffice
npm install
npm run dev          # Démarre avec nodemon sur localhost:3000

# Frontend
cd frontoffice
npm install
npm run dev          # Démarre Vite sur localhost:5173 (avec proxy /api)
```

---

## Ordre de démarrage

```
1. db (PostgreSQL)        → Exécute script.sql + data.sql au premier lancement
2. api (Node.js)          → Se connecte à db, synchronise les modèles Sequelize
3. frontend (Apache)      → Sert le build React, proxy les appels /api vers api
```

`depends_on` dans Docker Compose garantit l'ordre de démarrage (mais pas que le service soit "prêt" — Sequelize gère les retries de connexion).
