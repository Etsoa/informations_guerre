<?php
// Configuration base de donnees - Pattern Singleton
// Utilise les variables d'environnement du fichier .env, sinon les valeurs par defaut

/**
 * Charge les variables d'environnement depuis le fichier .env
 */
function loadEnv($filePath) {
    if (!file_exists($filePath)) {
        return;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignorer les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Parser les variables
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            
            // Supprimer les guillemets si presents
            if (preg_match('/^"(.+)"$/', $value) || preg_match('/^\'(.+)\'$/', $value)) {
                $value = substr($value, 1, -1);
            }
            
            // Definir la variable d'environnement
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

// Charger les variables du fichier .env
$envFile = __DIR__ . '/../.env';
loadEnv($envFile);

class Database {
    private static $instance = null;
    private $pdo;

    // Constantes de configuration avec valeurs par defaut
    private const HOST = 'postgres';                // 'postgres' en Docker, 'localhost' en local
    private const DBNAME = 'informations_guerre';
    private const USER = 'postgres';
    private const PASSWORD = 'password';
    private const PORT = '5432';

    /**
     * Constructeur prive pour empêcher l'instanciation directe
     */
    private function __construct() {
        try {
            // Recupere les variables d'environnement avec valeurs par defaut
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
     * Obtient l'instance unique de la base de donnees
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
     * Empêche la serialisation de l'instance
     */
    public function __serialize() {
        throw new Exception('Singleton ne peut pas être serialise');
    }

    /**
     * Empêche la deserialisation de l'instance
     */
    public function __unserialize(array $data) {
        throw new Exception('Singleton ne peut pas être deserialise');
    }
}

// Utilisation globale - Pour compatibilite avec le code existant
$pdo = Database::getInstance()->getConnection();
