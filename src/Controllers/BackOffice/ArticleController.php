<?php
// BackOffice - AdminArticleController

class AdminArticleController {
    private $pdo;
    private $articleModel;
    private $categorieModel;
    private $imageModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Article.php';
        require_once __DIR__ . '/../../Models/Categorie.php';
        require_once __DIR__ . '/../../Models/Image.php';
        $this->articleModel = new Article($pdo);
        $this->categorieModel = new Categorie($pdo);
        $this->imageModel = new Image($pdo);
    }

    public function ListerArticles() {
        $articles = $this->articleModel->getAll(100, 0);
        
        // Charger les catégories pour chaque article
        foreach ($articles as &$article) {
            $article['categories'] = $this->categorieModel->getCategoriesByArticle($article['id']);
        }
        
        require __DIR__ . '/../../Views/BackOffice/articles/list.php';
    }

    public function create() {
        $categories = $this->categorieModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu']
            ];
            $articleId = $this->articleModel->create($data);

            // Associer les catégories
            if (!empty($_POST['categories'])) {
                foreach ($_POST['categories'] as $catId) {
                    $this->articleModel->addCategory($articleId, $catId);
                }
            }

            // Gérer l'image uploadée
            if (!empty($_FILES['image']['name'])) {
                $this->handleImageUpload($articleId, $_FILES['image']);
            }

            redirect(ADMIN_URL . 'articles');
        }

        require __DIR__ . '/../../Views/BackOffice/articles/create.php';
    }

    public function edit($id) {
        $article = $this->articleModel->getById($id);
        if (!$article) {
            redirect(ADMIN_URL . 'articles');
        }

        $categories = $this->categorieModel->getAll();
        $articleCategoryIds = $this->articleModel->getCategoryIds($id);
        $images = $this->imageModel->getByArticleId($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'contenu' => $_POST['contenu']
            ];
            $this->articleModel->update($id, $data);

            // Mettre à jour les catégories
            $this->articleModel->removeCategories($id);
            if (!empty($_POST['categories'])) {
                foreach ($_POST['categories'] as $catId) {
                    $this->articleModel->addCategory($id, $catId);
                }
            }

            // Gérer la nouvelle image
            if (!empty($_FILES['image']['name'])) {
                $this->handleImageUpload($id, $_FILES['image']);
            }

            redirect(ADMIN_URL . 'articles');
        }

        require __DIR__ . '/../../Views/BackOffice/articles/edit.php';
    }

    public function delete($id) {
        $this->articleModel->delete($id);
        redirect(ADMIN_URL . 'articles');
    }

    private function handleImageUpload($articleId, $file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = slugify(pathinfo($file['name'], PATHINFO_FILENAME)) . '-' . time() . '.' . $ext;
        
        // Créer le dossier uploads si nécessaire
        if (!is_dir(UPLOADS_DIR)) {
            mkdir(UPLOADS_DIR, 0775, true);
        }

        if (move_uploaded_file($file['tmp_name'], UPLOADS_DIR . $filename)) {
            $this->imageModel->create([
                'nom' => $filename,
                'article_id' => $articleId
            ]);
            return true;
        }
        return false;
    }
}
