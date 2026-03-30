<?php
// Model ArticleVersion

class ArticleVersion {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM article_versions ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM article_versions WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByArticleId($articleId, $limit = 50, $offset = 0) {
        $sql = "SELECT av.*, u.nom as auteur_nom FROM article_versions av
                LEFT JOIN utilisateurs u ON av.updated_by = u.id
                WHERE av.article_id = ?
                ORDER BY av.version_number DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function getVersionCount($articleId) {
        $sql = "SELECT COUNT(*) as count FROM article_versions WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        $result = $stmt->fetch();
        return $result['count'];
    }

public function create($articleId, $titre, $description, $contenu, $auteursJson, $userId, $changelog = null) {
        // Obtenir le numero de version suivant
        $sql = "SELECT MAX(version_number) as max_version FROM article_versions WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        $result = $stmt->fetch();
        $versionNumber = ($result['max_version'] ?? 0) + 1;

        // Inserer la version
        $sql = "INSERT INTO article_versions
                (article_id, titre, description, contenu, auteurs_json, version_number, updated_by, changelog)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $articleId,
            $titre,
            $description,
            $contenu,
            $auteursJson,
            $versionNumber,
            $userId,
            $changelog
        ]);
    }

    public function getSpecificVersion($articleId, $versionNumber) {
        $sql = "SELECT * FROM article_versions 
                WHERE article_id = ? AND version_number = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId, $versionNumber]);
        return $stmt->fetch();
    }

    public function restore($articleId, $versionNumber, $userId, $changelog = null) {
        // R??cup??rer la version ?? restaurer
        $sql = "SELECT * FROM article_versions 
                WHERE article_id = ? AND version_number = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId, $versionNumber]);
        $version = $stmt->fetch();

        if (!$version) {
            return false;
        }

// Recuperer l'article actuel pour l'archiver
        require_once __DIR__ . '/Article.php';
        require_once __DIR__ . '/Auteur.php';
        $articleModel = new Article($this->pdo);
        $auteurModel = new Auteur($this->pdo);

        $current = $articleModel->getById($articleId);

        if ($current) {
            $auteurs = $auteurModel->getByArticleId($articleId);

            // Archiver la version actuelle
            $this->create(
                $articleId,
                $current['titre'],
                $current['description'],
                $current['contenu'],
                json_encode($auteurs),
                $userId,
                "Automarchive avant restauration de v$versionNumber"
            );
        }

        // Restaurer l'article
        $sql = "UPDATE articles
                SET titre = ?, description = ?, contenu = ?
                WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        $success = $stmt->execute([
            $version['titre'],
            $version['description'],
            $version['contenu'],
            $articleId
        ]);

        if ($success) {
            // Restore Auteurs
            $auteurModel->removeAllFromArticle($articleId);
            $oldAuteurs = json_decode($version['auteurs_json'], true) ?: [];
            foreach ($oldAuteurs as $auteur) {
               $auteurModel->addToArticle($articleId, $auteur['id']);
            }

            // Si succes, archiver cette action comme version
            $changelogMsg = $changelog ?? "Restauree depuis version $versionNumber";
            $this->create(
                $articleId,
                $version['titre'],
                $version['description'],
                $version['contenu'],
                $version['auteurs_json'],
                $userId,
                $changelogMsg
            );
        }

        return $success;
    }

    public function delete($id) {
        $sql = "DELETE FROM article_versions WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function deleteByArticleId($articleId) {
        $sql = "DELETE FROM article_versions WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId]);
    }

    public function compareVersions($versionId1, $versionId2) {
        $v1 = $this->getById($versionId1);
        $v2 = $this->getById($versionId2);

        if (!$v1 || !$v2) {
            return null;
        }

        return [
            'version1' => $v1,
            'version2' => $v2,
            'titre_changed' => $v1['titre'] !== $v2['titre'],
            'description_changed' => $v1['description'] !== $v2['description'],
            'contenu_changed' => $v1['contenu'] !== $v2['contenu']
        ];
    }
}

