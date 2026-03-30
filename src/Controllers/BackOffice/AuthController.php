<?php
// BackOffice - AuthController

class AuthController {
    private $pdo;
    private $userModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        require_once __DIR__ . '/../../Models/Utilisateur.php';
        $this->userModel = new Utilisateur($pdo);
    }

    public function login() {
        if (isset($_SESSION['user_id'])) {
            redirect(ADMIN_URL . 'articles');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->authenticate($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nom'] = $user['nom'];
                $_SESSION['email'] = $user['email'];
                redirect(ADMIN_URL . 'articles');
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        }

        require __DIR__ . '/../../Views/BackOffice/login.php';
    }

    public function logout() {
        session_destroy();
        redirect(BASE_URL);
    }

    public function dashboard() {
        require_once __DIR__ . '/../../Models/Article.php';
        require_once __DIR__ . '/../../Models/Categorie.php';
        $articleModel = new Article($this->pdo);
        $categorieModel = new Categorie($this->pdo);

        $totalArticles = $articleModel->countAll();
        $categories = $categorieModel->getAllWithCount();
        $recentArticles = $articleModel->getAll(5, 0);

        require __DIR__ . '/../../Views/BackOffice/dashboard.php';
    }
}
