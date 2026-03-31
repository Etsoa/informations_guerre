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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->authenticate($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                redirect(ADMIN_URL . '/articles');
            } else {
                $error = 'Email ou mot de passe incorrect';
            }
        }

        require __DIR__ . '/../../Views/BackOffice/login.php';
    }

    public function logout() {
        session_destroy();
        require __DIR__ . '/../../Views/BackOffice/login.php';
    }
}
