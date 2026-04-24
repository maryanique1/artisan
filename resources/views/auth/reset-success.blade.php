<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe réinitialisé — FeGArtisan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #6B2D0E; --accent: #C17B4E; --bg: #FAF3E8; --line: #E8D5C0; --ink: #2C1A0E; --muted: #9A7A64; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
        }
        .card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid var(--line);
            box-shadow: 0 4px 24px rgba(44,26,14,.08);
            padding: 40px 32px;
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        .logo { font-size: 26px; font-weight: 800; color: var(--primary); margin-bottom: 24px; }
        .logo span { color: var(--accent); }
        .icon {
            width: 64px; height: 64px; border-radius: 16px;
            background: #E7F5EC; margin: 0 auto 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
        }
        h2 { font-size: 19px; font-weight: 700; color: var(--ink); margin-bottom: 8px; }
        p { font-size: 13.5px; color: var(--muted); line-height: 1.6; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">FeG<span>Artisan</span></div>
        <div class="icon">✅</div>
        <h2>Mot de passe mis à jour</h2>
        <p>Votre mot de passe a été réinitialisé avec succès.<br>Vous pouvez maintenant vous connecter depuis l'application.</p>
    </div>
</body>
</html>
