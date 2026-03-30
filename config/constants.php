<?php
// Constantes globales

// Detecter si on est en HTTPS
$protocole = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

define('BASE_URL', $protocole . '://' . $host . '/');
define('ADMIN_URL', BASE_URL . 'admin');

// Base de donnees
define('DEFAULT_LIMIT', 10);
