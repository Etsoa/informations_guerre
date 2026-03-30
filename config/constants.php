<?php
// Constantes globales

// Détection automatique de l'URL de base
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = '/';

define('BASE_URL', $protocol . '://' . $host . $basePath);
define('ADMIN_URL', BASE_URL . 'admin/');
define('UPLOADS_DIR', __DIR__ . '/../public/uploads/images/');
define('UPLOADS_URL', BASE_URL . 'uploads/images/');

// Base de données
define('DEFAULT_LIMIT', 10);

// Site
define('SITE_NAME', 'InfoGuerre Iran');
define('SITE_DESCRIPTION', 'Toute l\'actualité sur la guerre en Iran - analyses, reportages et décryptages');
