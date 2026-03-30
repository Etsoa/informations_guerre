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
    public function getByArticleId($articleId) {
        $sql = "SELECT c.* FROM categories c
                JOIN article_categorie ac ON c.id = ac.categorie_id
                WHERE ac.article_id = ?
                ORDER BY c.nom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    public function addToArticle($articleId, $categoryId) {
        $sql = "INSERT INTO article_categorie (article_id, categorie_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId, $categoryId]);
    }

    public function removeAllFromArticle($articleId) {
        $sql = "DELETE FROM article_categorie WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId]);
    }
}

