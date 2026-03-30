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

    public function create($data) {
        $sql = "INSERT INTO articles (titre, description, contenu, date_publication) 
                VALUES (?, ?, ?, NOW()) RETURNING id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            $data['titre'],
            $data['description'],
            $data['contenu']
        ]);
        return $stmt->fetchColumn();
    }

    public function update($id, $data, $userId = null, $changelog = null) {
        // Si userId est fourni, cr??er une version avant la modification
        if ($userId !== null) {
            $current = $this->getById($id);
            if ($current) {
                require_once __DIR__ . '/ArticleVersion.php';
                $versionModel = new ArticleVersion($this->pdo);

                // Fetch authors
                require_once __DIR__ . '/Auteur.php';
                $auteurModel = new Auteur($this->pdo);
                $auteurs = $auteurModel->getByArticleId($id);
                $auteursJson = json_encode($auteurs);

                $versionModel->create(
                    $id,
                    $current['titre'],
                    $current['description'],
                    $current['contenu'],
                    $auteursJson,
                    $userId,
                    $changelog
                );
            }
        }

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
        $sql = "DELETE FROM articles WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function search($keyword) {
        $sql = "SELECT * FROM articles WHERE titre ILIKE ? OR description ILIKE ? ORDER BY date_publication DESC";
        $stmt = $this->pdo->prepare($sql);
        $term = '%' . $keyword . '%';
        $stmt->execute([$term, $term]);
        return $stmt->fetchAll();
    }

    public function getFiltered($filters = []) {
        $sql = "SELECT DISTINCT a.* FROM articles a";
        $params = [];
        $conditions = [];

        if (!empty($filters['categorie_id'])) {
            $sql .= " JOIN article_categorie ac ON a.id = ac.article_id";
            $conditions[] = "ac.categorie_id = ?";
            $params[] = $filters['categorie_id'];
        }

        if (!empty($filters['date'])) {
            $conditions[] = "DATE(a.date_publication) = ?";
            $params[] = $filters['date'];
        }

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY a.date_publication DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}


