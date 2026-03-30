<?php
// Configuration base de données - Pattern Singleton
// Utilise les variables d'environnement si disponibles, sinon les valeurs par défaut

class Database {
    private static $instance = null;
    private $pdo;

    // Constantes de configuration avec valeurs par défaut
    private const HOST = 'postgres';                // 'postgres' en Docker, 'localhost' en local
    private const DBNAME = 'informations_guerre';
    private const USER = 'postgres';
    private const PASSWORD = 'password';
    private const PORT = '5432';

    /**
     * Constructeur privé pour empêcher l'instanciation directe
     */
    private function __construct() {
        try {
            // Récupère les variables d'environnement avec valeurs par défaut
            $host = getenv('DB_HOST') ?: self::HOST;
            $port = getenv('DB_PORT') ?: self::PORT;
            $dbname = getenv('DB_NAME') ?: self::DBNAME;
            $user = getenv('DB_USER') ?: self::USER;
            $password = getenv('DB_PASSWORD') ?: self::PASSWORD;

            $this->pdo = new PDO(
                "pgsql:host=$host;port=$port;dbname=$dbname",
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die('Erreur connexion BD: ' . $e->getMessage());
        }
    }

    /**
     * Obtient l'instance unique de la base de données
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Retourne l'objet PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->pdo;
    }

    /**
     * Empêche le clonage de l'instance
     */
    private function __clone() {}

    /**
     * Empêche la sérialisation de l'instance
     */
    public function __serialize() {
        throw new Exception('Singleton ne peut pas être sérialisé');
    }

    /**
     * Empêche la désérialisation de l'instance
     */
    public function __unserialize(array $data) {
        throw new Exception('Singleton ne peut pas être désérialisé');
    }
}

// Utilisation globale - Pour compatibilité avec le code existant
$pdo = Database::getInstance()->getConnection();
