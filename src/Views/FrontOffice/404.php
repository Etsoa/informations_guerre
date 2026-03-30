<?php
$pageTitle = 'Page non trouvee - ' . SITE_NAME;
$pageDescription = 'Cette page n\'existe pas ou a ete deplacee.';
require __DIR__ . '/layouts/header.php';
?>

<section class="latest-block" aria-labelledby="not-found-title">
    <h1 id="not-found-title">404 - Page introuvable</h1>
    <p>Le contenu demande n\'est pas disponible.</p>
    <p><a href="<?= BASE_URL ?>" class="btn btn-secondary">Retour a l'accueil</a></p>
</section>

<?php require __DIR__ . '/layouts/footer.php'; ?>
