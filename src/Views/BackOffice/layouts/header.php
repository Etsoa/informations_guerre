<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice - <?= $_GET['page'] ?? 'Admin' ?></title>
</head>
<body>
    <header>
        <div>
            <h1>BackOffice - Informations Guerre</h1>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div>
                    <span>Connecté: <?= sanitize($_SESSION['email']) ?></span>
                    <a href="<?= ADMIN_URL ?>/logout">Déconnexion</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <?php if (isset($_SESSION['user_id'])): ?>
        <nav>
            <ul>
                <li><a href="<?= ADMIN_URL ?>">Tableau de Bord</a></li>
                <li><a href="<?= ADMIN_URL ?>/articles">Articles</a></li>
                <li><a href="<?= ADMIN_URL ?>/article-create">+ Nouvel Article</a></li>
            </ul>
        </nav>
    <?php endif; ?>

    <main class="admin-content">
