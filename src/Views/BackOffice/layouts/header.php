<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice - <?= $_GET['page'] ?? 'Admin' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">
</head>
<body class="admin-layout">
    <header class="admin-header">
        <div class="container">
            <h1>BackOffice</h1>
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-menu">
                    <span><?= sanitize($_SESSION['email']) ?></span>
                    <a href="<?= ADMIN_URL ?>?page=logout" class="btn btn-danger">Déconnexion</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <?php if (isset($_SESSION['user_id'])): ?>
        <aside class="sidebar">
            <nav>
                <ul>
                    <li><a href="<?= ADMIN_URL ?>">Dashboard</a></li>
                    <li><a href="<?= ADMIN_URL ?>?page=articles">Articles</a></li>
                    <li><a href="<?= ADMIN_URL ?>?page=article-create">+ Nouvel Article</a></li>
                </ul>
            </nav>
        </aside>
    <?php endif; ?>

    <main class="admin-content">
