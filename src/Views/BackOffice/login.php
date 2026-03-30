<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - BackOffice</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="login-page">

    <main class="login-card">
        <div class="login-card-header">
            <h1><i class="fas fa-shield-halved"></i> BackOffice</h1>
            <p>Accès sécurisé réservé aux administrateurs</p>
        </div>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <span><strong>Erreur:</strong> <?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Adresse Email
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control"
                    value="admin@guerre-iran.com"
                    required 
                    autofocus
                    placeholder="votre@email.com"
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    <i class="fas fa-lock"></i> Mot de passe
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control"
                    value="admin123"
                    required
                    placeholder="••••••••"
                >
            </div>

            <div class="form-group" style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary btn-block">
                    Connexion <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                </button>
            </div>
        </form>

        <div class="test-credentials">
            <h3><i class="fas fa-info-circle"></i> Identifiants de Test</h3>
            <pre>Email: admin@guerre-iran.com
Mot de passe: admin123</pre>
        </div>
    </main>

</body>
</html>
