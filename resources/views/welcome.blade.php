<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FeGArtisan — La plateforme qui connecte artisans et clients au Bénin</title>
    <meta name="description"
        content="FeGArtisan : trouvez un artisan qualifié ou développez votre activité artisanale au Bénin. Application mobile gratuite, profils vérifiés, messagerie temps réel." />
    
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        /* Charte FeGArtisan */
        :root {
            --primary: #6B2D0E;
            --secondary: #8B3D1A;
            --accent: #C17B4E;
            --accent-light: #E8B088;
            --bg: #FDF6EE;
            --bg-warm: #F5EDE0;
            --bg-dark: #2C1A0E;
            --success: #4A7C59;
            --ink: #2C1A0E;
            --text: #4A3424;
            --muted: #9A7A64;
            --line: #E8D5C0;
        }

        html {
            scroll-behavior: smooth
        }

        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden
        }

        a {
            color: inherit;
            text-decoration: none
        }

        img {
            max-width: 100%;
            display: block
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px
        }

        ::selection {
            background: var(--primary);
            color: #fff
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            font-family: 'Poppins', sans-serif;
            color: var(--primary);
            letter-spacing: -.01em;
            font-weight: 800
        }

        h1 {
            font-size: clamp(40px, 5.5vw, 68px);
            line-height: 1.08
        }

        /* BUTTONS */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 26px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            transition: all .25s;
            cursor: pointer;
            border: none;
            font-family: 'Poppins', sans-serif
        }

        .btn-cta {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            padding: 12px 28px;
            font-size: 14px;
            font-weight: 700;
            border-radius: 100px;
            box-shadow: 0 4px 18px rgba(107, 45, 14, .35);
            letter-spacing: .01em;
            border: 2px solid transparent;
            transition: all .25s
        }

        .btn-cta:hover {
            background: transparent;
            border-color: #fff;
            color: #fff;
            box-shadow: none;
            transform: translateY(-1px)
        }

        /* ═════ HEADER ═════ */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: rgba(253, 246, 238, .95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid transparent;
            transition: all .3s
        }

        .header.scrolled {
            box-shadow: 0 2px 12px rgba(44, 26, 14, .08);
            border-bottom-color: var(--line)
        }

        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 48px;
            max-width: 1200px;
            margin: 0 auto
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: contain;
            background: #fff;
            padding: 3px;
            box-shadow: 0 4px 12px rgba(107, 45, 14, .18);
            image-rendering: -webkit-optimize-contrast
        }

        .logo-icon.small {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            padding: 2px
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1
        }

        .logo-text strong {
            font-size: 17px;
            color: var(--primary);
            font-weight: 800
        }

        .logo-text span {
            font-size: 11px;
            color: var(--muted)
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 4px
        }

        .nav a.nav-cta {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            padding: 12px 28px;
            border-radius: 100px;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            box-shadow: 0 4px 18px rgba(107, 45, 14, .35);
            transition: all .25s;
            letter-spacing: .01em;
            border: 2px solid transparent
        }

        .nav a.nav-cta:hover {
            background: transparent;
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: none;
            transform: translateY(-1px)
        }

        /* ═════ HERO ═════ */
        .hero {
            position: relative;
            min-height: 720px;
            display: flex;
            align-items: center;
            padding: 140px 0 80px;
            overflow: hidden
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(100deg, rgba(44, 26, 14, .94) 0%, rgba(44, 26, 14, .85) 40%, rgba(107, 45, 14, .70) 75%, rgba(139, 61, 26, .50) 100%);
            z-index: 1
        }

        .hero-inner {
            position: relative;
            z-index: 2;
            width: 100%
        }

        .hero-left {
            color: #fff;
            max-width: 720px
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255, 255, 255, .75);
            margin-bottom: 22px;
            letter-spacing: .03em
        }


        .hero h1 {
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 0 2px 24px rgba(0, 0, 0, .25)
        }

        .hero h1 .hero-accent {
            background: linear-gradient(135deg, var(--accent-light), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-style: italic
        }

        .hero-sub {
            font-size: 17px;
            color: rgba(255, 255, 255, .92);
            line-height: 1.6;
            margin-bottom: 26px;
            max-width: 520px;
            text-shadow: 0 2px 14px rgba(0, 0, 0, .2)
        }

        .hero-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 26px
        }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 100px;
            font-size: 13px;
            font-weight: 500;
            color: #fff;
            backdrop-filter: blur(8px)
        }

        .hero-chip i {
            color: var(--accent-light);
            font-size: 14px
        }

        .hero-actions {
            display: none;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px
        }

        @media(max-width:768px) {
            .hero-actions {
                display: flex
            }
        }

        .hero-note {
            color: rgba(255, 255, 255, .75);
            font-size: 14px
        }

        .hero-note i {
            color: var(--accent-light)
        }

        /* ═════ FOOTER (compact) ═════ */
        .footer {
            background: #1A0F07;
            color: rgba(245, 237, 224, .65);
            padding: 28px 0 16px
        }

        .footer-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px 20px;
            flex-wrap: wrap
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 18px;
            flex-wrap: wrap
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .footer-logo strong {
            color: #fff;
            font-size: 15px;
            display: block;
            font-weight: 800
        }

        .footer-logo span {
            font-size: 10px;
            color: rgba(245, 237, 224, .5)
        }

        .footer-email {
            color: var(--accent-light);
            font-weight: 600;
            font-size: 13px
        }

        .footer-email:hover {
            color: var(--accent)
        }

        .footer-socials {
            display: flex;
            gap: 8px
        }

        .footer-social {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: all .3s;
            font-size: 13px
        }

        .footer-social:hover {
            background: var(--accent);
            border-color: var(--accent);
            transform: translateY(-2px)
        }

        .footer-bottom {
            border-top: 1px solid rgba(245, 237, 224, .08);
            padding-top: 14px;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 24px;
            padding-right: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 11px;
            color: rgba(245, 237, 224, .4)
        }

        /* ═════ RESPONSIVE ═════ */
        @media(max-width:1024px) {
            .footer-inner {
                grid-template-columns: 1fr 1fr
            }
        }

        @media(max-width:768px) {
            .nav {
                display: none
            }

            .hero {
                padding: 120px 0 60px;
                min-height: auto
            }

            .hero h1 {
                font-size: 36px
            }

            .footer-inner {
                grid-template-columns: 1fr;
                gap: 30px
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center
            }

        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header" id="top">
        <div class="header-inner">
            <a href="#top" class="logo">
                <img src="{{ asset('images/logo.jpeg') }}" alt="FeGArtisan" class="logo-icon" />
                <div class="logo-text">
                    <strong>FeGArtisan</strong>
                    <span>L'Esprit du Savoir-Faire</span>
                </div>
            </a>
            <nav class="nav" id="nav">
                <a href="{{ route('admin.login') }}" class="nav-cta">Connexion</a>
            </nav>
        </div>
    </header>

    <!-- HERO -->
    <section class="hero">
        <img src="{{ asset('images/backgroud.jpeg') }}" alt="Artisans au Bénin" class="hero-bg" />
        <div class="hero-overlay"></div>
        <div class="container hero-inner">
            <div class="hero-left">
                <div class="hero-badge" data-aos="fade-up"><img src="{{ asset('images/benin.png') }}" alt="Bénin" style="width:20px;height:auto"> Plateforme 100% béninoise</div>
                <h1 data-aos="fade-up" data-aos-delay="100">
                    L'application qui connecte <span class="hero-accent">artisans & clients</span> au Bénin.
                </h1>
                <p class="hero-sub" data-aos="fade-up" data-aos-delay="200">
                    Trouvez un artisan qualifié ou développez votre activité artisanale grâce à une plateforme mobile
                    simple, rapide et 100% gratuite.
                </p>
                <div class="hero-chips" data-aos="fade-up" data-aos-delay="300">
                    <span class="hero-chip"><i class="bi bi-award-fill"></i> Profils vérifiés</span>
                    <span class="hero-chip"><i class="bi bi-hourglass-split"></i> Temps réel</span>
                    <span class="hero-chip"><i class="bi bi-gift-fill"></i> 100% gratuit</span>
                </div>
                <div class="hero-actions" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('admin.login') }}" class="btn btn-cta">Connexion</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="FeGArtisan" class="logo-icon small" />
                    <div><strong>FeGArtisan</strong><span>L'Esprit du Savoir-Faire</span></div>
                </div>
                <a href="mailto:contact@fegartisan.com" class="footer-email">contact@fegartisan.com</a>
            </div>
            <div class="footer-socials">
                <a class="footer-social"><i class="bi bi-facebook"></i></a>
                <a class="footer-social"><i class="bi bi-instagram"></i></a>
                <a class="footer-social"><i class="bi bi-whatsapp"></i></a>
                <a class="footer-social"><i class="bi bi-tiktok"></i></a>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} FeGArtisan · ACLOMBESSIKPE Doris &amp; DOSSOU Maryanique</span>
            <span>Cotonou, Bénin 🇧🇯</span>
        </div>
    </footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 60 });

        const header = document.querySelector('.header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 30);
        });

        document.addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.shiftKey && e.key === 'A') {
                window.location.href = '{{ route("admin.login") }}';
            }
        });
    </script>
</body>

</html>