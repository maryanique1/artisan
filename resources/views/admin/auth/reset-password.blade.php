<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau mot de passe — FeGArtisan Admin</title>
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

        .field{margin-bottom:20px}
        .field label{display:block;font-size:.8rem;font-weight:600;color:var(--secondary);margin-bottom:7px;letter-spacing:.03em;text-transform:uppercase}
        .input-wrap{position:relative}
        .input-wrap .ico{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:1rem;pointer-events:none}
        .input-wrap input{width:100%;padding:11px 40px 11px 40px;border:1.5px solid var(--line);border-radius:10px;font-size:.9rem;font-family:'Poppins',sans-serif;color:var(--ink);background:#fff;outline:none;transition:border-color .2s,box-shadow .2s}
        .input-wrap input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(193,123,78,.12)}
        .toggle-pass{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--muted);cursor:pointer;font-size:1rem;padding:2px;display:flex;align-items:center}
        .toggle-pass:hover{color:var(--primary)}
        .error-msg{color:#C94A3A;font-size:.78rem;margin-top:5px;display:flex;align-items:center;gap:5px}

        .strength-bar{height:4px;border-radius:2px;background:var(--line);margin-top:8px;overflow:hidden;transition:all .3s}
        .strength-bar .fill{height:100%;border-radius:2px;transition:width .3s,background .3s}
        .strength-label{font-size:.72rem;color:var(--muted);margin-top:4px}

        .btn-submit{width:100%;padding:13px;background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;font-family:'Poppins',sans-serif;font-size:.92rem;font-weight:700;border:none;border-radius:11px;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 14px rgba(107,45,14,.3);margin-top:4px}
        .btn-submit:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(107,45,14,.4)}
        .btn-submit:active{transform:none}

        .back-link{display:flex;align-items:center;gap:7px;color:var(--muted);font-size:.84rem;font-weight:500;margin-top:22px;transition:color .2s}
        .back-link:hover{color:var(--primary)}
    </style>
</head>
<body>

<div class="card">
    <div class="logo-wrap">
        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
        <div class="brand">FeG<span>Artisan</span></div>
    </div>

    <h1>Nouveau mot de passe</h1>
    <p class="subtitle">Choisissez un mot de passe sécurisé (8 caractères minimum).</p>

    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field">
            <label for="email">Email</label>
            <div class="input-wrap">
                <span class="ico"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" name="email"
                       value="{{ old('email', $email) }}"
                       placeholder="admin@fegartisan.com" required autocomplete="email"
                       style="padding-right:14px">
            </div>
            @error('email')
                <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="password">Nouveau mot de passe</label>
            <div class="input-wrap">
                <span class="ico"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" name="password"
                       placeholder="Minimum 8 caractères"
                       required autocomplete="new-password" id="passInput">
                <button type="button" class="toggle-pass" onclick="toggleVis('password','icon1')">
                    <i id="icon1" class="bi bi-eye-slash"></i>
                </button>
            </div>
            <div class="strength-bar"><div class="fill" id="strengthFill"></div></div>
            <div class="strength-label" id="strengthLabel"></div>
            @error('password')
                <div class="error-msg"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <div class="input-wrap">
                <span class="ico"><i class="bi bi-lock-fill"></i></span>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       placeholder="Répétez le mot de passe"
                       required autocomplete="new-password">
                <button type="button" class="toggle-pass" onclick="toggleVis('password_confirmation','icon2')">
                    <i id="icon2" class="bi bi-eye-slash"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="bi bi-shield-check"></i> Réinitialiser le mot de passe
        </button>
    </form>

    <a href="{{ route('admin.login') }}" class="back-link">
        <i class="bi bi-arrow-left"></i> Retour à la connexion
    </a>
</div>

<script>
function toggleVis(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-slash';
    }
}

document.getElementById('password').addEventListener('input', function () {
    const val = this.value;
    const fill = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        { w: '0%',   bg: 'transparent', txt: '' },
        { w: '25%',  bg: '#C94A3A',     txt: 'Très faible' },
        { w: '50%',  bg: '#E8A020',     txt: 'Moyen' },
        { w: '75%',  bg: '#4A7C59',     txt: 'Bon' },
        { w: '100%', bg: '#2B6B43',     txt: 'Excellent' },
    ];
    const l = levels[val.length === 0 ? 0 : score];
    fill.style.width = l.w;
    fill.style.background = l.bg;
    label.textContent = l.txt;
    label.style.color = l.bg;
});
</script>
</body>
</html>
