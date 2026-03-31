<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Informations sur la guerre en Iran">
    <title><?= sanitize($pageTitle ?? 'Informations Guerre - Iran') ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <h1><a href="<?= BASE_URL ?>"><span class="logo-badge">IG</span> Infos Guerre</a></h1>
                </div>
                <button class="mobile-menu-toggle" aria-label="Basculer le menu">
                    <span class="hamburger"></span>
                </button>
                <ul class="nav-links">
                    <li><a href="<?= BASE_URL ?>">Accueil</a></li>
                    <li><a href="<?= BASE_URL ?>infos">Dossiers</a></li>
                    <li><a href="<?= ADMIN_URL ?>?page=login">Admin</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
