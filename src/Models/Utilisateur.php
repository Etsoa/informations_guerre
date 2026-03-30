<?php
// Model Utilisateur

class Utilisateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getByEmail($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function authenticate($email, $password) {
        $user = $this->getByEmail($email);
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        return false;
    }
}
