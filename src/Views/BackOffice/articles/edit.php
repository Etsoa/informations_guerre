<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2 class="page-title"><i class="fas fa-edit"></i> editer l'article</h2>
    <a href="<?= ADMIN_URL ?>/articles" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="article-meta-cards">
    <div class="meta-card">
        <div class="meta-icon"><i class="fas fa-hashtag"></i></div>
        <div class="meta-details">
            <span class="meta-label">Identifiant</span>
            <span class="meta-value"><?= htmlspecialchars($article['id']) ?></span>
        </div>
    </div>

    <div class="meta-card">
        <div class="meta-icon"><i class="far fa-calendar-alt"></i></div>
        <div class="meta-details">
            <span class="meta-label">Date de Publication</span>
            <span class="meta-value"><?= date('d/m/Y à H:i', strtotime($article['date_publication'])) ?></span>
        </div>
    </div>

    <a href="<?= ADMIN_URL ?>/article-historique/<?= $article['id'] ?>" class="meta-card clickable">
        <div class="meta-icon"><i class="fas fa-history"></i></div>
        <div class="meta-details">
            <span class="meta-label">Historique et Versions</span>
            <span class="meta-value" style="color: var(--primary-color);">Voir les modifications</span>
        </div>
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        Modification de l'article
    </div>
    <div class="admin-card-body">
        <form method="POST" enctype="multipart/form-data" onsubmit="this.querySelector('button[type=submit]').disabled=true; this.querySelector('button[type=submit]').innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Sauvegarde...';">

            <div class="form-group">
                <label for="titre" class="form-label">Titre de l'article <span style="color:red">*</span></label>
                <input
                    type="text"
                    id="titre"
                    name="titre"
                    class="form-control"
                    value="<?= htmlspecialchars($article['titre']) ?>"
                    required
                    maxlength="250"
                >
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description courte (Chapeau) <span style="color:red">*</span></label>        
                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    required
                    rows="4"
                    maxlength="500"
                ><?= htmlspecialchars($article['description']) ?></textarea>
                <small class="text-muted"><i class="fas fa-info-circle"></i> 500 caracteres maximum</small>
            </div>

            <div class="form-group">
                <label for="contenu" class="form-label">Contenu complet <span style="color:red">*</span></label>
                <textarea
                    id="contenu"
                    name="contenu"
                    class="form-control"
                    rows="8"
                ><?= htmlspecialchars($article['contenu']) ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Auteur(s) <span style="color:red">*</span></label>
                <div class="author-grid">
                    <?php foreach ($auteurs as $auteur): ?>
                        <label class="author-label" style="cursor: pointer;">
                            <input
                                type="checkbox"
                                name="auteurs[]"
                                value="<?= $auteur['id'] ?>"
                                class="author-checkbox"
                                <?= in_array($auteur['id'], $currentAuteursIds) ? 'checked' : '' ?>
                            >
                            <div class="author-card">
                                <i class="fas fa-user-circle"></i>
                                <span><?= htmlspecialchars($auteur['nom'] . ' ' . $auteur['prenom']) ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Categorie(s) <span style="color:red">*</span></label>
                <div class="author-grid">
                    <?php foreach ($categories as $cat): ?>
                        <label class="author-label" style="cursor: pointer;">
                            <input
                                type="checkbox"
                                name="categories[]"
                                value="<?= $cat['id'] ?>"
                                class="author-checkbox"
                                <?= in_array($cat['id'], $currentCategoriesIds) ? 'checked' : '' ?>
                            >
                            <div class="author-card">
                                <i class="fas fa-list-alt"></i>
                                <span><?= htmlspecialchars($cat['nom']) ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group" style="margin-top: 30px; background: var(--bg-body); padding: 20px; border-radius: 6px; border-left: 4px solid var(--accent-color);">
                <label for="changelog" class="form-label"><i class="fas fa-clipboard-list"></i> Motif de la modification (Optionnel mais recommande)</label>
                <input
                    type="text"
                    id="changelog"
                    name="changelog"
                    class="form-control"
                    placeholder="Ex: Correction orthographe, Mise à jour des sources..." 
                    maxlength="255"
                >
                <small class="text-muted" style="display: block; margin-top: 5px;">Cette note apparaîtra dans l'historique des versions pour faciliter le suivi.</small>
            </div>

            <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; gap: 15px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Sauvegarder les modifications
                </button>
                <a href="<?= ADMIN_URL ?>/articles" class="btn btn-secondary">
                    Annuler
                </a>
            </div>

        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>