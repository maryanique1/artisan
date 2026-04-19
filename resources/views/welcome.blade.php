<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FeGArtisan — La plateforme qui connecte artisans et clients au Bénin</title>
    <meta name="description"
        content="FeGArtisan : trouvez un artisan qualifié ou développez votre activité artisanale au Bénin. Application mobile gratuite, profils vérifiés, messagerie temps réel." />
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}" />
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
            background: linear-gradient(135deg, var(--accent), #D4956A);
            color: #fff;
            padding: 16px 30px;
            font-size: 16px;
            box-shadow: 0 6px 18px rgba(193, 123, 78, .3)
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 26px rgba(193, 123, 78, .45)
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
            padding: 14px 24px;
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
            padding: 11px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(107, 45, 14, .2);
            transition: all .2s
        }

        .nav a.nav-cta:hover {
            background: linear-gradient(135deg, var(--secondary), #A04A1E);
            transform: translateY(-1px)
        }

        .burger {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px
        }

        .burger span {
            width: 26px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
            transition: all .3s
        }

        .burger.open span:nth-child(1) {
            transform: translateY(8px) rotate(45deg)
        }

        .burger.open span:nth-child(2) {
            opacity: 0
        }

        .burger.open span:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg)
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
            gap: 8px;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .18);
            backdrop-filter: blur(12px);
            padding: 8px 18px;
            border-radius: 100px;
            font-size: 13px;
            font-weight: 500;
            color: #fff;
            margin-bottom: 22px
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
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px
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

        /* ═════ STICKY MOBILE ═════ */
        .sticky-cta {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            border-top: 1px solid var(--line);
            padding: 10px 14px;
            z-index: 99;
            box-shadow: 0 -4px 20px rgba(44, 26, 14, .1)
        }

        .sticky-call {
            flex: 1;
            padding: 12px;
            text-align: center;
            font-weight: 700;
            border-radius: 10px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            width: 100%
        }

        /* ═════ RESPONSIVE ═════ */
        @media(max-width:1024px) {
            .footer-inner {
                grid-template-columns: 1fr 1fr
            }
        }

        @media(max-width:768px) {
            .burger {
                display: flex
            }

            .nav {
                display: none;
                position: fixed;
                top: 74px;
                left: 0;
                right: 0;
                flex-direction: column;
                background: #fff;
                padding: 16px;
                box-shadow: 0 10px 30px rgba(44, 26, 14, .1);
                border-top: 1px solid var(--line)
            }

            .nav.nav-open {
                display: flex
            }

            .nav a {
                width: 100%;
                padding: 14px 16px;
                text-align: center
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

            .sticky-cta {
                display: flex
            }

            body {
                padding-bottom: 70px
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
                <a href="{{ route('admin.login') }}" class="nav-cta"><i class="bi bi-box-arrow-in-right"></i>
                    Connexion</a>
            </nav>
            <button class="burger" id="burger" aria-label="Menu"><span></span><span></span><span></span></button>
        </div>
    </header>

    <!-- HERO -->
    <section class="hero">
        <img src="{{ asset('images/backgroud.jpeg') }}" alt="Artisans au Bénin" class="hero-bg" />
        <div class="hero-overlay"></div>
        <div class="container hero-inner">
            <div class="hero-left">
                <div class="hero-badge" data-aos="fade-up">
                    <i class="bi bi-geo-alt-fill" style="color:var(--accent-light)"></i> Plateforme 100% béninoise
                </div>
                <h1 data-aos="fade-up" data-aos-delay="100">
                    L'application qui connecte <span class="hero-accent">artisans & clients</span> au Bénin.
                </h1>
                <p class="hero-sub" data-aos="fade-up" data-aos-delay="200">
                    Trouvez un artisan qualifié ou développez votre activité artisanale grâce à une plateforme mobile
                    simple, rapide et 100% gratuite.
                </p>
                <div class="hero-chips" data-aos="fade-up" data-aos-delay="300">
                    <span class="hero-chip"><i class="bi bi-patch-check-fill"></i> Profils vérifiés</span>
                    <span class="hero-chip"><i class="bi bi-lightning-charge-fill"></i> Temps réel</span>
                    <span class="hero-chip"><i class="bi bi-gift-fill"></i> 100% gratuit</span>
                </div>
                <div class="hero-actions" data-aos="fade-up" data-aos-delay="400">
                    <a href="{{ route('admin.login') }}" class="btn btn-cta">
                        <i class="bi bi-box-arrow-in-right"></i> Connexion
                    </a>
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

    <!-- STICKY CTA MOBILE -->
    <div class="sticky-cta">
        <a href="{{ route('admin.login') }}" class="sticky-call"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 60 });

        const burger = document.getElementById('burger');
        const nav = document.getElementById('nav');
        burger.addEventListener('click', () => {
            nav.classList.toggle('nav-open');
            burger.classList.toggle('open');
        });
        nav.querySelectorAll('a').forEach(l => l.addEventListener('click', () => {
            nav.classList.remove('nav-open');
            burger.classList.remove('open');
        }));

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