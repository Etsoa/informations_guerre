<?php
// Constantes globales

// Détecter si on est en HTTPS
$protocole = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

define('BASE_URL', $protocole . '://' . $host . '/');
define('ADMIN_URL', BASE_URL . 'admin');
define('UPLOADS_DIR', __DIR__ . '/../public/uploads/images/');
define('UPLOADS_URL', BASE_URL . 'uploads/images/');

// Base de données
define('DEFAULT_LIMIT', 10);
