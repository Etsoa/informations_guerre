<?php
$pageTitle = sanitize($article['titre'] ?? 'Article');
$images = allImageSrc($article['contenu'] ?? '');
$hero = $images[0] ?? null;
$gallery = array_slice($images, 1);
require __DIR__ . '/layouts/header.php';
?>

<div class="detail-spacer">
    <a href="<?= BASE_URL ?>infos" class="btn btn-secondary" style="margin-bottom: 20px; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fas fa-arrow-left"></i> Retour aux dossiers
    </a>
</div>

<article class="admin-card">
    <div class="admin-card-header article-list-header">
        <h1 class="article-list-title" style="font-size: 2rem;"><?= sanitize($article['titre']) ?></h1>
        <div class="article-list-meta" style="margin-top: 10px;">
            <span><i class="far fa-calendar-alt"></i> Publie le <?= formatDate($article['date_publication']) ?></span>
            <?php if (!empty($article['auteurs'])): ?>
                <span class="separator">|</span>
                <span>
                    <i class="fas fa-pen-nib"></i>
                    <?php
                        $authorNames = array_map(function($a) { return sanitize($a['nom'] . ' ' . $a['prenom']); }, $article['auteurs']);
                        echo implode(', ', $authorNames);
                    ?>
                </span>
            <?php endif; ?>
            <?php if (!empty($article['categories'])): ?>
                <span class="separator">|</span>
                <span>
                    <i class="fas fa-list-alt"></i>
                    <?php
                        $catNames = array_map(function($c) { return sanitize($c['nom']); }, $article['categories']);
                        echo implode(', ', $catNames);
                    ?>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="admin-card-body article-render" style="padding: 40px;">
        <p class="article-description" style="font-size: 1.1rem; color: var(--text-muted); font-weight: 500; font-style: italic; margin-bottom: 30px; border-left: 4px solid var(--primary-color); padding-left: 15px;">
            <?= sanitize($article['description']) ?>
        </p>
        
        <div class="tinymce-content">
            <?= $article['contenu'] // TinyMCE HTML ?>
        </div>
    </div>
</article>

<?php require __DIR__ . '/layouts/footer.php'; ?>
