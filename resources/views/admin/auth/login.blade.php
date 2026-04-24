<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — FeGArtisan Admin</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,700;0,800;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        :root {
            --primary: #6B2D0E;
            --secondary: #8B3D1A;
            --accent: #C17B4E;
            --accent-light: #E8B088;
            --bg: #F5EDE0;
            --bg-cream: #FAF3E8;
            --ink: #2C1A0E;
            --text: #4A3424;
            --muted: #9A7A64;
            --line: #E8D5C0;
            --dark: #3A1608;
            --darker: #2C1006;
        }

        html,
        body {
            height: 100%
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: var(--bg-cream);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden
        }

        a {
            color: inherit;
            text-decoration: none
        }

        .serif {
            font-family: 'Playfair Display', Georgia, serif
        }

        .shell {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh
        }

        /* ═════ LEFT PANEL (dark) ═════ */
        .panel-left {
            position: relative;
            background:
                radial-gradient(circle at 75% 15%, rgba(232, 176, 136, .12) 0, transparent 55%),
                radial-gradient(circle at 20% 85%, rgba(193, 123, 78, .18) 0, transparent 50%),
                linear-gradient(155deg, var(--darker) 0%, var(--primary) 55%, #7A3415 100%);
            color: #fff;
            padding: 60px 64px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .panel-left::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .08;
            background-image: radial-gradient(rgba(255, 255, 255, .35) 1px, transparent 1px);
            background-size: 24px 24px;
            pointer-events: none;
        }

        .panel-left>* {
            position: relative;
            z-index: 1
        }

        .brand {
            margin-bottom: 28px
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 48px;
            line-height: 1;
            letter-spacing: -.01em;
            color: #fff
        }

        .brand-name .gold {
            color: var(--accent-light)
        }

        .brand-tag {
            margin-top: 6px;
            font-size: 11px;
            letter-spacing: .28em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .42);
            font-weight: 500
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255, 255, 255, .75);
            letter-spacing: .03em;
            width: fit-content;
        }

        .pill::before {
            content: '';
            display: inline-block;
            width: 28px;
            height: 2px;
            background: var(--accent-light);
            border-radius: 2px;
            flex-shrink: 0;
        }

        .pill .dot {
            display: none
        }

        .headline {
            margin-top: auto;
            margin-bottom: 28px;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #fff;
            font-size: clamp(38px, 4vw, 56px);
            line-height: 1.1;
            letter-spacing: -.015em;
        }

        .headline em {
            color: var(--accent-light);
            font-style: italic;
            font-weight: 500
        }

        .lede {
            color: rgba(255, 255, 255, .6);
            font-size: 15px;
            max-width: 440px;
            margin-bottom: 44px
        }

        .lede b {
            color: rgba(255, 255, 255, .85);
            font-weight: 600
        }

        .stats {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 40px
        }

        .stat {
            display: flex;
            align-items: center;
            gap: 16px;
            color: rgba(255, 255, 255, .7);
            font-size: 14px
        }

        .stat-ico {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: rgba(232, 176, 136, .1);
            border: 1px solid rgba(232, 176, 136, .22);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-light);
            font-size: 18px;
            flex-shrink: 0;
        }

        .stat b {
            color: #fff;
            font-weight: 700
        }

        .panel-copy {
            font-size: 12px;
            color: rgba(255, 255, 255, .35);
            margin-top: auto
        }

        /* ═════ RIGHT PANEL (form) ═════ */
        .panel-right {
            background: var(--bg-cream);
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-login {
            background: #fff;
            border-radius: 24px;
            padding: 48px 44px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 30px 80px rgba(44, 26, 14, .08), 0 2px 8px rgba(44, 26, 14, .04);
        }

        .kicker {
            font-size: 11px;
            letter-spacing: .3em;
            text-transform: uppercase;
            color: var(--accent);
            font-weight: 600;
            margin-bottom: 14px
        }

        .title {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            line-height: 1.05;
            color: var(--ink);
            font-weight: 800;
            letter-spacing: -.01em
        }

        .title em {
            display: block;
            color: var(--accent);
            font-style: italic;
            font-weight: 500
        }

        .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-top: 14px;
            margin-bottom: 34px
        }

        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FCA5A5;
            color: #991B1B;
            padding: 11px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .field {
            margin-bottom: 20px
        }

        .field label {
            display: block;
            font-size: 11px;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 600;
            margin-bottom: 10px
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--bg);
            border: 1.5px solid transparent;
            border-radius: 14px;
            transition: all .2s;
        }

        .input-wrap:focus-within {
            background: #fff;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(193, 123, 78, .1)
        }

        .input-wrap .ico {
            padding: 0 4px 0 18px;
            color: var(--accent);
            font-size: 18px;
            display: flex;
            align-items: center
        }

        .input-wrap input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            padding: 16px 16px 16px 10px;
            font-size: 15px;
            color: var(--ink);
            font-family: inherit;
            font-weight: 500;
        }

        .input-wrap input::placeholder {
            color: var(--muted);
            opacity: .6
        }

        .toggle-pass {
            background: none;
            border: none;
            color: var(--muted);
            padding: 0 18px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            height: 100%
        }

        .toggle-pass:hover {
            color: var(--accent)
        }

        .row-left {
            display: flex;
            text-align: justify;
            text-align-last: right;
            align-items: center;
            margin-bottom: 26px;
            flex-wrap: wrap;
            gap: 10px
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
            font-size: 14px;
            color: var(--text)
        }

        .remember input {
            position: absolute;
            opacity: 0;
            pointer-events: none
        }

        .remember .box {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 1.5px solid var(--line);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            background: #fff;
        }

        .remember input:checked+.box {
            background: var(--accent);
            border-color: var(--accent)
        }

        .remember input:checked+.box::after {
            content: "\F26B";
            font-family: "bootstrap-icons";
            color: #fff;
            font-size: 13px;
            font-weight: 700
        }

        .forgot {
            color: var(--accent);
            font-size: 13px;
            font-weight: 600;
            transition: color .2s;
            margin-left: auto
        }

        .forgot:hover {
            color: var(--primary)
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 55%, var(--accent) 130%);
            color: #fff;
            border: none;
            padding: 17px 20px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 15px;
            font-family: inherit;
            letter-spacing: .01em;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 24px rgba(107, 45, 14, .28);
            transition: all .25s;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(107, 45, 14, .35)
        }

        .btn-submit:active {
            transform: translateY(0)
        }

        .secure-note {
            margin-top: 22px;
            background: #FDF6EE;
            border: 1px solid #F1E1CD;
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.5;
        }

        .secure-note i {
            color: var(--accent);
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 1px
        }

        /* ═════ RESPONSIVE ═════ */
        @media(max-width:960px) {
            .shell {
                grid-template-columns: 1fr
            }

            .panel-left {
                padding: 22px 24px;
                min-height: auto;
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 16px
            }

            .panel-left .headline,
            .panel-left .lede,
            .panel-left .stats,
            .panel-copy,
            .pill {
                display: none
            }

            .brand {
                margin-bottom: 0
            }

            .brand-name {
                font-size: 26px
            }

            .brand-tag {
                font-size: 10px
            }

            .panel-right {
                padding: 24px 20px 40px
            }

            .card-login {
                padding: 32px 24px;
                border-radius: 20px
            }

            .title {
                font-size: 28px
            }
        }

        @media(max-width:480px) {
            .panel-left {
                padding: 18px 16px
            }

            .brand-name {
                font-size: 22px
            }

            .panel-right {
                padding: 16px 12px 32px
            }

            .card-login {
                padding: 24px 16px;
                border-radius: 16px
            }

            .title {
                font-size: 22px
            }

            .row-between {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px
            }

            .forgot {
                margin-left: 0
            }
        }
    </style>
