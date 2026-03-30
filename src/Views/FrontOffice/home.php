<?php
$pageTitle = 'Accueil - Informations Guerre';
require __DIR__ . '/layouts/header.php';
?>

<div class="hero">
    <h1>Dernieres Informations sur la Guerre en Iran</h1>
    <p>Restez informe</p>
    <form class="search-bar" method="GET" action="<?= BASE_URL ?>infos">
        <input type="text" name="q" placeholder="Rechercher un article" value="<?= sanitize($_GET['q'] ?? '') ?>">
        <button type="submit">Rechercher</button>
    </form>
</div>

<section class="articles">
    <h2>Articles Recents</h2>
    <div class="articles-grid">
        <?php if (count($articles) > 0): ?>
            <?php foreach ($articles as $article): ?>
                <article class="article-card">
                    <?php $thumb = firstImageSrc($article['contenu'] ?? ''); ?>
                    <?php if ($thumb): ?>
                        <img class="article-thumb" src="<?= $thumb ?>" alt="Illustration article">
                    <?php endif; ?>
                    <h3><a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>"><?= sanitize($article['titre']) ?></a></h3>
                    <p class="date"><?= formatDate($article['date_publication']) ?></p>
                    <p><?= sanitize(truncate($article['description'], 150)) ?></p>
                    <a href="<?= BASE_URL ?>infos/fiche/<?= $article['id'] ?>" class="read-more">Lire la suite →</a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun article trouve.</p>
        <?php endif; ?>
    </div>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
