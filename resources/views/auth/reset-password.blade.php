<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe — FeGArtisan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6B2D0E;
            --accent: #C17B4E;
            --bg: #FAF3E8;
            --line: #E8D5C0;
            --ink: #2C1A0E;
            --muted: #9A7A64;
            --danger: #C94A3A;
        }
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
            padding: 36px 32px;
            width: 100%;
            max-width: 420px;
        }
        .logo {
            font-size: 26px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 6px;
            letter-spacing: -.01em;
        }
        .logo span { color: var(--accent); }
        .subtitle {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 28px;
        }
        h2 { font-size: 18px; font-weight: 700; color: var(--ink); margin-bottom: 4px; }
        label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 6px;
            margin-top: 16px;
        }
        input[type=email], input[type=password] {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid var(--line);
            border-radius: 10px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--ink);
            outline: none;
            transition: border-color .2s;
        }
        input:focus { border-color: var(--accent); }
        .error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 6px;
        }
        button[type=submit] {
            margin-top: 24px;
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--primary), #8B3D1A);
            color: #fff;
            border: none;
            border-radius: 11px;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: opacity .2s;
        }
        button[type=submit]:hover { opacity: .9; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">FeG<span>Artisan</span></div>
        <div class="subtitle">Réinitialisation du mot de passe</div>

        <h2>Nouveau mot de passe</h2>

        @if($errors->any())
            <div class="error" style="margin-top:12px">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email">Adresse email</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email', $email) }}"
                   required autocomplete="email">
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label for="password">Nouveau mot de passe</label>
            <input type="password" id="password" name="password"
                   required autocomplete="new-password" minlength="8">
            @error('password') <div class="error">{{ $message }}</div> @enderror

            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   required autocomplete="new-password" minlength="8">

            <button type="submit">Réinitialiser le mot de passe</button>
        </form>
    </div>
</body>
</html>
