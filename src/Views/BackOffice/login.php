<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - BackOffice</title>
</head>
<body>
    <header>
        <h1>BackOffice - Connexion</h1>
    </header>

    <main>
        <div>
            <h2>Authentification</h2>
            
            <?php if (isset($error)): ?>
                <div style="border: 1px solid #dc3545; background: #f8d7da; color: #721c24; padding: 10px; margin: 10px 0; border-radius: 4px;">
                    <strong>Erreur:</strong> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <fieldset>
                    <legend>Connexion Admin</legend>
                    
                    <div style="margin: 15px 0;">
                        <label for="email">
                            <strong>Email:</strong>
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            autofocus
                            style="width: 300px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;"
                        >
                    </div>

                    <div style="margin: 15px 0;">
                        <label for="password">
                            <strong>Mot de passe:</strong>
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            style="width: 300px; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;"
                        >
                    </div>

                    <div style="margin: 20px 0;">
                        <button 
                            type="submit" 
                            style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px;"
                        >
                            → Connexion
                        </button>
                    </div>
                </fieldset>
            </form>

            <h3>Identifiants de Test</h3>
            <pre>Email: admin@test.com
Mot de passe: password123</pre>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 - Informations Guerre - BackOffice</p>
    </footer>
</body>
</html>
