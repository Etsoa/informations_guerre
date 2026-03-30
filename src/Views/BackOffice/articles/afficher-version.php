<?php
// Vue BackOffice - Affichage d'une version spécifique

require __DIR__ . '/layouts/header.php';
?>

<div class="container">
    <h1>Version <?php echo $version['version_number']; ?> - <?php echo htmlspecialchars($version['titre']); ?></h1>

    <div class="version-info">
        <p>
            <strong>Article:</strong> 
            <a href="<?php echo ADMIN_URL . '?page=article-edit&id=' . $article['id']; ?>">
                <?php echo htmlspecialchars($article['titre']); ?>
            </a>
        </p>
        <p><strong>Version:</strong> <?php echo $version['version_number']; ?></p>
        <p><strong>Modifié par:</strong> <?php echo htmlspecialchars($version['auteur_nom'] ?? 'Système'); ?></p>
        <p><strong>Date:</strong> <?php echo date('d/m/Y H:i:s', strtotime($version['created_at'])); ?></p>
        <?php if ($version['changelog']): ?>
            <p><strong>Description du changement:</strong> <?php echo htmlspecialchars($version['changelog']); ?></p>
        <?php endif; ?>
    </div>

    <div class="version-content">
        <h3>Titre</h3>
        <p><?php echo htmlspecialchars($version['titre']); ?></p>

        <h3>Description</h3>
        <p><?php echo nl2br(htmlspecialchars($version['description'])); ?></p>

        <h3>Contenu</h3>
        <div class="content">
            <?php echo nl2br(htmlspecialchars($version['contenu'])); ?>
        </div>
    </div>

    <div class="actions">
        <a href="<?php echo ADMIN_URL . '?page=article-restaurer&id=' . $article['id'] . '&version=' . $version['version_number']; ?>" 
           class="btn btn-warning" 
           onclick="return confirm('Restaurer cette version? L\'état actuel sera archivé.');">
            ✓ Restaurer cette version
        </a>
        <a href="<?php echo ADMIN_URL . '?page=article-historique&id=' . $article['id']; ?>" class="btn btn-secondary">
            ← Retour à l'historique
        </a>
        <a href="<?php echo ADMIN_URL . '?page=articles'; ?>" class="btn btn-secondary">
            Retour à la liste
        </a>
    </div>
</div>

<style>
    .version-info {
        background: #f0f8ff;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        border-left: 4px solid #17a2b8;
    }

    .version-content {
        background: white;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .version-content h3 {
        margin-top: 20px;
        padding-top: 10px;
        border-top: 1px solid #eee;
        color: #333;
    }

    .version-content h3:first-child {
        margin-top: 0;
        padding-top: 0;
        border-top: none;
    }

    .content {
        background: #fafafa;
        padding: 10px;
        border-radius: 4px;
        max-height: 400px;
        overflow-y: auto;
    }

    .btn {
        display: inline-block;
        padding: 10px 15px;
        margin: 5px;
        text-decoration: none;
        border-radius: 4px;
        font-size: 14px;
    }

    .btn-warning {
        background: #ffc107;
        color: black;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn:hover {
        opacity: 0.8;
    }

    .actions {
        margin-top: 20px;
        padding-top: 20px;
        text-align: center;
    }
</style>

<?php require __DIR__ . '/layouts/footer.php'; ?>
