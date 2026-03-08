<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Biohome CMS</title>
    <!-- We will map this to the legacy admin CSS or generic Tailwind/Bootstrap depending on the setup. For now, inline or basic styles based on original. -->
    <style>
        body { font-family: sans-serif; background: #f8fafc; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        .login-box h1 { margin-top: 0; color: #334155; }
        .login-box p { text-align: left; }
        .login-box input { width: 100%; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box; margin-top: 0.25rem; }
        .login-box .button { width: 100%; padding: 0.75rem; background: #2563eb; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; margin-top: 1rem; }
        .login-box .button:hover { background: #1d4ed8; }
        .error { color: #dc2626; background: #fee2e2; padding: 0.5rem; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h1>Admin Login</h1>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="post" action="/admin/login">
            <p>
                <label>Benutzername<br>
                    <input type="text" name="username" value="mail@biohome-filter-material.de" required>
                </label>
            </p>
            <p>
                <label>Passwort<br>
                    <input type="password" name="password" required>
                </label>
            </p>
            <button class="button" type="submit">Anmelden</button>
        </form>
        <p style="margin-top:2rem; text-align:center;"><a href="/" style="color:#64748b; text-decoration:none;">&larr; Zurück zur Webseite</a></p>
    </div>
</body>
</html>
