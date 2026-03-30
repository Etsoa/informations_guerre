<?php
require __DIR__ . '/../layouts/header.php';
?>

<h2>Articles</h2>

<p>
    <a href="<?= ADMIN_URL ?>/article-create">+ Créer un nouvel article</a>
</p>

<table border="1" cellpadding="10" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= $article['id'] ?></td>
                    <td><strong><?= htmlspecialchars(substr($article['titre'], 0, 50)) ?></strong></td>
                    <td><?= htmlspecialchars(substr($article['description'], 0, 50)) ?>...</td>
                    <td><?= date('d/m/Y H:i', strtotime($article['date_publication'])) ?></td>
                    <td>
                        <a href="<?= ADMIN_URL ?>/article-edit/<?= $article['id'] ?>">Éditer</a>
                        |
                        <a href="<?= ADMIN_URL ?>/article-historique/<?= $article['id'] ?>">Historique</a>
                        |
                        <button onclick="deleteArticle(<?= $article['id'] ?>)" style="background: none; border: none; color: blue; cursor: pointer; text-decoration: underline;">Supprimer</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; font-style: italic;">
                    Aucun article trouvé
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    function deleteArticle(id) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet article?')) return;
        
        ajax('POST', '<?= ADMIN_URL ?>/article-delete/' + id, null, function(response, status) {
            if (status === 200) {
                showAlert('Article supprimé avec succès', 'success');
                setTimeout(() => location.href = '<?= ADMIN_URL ?>/articles', 1500);
            } else {
                showAlert('Erreur lors de la suppression', 'error');
            }
        });
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
