<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BackOffice - <?= $_GET['page'] ?? 'Admin' ?></title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- TinyMCE CDN -->
    <?php $tinyMceApiKey = getenv('TINYMCE_API_KEY') ?: 'no-api-key'; ?>
    <script src="https://cdn.tiny.cloud/1/<?= htmlspecialchars($tinyMceApiKey) ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <header class="admin-header">
        <div class="logo-container">
            <h1><i class="fas fa-shield-halved"></i> BackOffice</h1>
            <?php if (isset($_SESSION['user_id'])): ?>
                <button class="mobile-menu-toggle-admin admin-nav-toggle" aria-label="Ouvrir le menu">
                    <span class="hamburger"></span>
                </button>
            <?php endif; ?>
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-controls">
                <span><i class="fas fa-user-circle"></i> <?= sanitize($_SESSION['email']) ?></span>
                <a href="<?= ADMIN_URL ?>/logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Deconnexion</a>
            </div>
        <?php endif; ?>
    </header>

    <?php if (isset($_SESSION['user_id'])): ?>
        <nav class="admin-nav">
            <ul>
                <li><a href="<?= ADMIN_URL ?>/articles"><i class="fas fa-newspaper"></i> Articles</a></li>
                <li><a href="<?= ADMIN_URL ?>/article-create"><i class="fas fa-plus"></i> Nouvel Article</a></li>
                <li><a href="<?= BASE_URL ?>"><i class="fas fa-globe"></i> Frontoffice</a></li>
            </ul>
        </nav>
    <?php endif; ?>

    <main class="admin-main">
