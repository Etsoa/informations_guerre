<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2 class="page-title"><i class="fas fa-pen-square"></i> Rediger un nouvel article</h2>
    <a href="<?= ADMIN_URL ?>/articles" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour Ã  la liste
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        Informations de l'article
    </div>
    <div class="admin-card-body">
        <form method="POST" enctype="multipart/form-data" onsubmit="this.querySelector('button[type=submit]').disabled=true; this.querySelector('button[type=submit]').innerHTML='<i class=\'fas fa-spinner fa-spin\'></i> Publication...';">
            
            <div class="form-group">
                <label for="titre" class="form-label">Titre de l'article <span style="color:red">*</span></label>
                <input 
                    type="text" 
                    id="titre" 
                    name="titre" 
                    class="form-control"
                    required 
                    maxlength="250"
                    placeholder="Saisissez un titre accrocheur"
                >
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description courte (Chapeau) <span style="color:red">*</span></label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-control"
                    required 
                    rows="3" 
                    maxlength="500"
                    placeholder="Resume de l'article en quelques lignes"
                ></textarea>
                <small class="text-muted"><i class="fas fa-info-circle"></i> 500 caractÃ¨res maximum</small>
            </div>

            <div class="form-group">
                <label for="contenu" class="form-label">Contenu complet <span style="color:red">*</span></label>
                <textarea 
                    id="contenu" 
                    name="contenu" 
                    class="form-control"
                    rows="8"
                    placeholder="Developpez votre article ici..."
                ></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Auteur(s) <span style="color:red">*</span></label>
                <div class="author-grid">
                    <?php foreach ($auteurs as $auteur): ?>
                        <label class="author-label" style="cursor: pointer;">
                            <input type="checkbox" name="auteurs[]" value="<?= $auteur['id'] ?>" class="author-checkbox">
                            <div class="author-card">
                                <i class="fas fa-user-circle"></i>
                                <span><?= htmlspecialchars($auteur['nom'] . ' ' . $auteur['prenom']) ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Categorie(s)</label>
                <div class="author-grid">
                    <?php foreach ($categories as $cat): ?>
                        <label class="author-label" style="cursor: pointer;">
                            <input type="checkbox" name="categories[]" value="<?= $cat['id'] ?>" class="author-checkbox">
                            <div class="author-card" style="border-radius: 20px;">
                                <i class="fas fa-tag"></i>
                                <span><?= htmlspecialchars($cat['nom']) ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; gap: 15px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Publier l'article
                </button>
                <a href="<?= ADMIN_URL ?>/articles" class="btn btn-secondary">
                    Annuler
                </a>
            </div>

        </form>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>

