# Informations Guerre - Docker Setup

## Demarrage rapide

### Prerequis
- Docker
- Docker Compose

### Installation et demarrage

```bash
# 1. Cloner le projet (dejà fait)
cd informations_guerre

# 2. Construire et demarrer les conteneurs
docker-compose up -d --build

# 3. Verifier que les conteneurs sont actifs
docker-compose ps

# 4. Acceder à l'application
# - Frontend: http://localhost
# - Admin: http://localhost/admin.php
```

### Arrêt et nettoyage

```bash
# Arrêter les conteneurs
docker-compose down

# Arrêter et supprimer les volumes (donnees)
docker-compose down -v
```

## Architecture

### Services
- **PHP/Apache**: Application PHP sur le port 80
- **PostgreSQL**: Base de donnees sur le port 5432

### Initialisation de la base de donnees
Les scripts SQL sont executes automatiquement lors du premier demarrage:
- `database/script.sql` - Schema et tables
- `database/data.sql` - Donnees initiales

### Volumes
- `postgres_data` - Persistance des donnees PostgreSQL
- `public/uploads` - Dossier d'uploads des images

## Configuration

### Variables d'environnement
Voir `.env.example` pour la configuration. Modifier les identifiants dans `docker-compose.yml` si necessaire.

### Acces à la base de donnees

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

## Developpement

### Modifications du code
Le code source est monte en volume, donc les modifications sont refletees automatiquement.

### Redemarrage d'un service
```bash
docker-compose restart php
docker-compose restart postgres
```

### Entrer dans le conteneur
```bash
docker exec -it info_guerre_app bash
```
