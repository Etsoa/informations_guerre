# Strategies de Versioning pour les Articles

## 1. **Solution Recommandee: Table de Versioning Separee** ⭐

La plus simple et la plus efficace pour votre cas.

### Schema SQL
```sql
-- Table article_versions (historique des modifications)
CREATE TABLE article_versions (
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id) ON DELETE CASCADE,
    titre VARCHAR(250) NOT NULL,
    description TEXT NOT NULL,
    contenu TEXT NOT NULL,
    version_number INTEGER NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INTEGER REFERENCES utilisateurs(id),
    changelog TEXT -- Description de la modification
);

CREATE INDEX idx_article_versions_article ON article_versions(article_id);
CREATE INDEX idx_article_versions_date ON article_versions(created_at);
```

### Avantages
✓ Historique complet et auditable
✓ Facile à implementer
✓ Requêtes simples
✓ Performance optimale
✓ RGPD compliant (trace des modifications)

### Inconvenients
✗ Consomme plus d'espace disque
✗ Necessite une gestion manuelle

---

## 2. **Soft Delete avec Timestamps**

Conserver les anciennes versions avec un flag.

### Schema SQL
```sql
ALTER TABLE articles ADD COLUMN version_number INTEGER DEFAULT 1;
ALTER TABLE articles ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE articles ADD COLUMN updated_by INTEGER REFERENCES utilisateurs(id);
ALTER TABLE articles ADD COLUMN is_latest BOOLEAN DEFAULT true;

CREATE INDEX idx_articles_version ON articles(id, version_number);
```

### Avantages
✓ Simpler
✓ Moins de requêtes joins

### Inconvenients
✗ Table articles s'agrandit rapidement
✗ Moins de flexibilite

---

## 3. **Event Sourcing** (Avance)

Enregistrer chaque action comme un evenement.

### Schema SQL
```sql
CREATE TABLE article_events (
    id SERIAL PRIMARY KEY,
    article_id INTEGER NOT NULL REFERENCES articles(id),
    event_type VARCHAR(50) NOT NULL, -- 'CREATED', 'EDITED', 'PUBLISHED', 'DELETED'
    old_values JSONB,
    new_values JSONB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INTEGER REFERENCES utilisateurs(id)
);
```

### Avantages
✓ Traçabilite complete du processus
✓ Recreer n'importe quel etat anterieur
✓ Audit trail complet

### Inconvenients
✗ Plus complexe à implementer
✗ Necessite du parsing JSONB

---

## 4. **Copie Complete (Simple)**

Dupliquer l'article avant modification.

### Schema SQL
```sql
CREATE TABLE articles_archive (
    LIKE articles INCLUDING ALL
);

-- Trigger automatique
CREATE OR REPLACE FUNCTION archive_article()
RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'UPDATE' THEN
        INSERT INTO articles_archive SELECT OLD.*;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER articles_archive_trigger
BEFORE UPDATE ON articles
FOR EACH ROW EXECUTE FUNCTION archive_article();
```

### Avantages
✓ Automatique (trigger)
✓ Archive complete

### Inconvenients
✗ Consomme beaucoup d'espace
✗ Pas de metadata sur la modification

---

## Recommandation Finale

**Je recommande la Solution 1 (Table de Versioning)** car:
1. ✓ equilibre parfait entre simplicite et fonctionnalite
2. ✓ Facile à implementer dans les modeles PHP
3. ✓ Performance et flexibilite
4. ✓ Possibilite de voir la diff entre versions
5. ✓ Peut tracker qui a modifie et quand

---

## Implementation en PHP (Solution 1)

### Modele ArticleVersion
```php
class ArticleVersion {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Sauvegarder une version
    public function create($articleId, $titre, $description, $contenu, $userId, $changelog = null) {
        // Obtenir le numero de version
        $sql = "SELECT MAX(version_number) as max_version FROM article_versions WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        $result = $stmt->fetch();
        $versionNumber = ($result['max_version'] ?? 0) + 1;

        // Inserer la version
        $sql = "INSERT INTO article_versions 
                (article_id, titre, description, contenu, version_number, updated_by, changelog)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $articleId,
            $titre,
            $description,
            $contenu,
            $versionNumber,
            $userId,
            $changelog
        ]);
    }

    // Recuperer l'historique
    public function getHistory($articleId) {
        $sql = "SELECT * FROM article_versions 
                WHERE article_id = ?
                ORDER BY version_number DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    // Restaurer une version
    public function restore($articleId, $versionNumber, $userId) {
        // Recuperer la version
        $sql = "SELECT * FROM article_versions 
                WHERE article_id = ? AND version_number = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId, $versionNumber]);
        $version = $stmt->fetch();

        if (!$version) return false;

        // Sauvegarder la version actuelle comme archive
        $article = new Article($this->pdo);
        $current = $article->getById($articleId);
        $this->create($articleId, $current['titre'], $current['description'], 
                     $current['contenu'], $userId, "Restauree depuis v$versionNumber");

        // Restaurer l'article
        $sql = "UPDATE articles 
                SET titre = ?, description = ?, contenu = ?
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $version['titre'],
            $version['description'],
            $version['contenu'],
            $articleId
        ]);
    }
}
```

### Utilisation dans le Controller
```php
// Avant de modifier un article
$articleId = 123;
$userId = $_SESSION['user_id'];

$versionModel = new ArticleVersion($pdo);
$versionModel->create(
    $articleId,
    $titre,
    $description,
    $contenu,
    $userId,
    "Modification de la section introduction"
);

// Mise à jour de l'article
$article = new Article($pdo);
$article->update($articleId, $data);
```

Veux-tu que j'implemente cette solution en ajoutant les tables au script SQL et les modeles PHP?
