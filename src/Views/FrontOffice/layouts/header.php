<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= sanitize($pageDescription ?? SITE_DESCRIPTION) ?>">
    <meta name="robots" content="index,follow">
    <meta property="og:title" content="<?= sanitize($pageTitle ?? SITE_NAME) ?>">
    <meta property="og:description" content="<?= sanitize($pageDescription ?? SITE_DESCRIPTION) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= sanitize((string) ($_SERVER['REQUEST_URI'] ?? BASE_URL)) ?>">
    <title><?= sanitize($pageTitle ?? SITE_NAME) ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="topline">
            <div class="container topline-inner">
                <p class="edition">Edition Internationale</p>
                <a class="admin-link" href="<?= ADMIN_URL ?>?page=login">BackOffice</a>
            </div>
        </div>

        <div class="masthead container">
            <p class="brand-kicker">Dossier Special</p>
            <p class="brand-title"><a href="<?= BASE_URL ?>"><?= sanitize(SITE_NAME) ?></a></p>
            <p class="brand-subtitle">Suivi en continu de l'actualite de la guerre en Iran</p>
        </div>

        <nav class="main-nav" aria-label="Navigation principale">
            <div class="container nav-inner">
                <a href="<?= BASE_URL ?>" class="home-link">Accueil</a>
                <ul class="category-menu">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <li>
                                <a href="<?= categoryUrl($cat) ?>"><?= sanitize($cat['nom']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <form class="search-form" action="<?= BASE_URL ?>search" method="GET" role="search">
                    <label class="sr-only" for="site-search">Rechercher un article</label>
                    <input type="search" id="site-search" name="q" minlength="2" autocomplete="off" placeholder="Rechercher" value="<?= sanitize($_GET['q'] ?? '') ?>">
                    <button type="submit">OK</button>
                    <div id="search-suggestions" class="search-suggestions" aria-live="polite"></div>
                </form>
            </div>
        </nav>
    </header>

    <main class="container site-main">
