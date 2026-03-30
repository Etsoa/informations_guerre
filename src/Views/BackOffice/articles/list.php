<?php
require __DIR__ . '/layouts/header.php';
?>

<h2>Articles</h2>

<a href="<?= ADMIN_URL ?>?page=article-create" class="btn btn-primary">+ Créer Article</a>

<table class="articles-table">
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
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= $article['id'] ?></td>
                <td><?= sanitize(truncate($article['titre'], 50)) ?></td>
                <td><?= sanitize(truncate($article['description'], 50)) ?></td>
                <td><?= formatDate($article['date_publication']) ?></td>
                <td>
                    <a href="<?= ADMIN_URL ?>?page=article-edit&id=<?= $article['id'] ?>" class="btn btn-small">Éditer</a>
                    <a href="<?= ADMIN_URL ?>?page=article-delete&id=<?= $article['id'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/layouts/footer.php'; ?>
