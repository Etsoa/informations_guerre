<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2 class="page-title"><i class="fas fa-eye"></i> Aperçu de la Version <?= $version['version_number'] ?></h2>
    <div>
        <a href="<?= ADMIN_URL ?>/article-historique/<?= $article['id'] ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à l'historique
        </a>
    </div>
</div>

<div class="article-meta-cards" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <a href="<?= ADMIN_URL ?>/article-edit/<?= $article['id'] ?>" class="meta-card clickable">
        <div class="meta-icon"><i class="fas fa-file-alt"></i></div>
        <div class="meta-details">
            <span class="meta-label">Article d'origine</span>
            <span class="meta-value" style="color: var(--primary-color); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;" title="<?= htmlspecialchars($article['titre']) ?>">
                <?= htmlspecialchars($article['titre']) ?>
            </span>
        </div>
    </a>
    
    <div class="meta-card">
        <div class="meta-icon"><i class="fas fa-code-branch"></i></div>
        <div class="meta-details">
            <span class="meta-label">Version</span>
            <span class="meta-value">v<?= $version['version_number'] ?></span>
        </div>
    </div>
    
    <div class="meta-card">
        <div class="meta-icon"><i class="far fa-clock"></i></div>
        <div class="meta-details">
            <span class="meta-label">Modifié le</span>
            <span class="meta-value"><?= date('d/m/Y H:i', strtotime($version['created_at'])) ?></span>
        </div>
    </div>
    
    <div class="meta-card">
        <div class="meta-icon"><i class="fas fa-user-edit"></i></div>
        <div class="meta-details">
            <span class="meta-label">Par</span>
            <span class="meta-value"><?= htmlspecialchars($version['auteur_nom'] ?? 'Système') ?></span>
        </div>
    </div>
</div>

<?php if ($version['changelog']): ?>
<div class="meta-card" style="margin-bottom: 25px; grid-column: 1 / -1; width: 100%;">
    <div class="meta-icon"><i class="fas fa-comment-dots"></i></div>
    <div class="meta-details" style="width: 100%;">
        <span class="meta-label">Motif de la modification (Changelog)</span>
        <span class="meta-value" style="font-style: italic; color: var(--text-main);">"<?= htmlspecialchars($version['changelog']) ?>"</span>
    </div>
</div>
<?php endif; ?>

<div class="admin-card">
    <div class="admin-card-header">
        Données archivées (Lecture seule)
    </div>
    <div class="admin-card-body">
        
        <div class="version-content">
            <div class="version-label">Titre en v<?= $version['version_number'] ?></div>
            <div class="version-value" style="font-size: 1.2em; font-weight: bold; color: var(--primary-color);">
                <?= htmlspecialchars($version['titre']) ?>
            </div>
        </div>

        <div class="version-content">
            <div class="version-label">Description (Chapeau)</div>
            <div class="version-value">
                <?= nl2br(htmlspecialchars($version['description'])) ?>
            </div>
        </div>

        <div class="version-content">
            <div class="version-label">Contenu complet</div>
            <div class="version-value" style="white-space: pre-wrap; word-wrap: break-word; font-family: 'Merriweather', serif; line-height: 1.8;">
                <?= nl2br(htmlspecialchars($version['contenu'])) ?>
            </div>
        </div>
        
    </div>
</div>

<div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; gap: 15px;">
    <button 
        onclick="restoreVersion(<?= $article['id'] ?>, <?= $version['version_number'] ?>)"
        class="btn btn-primary"
        style="background: var(--accent-color);"
    >
        <i class="fas fa-undo"></i> Restaurer l'article à cette version
    </button>
    
    <a href="<?= ADMIN_URL ?>/articles" class="btn btn-secondary">
        <i class="fas fa-list"></i> Retour à la liste globale
    </a>
</div>

<script>
    function restoreVersion(articleId, versionNumber) {
        if (!confirm('Êtes-vous sûr de vouloir restaurer cette version ? L\'état actuel sera archivé dans l\'historique.')) {
            return;
        }
        
        ajax('POST', '<?= ADMIN_URL ?>/article-restaurer/' + articleId + '/' + versionNumber, {}, function(response, status) {
            if (status === 200) {
                showAlert('Version restaurée avec succès', 'success');
                setTimeout(() => location.href = '<?= ADMIN_URL ?>/article-historique/' + articleId, 1500);
            } else {
                showAlert('Erreur lors de la restauration', 'error');
            }
        });
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>