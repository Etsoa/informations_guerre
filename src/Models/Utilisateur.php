<?php
// Model Utilisateur

class Utilisateur {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM utilisateurs ORDER BY nom";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM utilisateurs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByEmail($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function authenticate($email, $password) {
        $user = $this->getByEmail($email);

        if ($user) {
            // Verifie le mot de passe hashe OU le texte clair (utile pour les donnees de test non hashees)
            if (password_verify($password, $user['mot_de_passe']) || $password === $user['mot_de_passe']) {
                return $user;
            }
        }
        return false;
    }

    public function create($data) {
        $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nom'],
            $data['email'],
            password_hash($data['mot_de_passe'], PASSWORD_DEFAULT)
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE utilisateurs SET nom = ?, email = ?, mot_de_passe = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nom'],
            $data['email'],
            password_hash($data['mot_de_passe'], PASSWORD_DEFAULT),
            $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM utilisateurs WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