</head>

<body>

    <div class="shell">

        <!-- ═════ LEFT PANEL ═════ -->
        <aside class="panel-left">
            <div class="brand">
                <div class="brand-name serif">FeG<span class="gold">Artisan</span></div>
                <div class="brand-tag">Plateforme artisanale</div>
            </div>
            <span class="pill">Espace Administration</span>

            <h1 class="headline">Gérez votre plateforme avec <em>précision</em></h1>
            <p class="lede">Validez les artisans, modérez les contenus et suivez la croissance de <b>FeGArtisan</b>
                depuis votre tableau de bord centralisé.</p>

            <div class="stats">
                <div class="stat">
                    <span class="stat-ico"><i class="bi bi-people"></i></span>
                    <span><b>{{ number_format($stats['clients'] ?? 0, 0, ',', ' ') }}</b> clients et
                        <b>{{ number_format($stats['artisans'] ?? 0, 0, ',', ' ') }}</b> artisans actifs</span>
                </div>
                <div class="stat">
                    <span class="stat-ico"><i class="bi bi-clock-history"></i></span>
                    <span><b>{{ $stats['pending'] ?? 0 }}</b> dossier{{ ($stats['pending'] ?? 0) > 1 ? 's' : '' }} en
                        attente de validation</span>
                </div>
                <div class="stat">
                    <span class="stat-ico"><i class="bi bi-shield-check"></i></span>
                    <span>Accès <b>sécurisé</b> et journalisé</span>
                </div>
            </div>

            <div class="panel-copy">© {{ date('Y') }} FeGArtisan · Tous droits réservés</div>
        </aside>

        <!-- ═════ RIGHT PANEL ═════ -->
        <main class="panel-right">
            <div class="card-login">
                <div class="kicker">Administration</div>
                <h2 class="title">Bon retour, <em class="serif">connectez-vous</em></h2>
                <p class="subtitle">Accédez à votre espace d'administration sécurisé.</p>

                @if (session('status'))
                    <div class="alert-error" style="background:#f0faf4;border-color:#a3d9b5;color:#2d6a4f">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login') }}" novalidate>
                    @csrf

                    <div class="field">
                        <label for="email">Identifiant admin</label>
                        <div class="input-wrap">
                            <span class="ico"><i class="bi bi-person"></i></span>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                placeholder="admin@fegartisan.bj" required autofocus autocomplete="username">
                        </div>
                    </div>

                    <div class="field">
                        <label for="password">Mot de passe</label>
                        <div class="input-wrap">
                            <span class="ico"><i class="bi bi-lock"></i></span>
                            <input id="password" type="password" name="password" placeholder="••••••••••" required
                                autocomplete="current-password">
                            <button type="button" class="toggle-pass" id="togglePass"
                                aria-label="Afficher le mot de passe">
                                <i class="bi bi-eye-slash" id="togglePassIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="row-left">

                        <a href="{{ route('admin.password.request') }}" class="forgot">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn-submit">

                        Se connecter au dashboard
                    </button>

                    <div class="secure-note">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Connexion chiffrée et sécurisée. Toutes les actions sont enregistrées et auditées.</span>
                    </div>
                </form>
            </div>
        </main>

    </div>

    <script>
        const toggle = document.getElementById('togglePass');
        const pass = document.getElementById('password');
        const ico = document.getElementById('togglePassIcon');
        toggle.addEventListener('click', () => {
            const isPass = pass.type === 'password';
            pass.type = isPass ? 'text' : 'password';
            ico.className = isPass ? 'bi bi-eye' : 'bi bi-eye-slash';
        });
    </script>
</body>

</html>