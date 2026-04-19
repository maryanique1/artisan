<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié — FeGArtisan Admin</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        :root{
            --primary:#6B2D0E;--secondary:#8B3D1A;--accent:#C17B4E;
            --accent-light:#E8B088;--bg:#F5EDE0;--bg-cream:#FAF3E8;
            --ink:#2C1A0E;--text:#4A3424;--muted:#9A7A64;--line:#E8D5C0;
            --dark:#3A1608;--darker:#2C1006;
        }
        html,body{height:100%}
        body{font-family:'Poppins',sans-serif;background:var(--bg-cream);color:var(--text);display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px}
        a{color:inherit;text-decoration:none}

        .card{background:#fff;border-radius:20px;padding:48px 44px;width:100%;max-width:460px;box-shadow:0 12px 40px rgba(107,45,14,.12);border:1px solid var(--line)}

        .logo-wrap{display:flex;align-items:center;gap:12px;margin-bottom:36px}
        .logo-wrap img{width:42px;height:42px;border-radius:10px;object-fit:contain;background:#fff;border:1px solid var(--line);box-shadow:0 3px 8px rgba(107,45,14,.12)}
        .logo-wrap .brand{font-family:'Playfair Display',serif;font-size:1.35rem;font-weight:900;color:var(--primary);letter-spacing:-.01em;line-height:1}
        .logo-wrap .brand span{color:var(--accent)}

        h1{font-size:1.35rem;font-weight:800;color:var(--primary);margin-bottom:8px;letter-spacing:-.01em}
        .subtitle{font-size:.87rem;color:var(--muted);line-height:1.6;margin-bottom:28px}

        .alert-success{background:#f0faf4;border:1px solid #a3d9b5;border-radius:10px;padding:13px 16px;font-size:.86rem;color:#2d6a4f;display:flex;align-items:flex-start;gap:10px;margin-bottom:22px}
        .alert-success i{margin-top:2px;flex-shrink:0}

        .field{margin-bottom:20px}
        .field label{display:block;font-size:.8rem;font-weight:600;color:var(--secondary);margin-bottom:7px;letter-spacing:.03em;text-transform:uppercase}
        .input-wrap{position:relative}
        .input-wrap .ico{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:1rem;pointer-events:none}
        .input-wrap input{width:100%;padding:11px 14px 11px 40px;border:1.5px solid var(--line);border-radius:10px;font-size:.9rem;font-family:'Poppins',sans-serif;color:var(--ink);background:#fff;outline:none;transition:border-color .2s,box-shadow .2s}
        .input-wrap input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(193,123,78,.12)}
        .error-msg{color:#C94A3A;font-size:.78rem;margin-top:5px;display:flex;align-items:center;gap:5px}

        .btn-submit{width:100%;padding:13px;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;font-family:'Poppins',sans-serif;font-size:.92rem;font-weight:700;border:none;border-radius:11px;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(107,45,14,.3);margin-top:4px}
        .btn-submit:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(107,45,14,.4)}
        .btn-submit:active{transform:none}

        .back-link{display:flex;align-items:center;gap:7px;color:var(--muted);font-size:.84rem;font-weight:500;margin-top:22px;transition:color .2s}
        .back-link:hover{color:var(--primary)}
        .back-link i{font-size:.9rem}
    </style>
</head>
<body>

<div class="card">
    <div class="logo-wrap">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
        <div class="brand">FeG<span>Artisan</span></div>
    </div>

    <h1>Mot de passe oublié</h1>
    <p class="subtitle">Entrez votre adresse email. Si un compte admin existe, vous recevrez un lien pour réinitialiser votre mot de passe.</p>

    @if (session('status'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('status') }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.password.email') }}">
        @csrf

        <div class="field">
            <label for="email">Adresse email</label>
            <div class="input-wrap">
                <span class="ico"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       placeholder="admin@fegartisan.com" required autofocus autocomplete="email">
            </div>
            @error('email')
                <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-send"></i> Envoyer le lien
        </button>
    </form>

    <a href="{{ route('admin.login') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Retour à la connexion
    </a>
</div>

</body>
</html>
