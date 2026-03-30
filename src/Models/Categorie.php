<?php
// Model Categorie

class Categorie {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM categories ORDER BY nom";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getArticlesByCategory($categoryId) {
        $sql = "SELECT a.* FROM articles a
                JOIN article_categorie ac ON a.id = ac.article_id
                WHERE ac.categorie_id = ?
                ORDER BY a.date_publication DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    public function create($nom) {
        $sql = "INSERT INTO categories (nom) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nom]);
    }

    public function delete($id) {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
