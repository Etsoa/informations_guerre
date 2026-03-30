<?php
// Model Source

class Source {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM sources ORDER BY nom";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM sources WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByArticleId($articleId) {
        $sql = "SELECT * FROM sources WHERE article_id = ? ORDER BY nom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO sources (article_id, nom, url) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['article_id'],
            $data['nom'],
            $data['url']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE sources SET article_id = ?, nom = ?, url = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['article_id'],
            $data['nom'],
            $data['url'],
            $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM sources WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function deleteByArticleId($articleId) {
        $sql = "DELETE FROM sources WHERE article_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$articleId]);
    }
}
