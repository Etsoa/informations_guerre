<div class="articles-list" id="articles-list-container">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <article class="admin-card">
                <!-- En-tête de l'article -->
                <div class="admin-card-header article-list-header">
                    <h3 class="article-list-title">
                        <?= htmlspecialchars($article['titre']) ?>
                    </h3>
                    <div class="article-list-meta">
                        <span><i class="far fa-calendar-alt"></i> Publie le <?= date('d M Y à H:i', strtotime($article['date_publication'])) ?></span>
                        <?php if (!empty($article['auteurs'])): ?>
                            <span class="separator">|</span>
                            <span>
                                <i class="fas fa-pen-nib"></i>
                                <?php
                                    $authorNames = array_map(function($a) { return htmlspecialchars($a['nom'] . ' ' . $a['prenom']); }, $article['auteurs']);
                                    echo implode(', ', $authorNames);
                                ?>
                            </span>
                        <?php endif; ?>
                        <?php if (!empty($article['categories'])): ?>
                            <span class="separator">|</span>
                            <span>
                                <i class="fas fa-list-alt"></i>
                                <?php
                                    $catNames = array_map(function($c) { return htmlspecialchars($c['nom']); }, $article['categories']); 
                                    echo implode(', ', $catNames);
                                ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Contenu Brut de TinyMCE -->
                <div class="admin-card-body article-render" style="padding: 30px;">
                    <div class="tinymce-content">
                        <?= $article['contenu'] ?>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="admin-card-footer article-list-footer">
                    <a href="<?= ADMIN_URL ?>/article-edit/<?= $article['id'] ?>" class="btn btn-secondary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="<?= ADMIN_URL ?>/article-historique/<?= $article['id'] ?>" class="btn btn-warning">
                        <i class="fas fa-history"></i> Historique
                    </a>
                    <button onclick="deleteArticle(<?= $article['id'] ?>)" class="btn btn-danger-solid">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            Aucun article n'a ete trouve pour ces criteres.
        </div>
    <?php endif; ?>
</div>
