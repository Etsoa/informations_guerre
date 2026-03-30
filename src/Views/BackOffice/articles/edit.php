<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2 class="page-title"><i class="fas fa-edit"></i> Éditer l'article</h2>
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
        <form method="POST" enctype="multipart/form-data">
            
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
                <small class="text-muted"><i class="fas fa-info-circle"></i> 500 caractères maximum</small>
            </div>

            <div class="form-group">
                <label for="contenu" class="form-label">Contenu complet <span style="color:red">*</span></label>
                <textarea 
                    id="contenu" 
                    name="contenu" 
                    class="form-control"
                    required 
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

            <div class="form-group" id="sources-container">
                <label class="form-label">Sources de l'information</label>
                
                <?php if (!empty($articleSources)): ?>
                    <?php foreach ($articleSources as $index => $source): ?>
                        <div class="source-row form-row" style="margin-bottom: 10px;">
                            <input type="text" name="source_nom[]" value="<?= htmlspecialchars($source['nom']) ?>" class="form-control" placeholder="Nom du média" style="flex: 1;">
                            <input type="url" name="source_url[]" value="<?= htmlspecialchars($source['url']) ?>" class="form-control" placeholder="Lien URL" style="flex: 2;">
                            <?php if ($index === 0): ?>
                                <button type="button" onclick="addSourceRow()" class="btn btn-primary" title="Ajouter une source"><i class="fas fa-plus"></i></button>
                            <?php else: ?>
                                <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger-solid" title="Retirer"><i class="fas fa-minus"></i></button>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="source-row form-row" style="margin-bottom: 10px;">
                        <input type="text" name="source_nom[]" class="form-control" placeholder="Nom du média" style="flex: 1;">
                        <input type="url" name="source_url[]" class="form-control" placeholder="Lien URL" style="flex: 2;">
                        <button type="button" onclick="addSourceRow()" class="btn btn-primary" title="Ajouter une source"><i class="fas fa-plus"></i></button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Images Actuelles</label>
                <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 10px;">
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $img): ?>
                            <div id="image-<?= $img['id'] ?>" class="image-preview-wrapper">
                                <img src="<?= UPLOADS_URL . htmlspecialchars($img['nom']) ?>" alt="Image de l'article">
                                <button type="button" class="btn-delete-img" onclick="deleteImage(<?= $img['id'] ?>)" title="Supprimer l'image">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <em class="text-muted">Aucune image associée pour le moment</em>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Ajouter de nouvelles images (Optionnel)</label>
                <div class="upload-zone" id="drop-zone" onclick="document.getElementById('images').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Glissez-déposez vos nouvelles images ici</p>
                    <span>ou cliquez pour parcourir vos fichiers</span>
                    <input 
                        type="file" 
                        id="images" 
                        name="images[]" 
                        multiple 
                        accept="image/*"
                        style="display: none;"
                        onchange="handleFiles(this.files)"
                    >
                </div>
                <div class="preview-container" id="preview-container"></div>
            </div>

            <div class="form-group" style="margin-top: 30px; background: var(--bg-body); padding: 20px; border-radius: 6px; border-left: 4px solid var(--accent-color);">
                <label for="changelog" class="form-label"><i class="fas fa-clipboard-list"></i> Motif de la modification (Optionnel mais recommandé)</label>
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

<script>
    function addSourceRow() {
        const container = document.getElementById('sources-container');
        const row = document.createElement('div');
        row.className = 'source-row form-row';
        row.style.marginBottom = '10px';
        
        row.innerHTML = `
            <input type="text" name="source_nom[]" class="form-control" placeholder="Nom du média" style="flex: 1;">
            <input type="url" name="source_url[]" class="form-control" placeholder="Lien URL" style="flex: 2;">
            <button type="button" onclick="this.parentElement.remove()" class="btn btn-danger-solid" title="Retirer">
                <i class="fas fa-minus"></i>
            </button>
        `;
        
        container.appendChild(row);
    }

    function deleteImage(imageId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer définitivement cette image ?')) return;
        
        ajax('POST', '<?= ADMIN_URL ?>/image-delete', { 
            image_id: imageId
        }, function(response, status) {
            if (status === 200) {
                showAlert('Image supprimée avec succès', 'success');
                const el = document.getElementById('image-' + imageId);
                if(el) el.remove();
            } else {
                showAlert('Erreur lors de la suppression', 'error');
            }
        });
    }

    // Drag and Drop Logic pour les nouvelles images
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('images');

    if (dropZone) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => {
                dropZone.classList.remove('dragover');
            }, false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            fileInput.files = files;
            handleFiles(files);
        }, false);
    }

    function handleFiles(files) {
        const previewContainer = document.getElementById('preview-container');
        previewContainer.innerHTML = '';
        
        Array.from(files).forEach(file => {
            if (!file.type.startsWith('image/')) return;
            
            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `<img src="${e.target.result}" alt="Preview" title="${file.name}">`;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>