<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2 class="page-title"><i class="fas fa-pen-square"></i> Rédiger un nouvel article</h2>
    <a href="<?= ADMIN_URL ?>/articles" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        Informations de l'article
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
                    placeholder="Résumé de l'article en quelques lignes"
                ></textarea>
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
                    placeholder="Développez votre article ici..."
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

            <div class="form-group" id="sources-container">
                <label class="form-label">Sources de l'information</label>
                <div class="source-row form-row" style="margin-bottom: 10px;">
                    <input type="text" name="source_nom[]" class="form-control" placeholder="Nom du média (ex: Le Monde)" style="flex: 1;">
                    <input type="url" name="source_url[]" class="form-control" placeholder="Lien URL (ex: https://...)" style="flex: 2;">
                    <button type="button" onclick="addSourceRow()" class="btn btn-primary" title="Ajouter une source">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Images d'illustration (Optionnelles)</label>
                <div class="upload-zone" id="drop-zone" onclick="document.getElementById('images').click()">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Glissez-déposez vos images ici</p>
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

<script>
    // Source row logic
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

    // Drag and Drop Logic
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

    // Image Preview Logic
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
