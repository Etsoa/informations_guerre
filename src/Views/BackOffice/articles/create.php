<?php
require __DIR__ . '/../layouts/header.php';
?>

<h2>Créer un Article</h2>

<form method="POST" class="article-form">
    <div class="form-group">
        <label>Titre</label>
        <input type="text" name="titre" required maxlength="250">
    </div>

    <div class="form-group">
        <label>Description courte</label>
        <textarea name="description" required rows="3" maxlength="500"></textarea>
    </div>

    <div class="form-group">
        <label>Contenu</label>
        <textarea name="contenu" required rows="10"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="<?= ADMIN_URL ?>?page=articles" class="btn btn-secondary">Annuler</a>
    </div>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
