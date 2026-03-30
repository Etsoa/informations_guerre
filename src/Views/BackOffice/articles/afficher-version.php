<?php
require __DIR__ . '/../layouts/header.php';
?>

<h2>Version <?= $version['version_number'] ?></h2>

<h3><?= htmlspecialchars($version['titre']) ?></h3>

<div style="margin: 15px 0; padding: 15px; border: 1px solid #17a2b8; background: #d1ecf1; border-radius: 4px;">
    <p><strong>Article:</strong> <a href="<?= ADMIN_URL ?>/article-edit/<?= $article['id'] ?>"><?= htmlspecialchars($article['titre']) ?></a></p>
    <p><strong>Version:</strong> v<?= $version['version_number'] ?></p>
    <p><strong>Modifié par:</strong> <?= htmlspecialchars($version['auteur_nom'] ?? 'Système') ?></p>
    <p><strong>Date:</strong> <?= date('d/m/Y H:i:s', strtotime($version['created_at'])) ?></p>
    <?php if ($version['changelog']): ?>
        <p><strong>Description du changement:</strong> <em><?= htmlspecialchars($version['changelog']) ?></em></p>
    <?php endif; ?>
</div>

<fieldset>
    <legend>Contenu de la Version</legend>
    
    <div style="margin: 20px 0;">
        <h4>Titre</h4>
        <p><?= htmlspecialchars($version['titre']) ?></p>
    </div>

    <div style="margin: 20px 0;">
        <h4>Description</h4>
        <p><?= nl2br(htmlspecialchars($version['description'])) ?></p>
    </div>

    <div style="margin: 20px 0;">
        <h4>Contenu</h4>
        <div style="background: #f5f5f5; padding: 10px; border: 1px solid #ddd; border-radius: 4px; white-space: pre-wrap; word-wrap: break-word;">
            <?= nl2br(htmlspecialchars($version['contenu'])) ?>
        </div>
    </div>
</fieldset>

<div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #ddd;">
    <button 
        onclick="restoreVersion(<?= $article['id'] ?>, <?= $version['version_number'] ?>)"
        style="padding: 10px 20px; background: #ffc107; color: black; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; margin-right: 10px;"
    >
        ↩ Restaurer cette version
    </button>
    
    <a 
        href="<?= ADMIN_URL ?>/article-historique/<?= $article['id'] ?>"
        style="display: inline-block; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;"
    >
        ← Retour à l'historique
    </a>
    
    <a 
        href="<?= ADMIN_URL ?>/articles"
        style="display: inline-block; padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px; font-size: 14px;"
    >
        Retour à la liste
    </a>
</div>

<script>
    function restoreVersion(articleId, versionNumber) {
        if (!confirm('Êtes-vous sûr de vouloir restaurer cette version? L\'état actuel sera archivé.')) {
            return;
        }
        
        ajax('POST', '<?= ADMIN_URL ?>/article-restaurer/' + articleId + '/' + versionNumber, null, function(response, status) {
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