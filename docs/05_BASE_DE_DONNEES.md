# 05 — Base de Données

> **Ce fichier documente la couche base de données :** PostgreSQL, scripts SQL, et stratégie ORM (Sequelize).

---

## PostgreSQL

- **Version** : 16 Alpine (image Docker `postgres:16-alpine`)
- **Nom de la base** : `informations_guerre` (configurable via `DB_NAME`)
- **Port par défaut** : `5432`
- **Utilisateur par défaut** : `postgres`

---

## Scripts SQL (`database/`)

Les scripts sont exécutés **automatiquement au premier lancement** du conteneur PostgreSQL, dans l'ordre alphabétique du dossier `docker-entrypoint-initdb.d/` :

| Ordre | Fichier       | Rôle                                            | État actuel         |
|-------|---------------|--------------------------------------------------|---------------------|
| 1     | `script.sql`  | Création des tables (`CREATE TABLE IF NOT EXISTS`) | Template (vide)     |
| 2     | `data.sql`    | Insertion des données initiales (`INSERT INTO`)   | Template (vide)     |
| —     | `reset.sql`   | Réinitialisation de la base (usage manuel)        | Vide                |

> **Important** : Ces scripts ne sont exécutés que si le volume `pg_data` n'existe pas encore. Pour les ré-exécuter, il faut supprimer le volume : `docker compose down -v`.

---

## Stratégie ORM : Sequelize

### Double approche (SQL + ORM)

Le projet utilise **deux niveaux** pour gérer le schéma de la base :

1. **Scripts SQL** (`database/script.sql`) — Créent les tables au premier init Docker. Servent de **source de vérité** pour le schéma initial.
2. **Modèles Sequelize** (`backoffice/src/model/`) — Définissent le même schéma côté code Node.js. En mode `development`, Sequelize synchronise automatiquement les modèles avec `sequelize.sync({ alter: true })`.

### Configuration de la connexion

```
Fichier : backoffice/src/config/database.js
```

| Paramètre       | Valeur                                 |
|------------------|----------------------------------------|
| Dialect          | `postgres`                             |
| Host             | `DB_HOST` (Docker : `db`, local : `localhost`) |
| Port             | `DB_PORT` (défaut : `5432`)            |
| Pool max         | 5 connexions                           |
| Pool idle        | 10 secondes                            |
| Pool acquire     | 30 secondes                            |
| Logging          | Activé en `development` uniquement     |

### Créer un nouveau modèle

1. Créer le fichier `backoffice/src/model/NomEntite.js` :

```js
const { DataTypes } = require("sequelize");
const sequelize = require("../config/database");

const NomEntite = sequelize.define("nom_entite", {
  id: {
    type: DataTypes.INTEGER,
    primaryKey: true,
    autoIncrement: true,
  },
  nom: {
    type: DataTypes.STRING(100),
    allowNull: false,
  },
}, {
  tableName: "nom_entite",
  timestamps: true,
  underscored: true,
});

module.exports = NomEntite;
```

2. L'importer et l'exporter dans `model/index.js`
3. Définir les associations dans `model/index.js`
4. Ajouter le `CREATE TABLE` correspondant dans `database/script.sql`

### Associations

Les associations Sequelize (hasMany, belongsTo, hasOne, belongsToMany) doivent être définies dans `model/index.js` après l'import de tous les modèles :

```js
const User = require("./User");
const Post = require("./Post");

User.hasMany(Post);
Post.belongsTo(User);

module.exports = { sequelize, User, Post };
```

---

## Volume Docker

Les données PostgreSQL sont persistées dans le volume Docker `pg_data` :

```yaml
volumes:
  pg_data:  # Données PostgreSQL persistées
```

Pour **réinitialiser complètement** la base :
```bash
docker compose down -v    # Supprime les conteneurs ET les volumes
docker compose up -d      # Recrée tout depuis zéro
```
