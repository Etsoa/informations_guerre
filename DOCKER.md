# Informations Guerre - Docker Setup

## Démarrage rapide

### Prérequis
- Docker
- Docker Compose

### Installation et démarrage

```bash
# 1. Cloner le projet (déjà fait)
cd informations_guerre

# 2. Construire et démarrer les conteneurs
docker-compose up -d --build

# 3. Vérifier que les conteneurs sont actifs
docker-compose ps

# 4. Accéder à l'application
# - Frontend: http://localhost
# - Admin: http://localhost/admin
```

### Arrêt et nettoyage

```bash
# Arrêter les conteneurs
docker-compose down

# Arrêter et supprimer les volumes (données)
docker-compose down -v
```

## Architecture

### Services
- **PHP/Apache**: Application PHP sur le port 80
- **PostgreSQL**: Base de données sur le port 5432

### Initialisation de la base de données
Les scripts SQL sont exécutés automatiquement lors du premier démarrage:
- `database/script.sql` - Schéma et tables
- `database/data.sql` - Données initiales

### Volumes
- `postgres_data` - Persistance des données PostgreSQL
- `public/uploads` - Dossier d'uploads des images

## Configuration

### Variables d'environnement
Voir `.env.example` pour la configuration. Modifier les identifiants dans `docker-compose.yml` si nécessaire.

### Accès à la base de données

#### Depuis l'application PHP
```php
$pdo = Database::getInstance()->getConnection();
```

#### Depuis le terminal
```bash
docker exec -it info_guerre_db psql -U postgres -d informations_guerre
```

### Logs

```bash
# Logs PHP/Apache
docker-compose logs php -f

# Logs PostgreSQL
docker-compose logs postgres -f

# Tous les logs
docker-compose logs -f
```

## Développement

### Modifications du code
Le code source est monté en volume, donc les modifications sont reflétées automatiquement.

### Redémarrage d'un service
```bash
docker-compose restart php
docker-compose restart postgres
```

### Entrer dans le conteneur
```bash
docker exec -it info_guerre_app bash
```
