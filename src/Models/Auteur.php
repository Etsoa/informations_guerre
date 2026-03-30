<?php
// Model Auteur

class Auteur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM auteurs ORDER BY nom, prenom";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM auteurs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByArticleId($articleId) {
        $sql = "SELECT a.* FROM auteurs a
                JOIN article_auteur aa ON a.id = aa.auteur_id
                WHERE aa.article_id = ?
                ORDER BY a.nom, a.prenom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO auteurs (nom, prenom, email) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'] ?? null
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE auteurs SET nom = ?, prenom = ?, email = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'] ?? null,
            $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM auteurs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function addToArticle($articleId, $authorId) {
        $sql = "INSERT INTO article_auteur (article_id, auteur_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId, $authorId]);
    }

    public function removeFromArticle($articleId, $authorId) {
        $sql = "DELETE FROM article_auteur WHERE article_id = ? AND auteur_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId, $authorId]);
    }

    public function removeAllFromArticle($articleId) {
        $sql = "DELETE FROM article_auteur WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId]);
    }
}
