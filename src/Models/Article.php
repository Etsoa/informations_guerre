<?php
// Model Article

class Article {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll($limit = 10, $offset = 0) {
        $sql = "SELECT * FROM articles ORDER BY date_publication DESC LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM articles WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByCategory($categoryId, $limit = 10, $offset = 0) {
        $sql = "SELECT a.* FROM articles a
                JOIN article_categorie ac ON a.id = ac.article_id
                WHERE ac.categorie_id = ?
                ORDER BY a.date_publication DESC LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM articles";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch()['total'];
    }

    public function countByCategory($categoryId) {
        $sql = "SELECT COUNT(*) as total FROM articles a
                JOIN article_categorie ac ON a.id = ac.article_id
                WHERE ac.categorie_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetch()['total'];
    }

    public function create($data) {
        $sql = "INSERT INTO articles (titre, description, contenu, date_publication) 
                VALUES (?, ?, ?, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['titre'],
            $data['description'],
            $data['contenu']
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $sql = "UPDATE articles SET titre = ?, description = ?, contenu = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['titre'],
            $data['description'],
            $data['contenu'],
            $id
        ]);
    }

    public function delete($id) {
        // Supprimer les relations d'abord
        $this->pdo->prepare("DELETE FROM article_categorie WHERE article_id = ?")->execute([$id]);
        $this->pdo->prepare("DELETE FROM article_auteur WHERE article_id = ?")->execute([$id]);
        $this->pdo->prepare("DELETE FROM sources WHERE article_id = ?")->execute([$id]);
        $this->pdo->prepare("DELETE FROM images WHERE article_id = ?")->execute([$id]);
        // Puis l'article
        $sql = "DELETE FROM articles WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function search($keyword, $limit = 10, $offset = 0) {
        $sql = "SELECT * FROM articles WHERE titre ILIKE ? OR description ILIKE ? ORDER BY date_publication DESC LIMIT ? OFFSET ?";
        $stmt = $this->pdo->prepare($sql);
        $term = '%' . $keyword . '%';
        $stmt->execute([$term, $term, $limit, $offset]);
        return $stmt->fetchAll();
    }

    public function countSearch($keyword) {
        $sql = "SELECT COUNT(*) as total FROM articles WHERE titre ILIKE ? OR description ILIKE ?";
        $stmt = $this->pdo->prepare($sql);
        $term = '%' . $keyword . '%';
        $stmt->execute([$term, $term]);
        return $stmt->fetch()['total'];
    }

    public function getRelated($articleId, $limit = 4) {
        $sql = "SELECT DISTINCT a.* FROM articles a
                JOIN article_categorie ac1 ON a.id = ac1.article_id
                WHERE ac1.categorie_id IN (
                    SELECT categorie_id FROM article_categorie WHERE article_id = ?
                ) AND a.id != ?
                ORDER BY a.date_publication DESC LIMIT ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId, $articleId, $limit]);
        return $stmt->fetchAll();
    }

    public function addCategory($articleId, $categoryId) {
        $sql = "INSERT INTO article_categorie (article_id, categorie_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId, $categoryId]);
    }

    public function removeCategories($articleId) {
        $sql = "DELETE FROM article_categorie WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId]);
    }

    public function getCategoryIds($articleId) {
        $sql = "SELECT categorie_id FROM article_categorie WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        return array_column($stmt->fetchAll(), 'categorie_id');
    }
}
