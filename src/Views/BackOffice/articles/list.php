<?php
require __DIR__ . '/../layouts/header.php';
?>

<div class="page-header">
    <h2 class="page-title">Dernières publications</h2>
    <a href="<?= ADMIN_URL ?>/article-create" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvel article
    </a>
</div>

<div class="lemonde-feed">
    <?php if (!empty($articles)): ?>
        <?php foreach ($articles as $article): ?>
            <article class="lemonde-article">
                <div class="lemonde-content">
                    <div class="lemonde-category">Actualité</div>
                    <h3 class="lemonde-title">
                        <span class="lemonde-title-icon"></span><?= htmlspecialchars($article['titre']) ?>
                    </h3>
                    
                    <p class="lemonde-description">
                        <?= nl2br(htmlspecialchars($article['description'])) ?>
                    </p>

                    <div class="lemonde-meta">
                        Publié le <?= date('d M Y à H:i', strtotime($article['date_publication'])) ?>
                        <?php if (!empty($article['auteurs'])): ?>
                            <span class="separator">•</span>
                            <?php 
                                $authorNames = array_map(function($a) { return htmlspecialchars($a['nom'] . ' ' . $a['prenom']); }, $article['auteurs']);
                                echo implode(', ', $authorNames);
                            ?>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($article['sources'])): ?>
                        <div class="lemonde-sources">
                            <strong>Sources:</strong>
                            <?php foreach ($article['sources'] as $source): ?>
                                <a href="<?= htmlspecialchars($source['url']) ?>" target="_blank">
                                    <?= htmlspecialchars($source['nom']) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="lemonde-actions">
                        <a href="<?= ADMIN_URL ?>/article-edit/<?= $article['id'] ?>">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        <a href="<?= ADMIN_URL ?>/article-historique/<?= $article['id'] ?>">
                            <i class="fas fa-history"></i> Historique
                        </a>
                        <button onclick="deleteArticle(<?= $article['id'] ?>)" class="btn-danger">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </button>
                    </div>
                </div>

                <?php if (!empty($article['images'])): 
                    $imgCount = count($article['images']);
                    $galleryClass = $imgCount >= 4 ? 'gallery-4' : 'gallery-' . $imgCount;
                ?>
                    <div class="lemonde-image-gallery <?= $galleryClass ?>">
                        <?php foreach (array_slice($article['images'], 0, 4) as $index => $image): ?>
                            <div class="gallery-item" onclick="openCarousel(<?= $article['id'] ?>, <?= $index ?>)">
                                <img src="<?= UPLOADS_URL . htmlspecialchars($image['nom']) ?>" alt="Aperçu">
                                <?php if($imgCount > 4 && $index === 3): ?>
                                    <div class="more-images">+<?= $imgCount - 4 ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Données cachées pour le carousel JSON -->
                    <div id="carousel-data-<?= $article['id'] ?>" style="display: none;">
                        <?php foreach ($article['images'] as $image): ?>
                            <span data-src="<?= UPLOADS_URL . htmlspecialchars($image['nom']) ?>"></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="padding: 40px 0; color: #666; font-family: Arial, sans-serif;">
            Aucun article pour le moment.
        </div>
    <?php endif; ?>
</div>

<!-- Modal Carousel -->
<div id="imageCarousel" class="carousel-modal">
    <span class="carousel-close" onclick="closeCarousel()">&times;</span>
    <button class="carousel-prev" onclick="changeSlide(-1)">&#10094;</button>
    <div class="carousel-content">
        <img id="carouselImage" src="" alt="Image en grand">
    </div>
    <button class="carousel-next" onclick="changeSlide(1)">&#10095;</button>
</div>

<script>
    function deleteArticle(id) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) return;
        
        ajax('POST', '<?= ADMIN_URL ?>/article-delete/' + id, null, function(response, status) {
            if (status === 200) {
                showAlert('Article supprimé avec succès', 'success');
                setTimeout(() => location.href = '<?= ADMIN_URL ?>/articles', 1500);
            } else {
                showAlert('Erreur lors de la suppression', 'error');
            }
        });
    }

    // Gestion du Carousel
    let currentImages = [];
    let currentIndex = 0;

    function openCarousel(articleId, index) {
        const dataContainer = document.getElementById('carousel-data-' + articleId);
        if(!dataContainer) return;
        
        const spans = dataContainer.querySelectorAll('span');
        currentImages = Array.from(spans).map(span => span.getAttribute('data-src'));
        currentIndex = index;
        
        updateCarouselImage();
        document.getElementById('imageCarousel').style.display = 'flex';
    }

    function closeCarousel() {
        document.getElementById('imageCarousel').style.display = 'none';
        currentImages = [];
    }

    function changeSlide(direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = currentImages.length - 1;
        if (currentIndex >= currentImages.length) currentIndex = 0;
        updateCarouselImage();
    }

    function updateCarouselImage() {
        document.getElementById('carouselImage').src = currentImages[currentIndex];
    }

    // Fermer le carousel en cliquant à côté de l'image
    document.getElementById('imageCarousel').addEventListener('click', function(e) {
        if (e.target === this) closeCarousel();
    });
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
