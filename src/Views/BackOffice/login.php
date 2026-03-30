<?php
require __DIR__ . '/layouts/header.php';
?>

<div class="login-form">
    <h2>Connexion Admin</h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Connexion</button>
    </form>

    <p style="margin-top: 20px; font-size: 0.9em; color: #666;">
        <strong>Identifiants de test:</strong><br>
        Email: admin@guerre-iran.com<br>
        Mot de passe: admin123
    </p>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>
