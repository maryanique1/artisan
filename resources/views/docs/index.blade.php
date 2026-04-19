<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation — FeGArtisan</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpeg') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{--primary:#6B2D0E;--secondary:#8B3D1A;--accent:#C17B4E;--accent-light:#E8B088;--bg:#FDF6EE;--bg-warm:#F5EDE0;--success:#4A7C59;--warning:#E8A020;--danger:#C94A3A;--ink:#2C1A0E;--text:#4A3424;--muted:#9A7A64;--line:#E8D5C0}
        *{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body{font-family:'Poppins',sans-serif;color:var(--text);background:var(--bg);margin:0;line-height:1.65}

        .doc-sidebar{position:fixed;top:0;left:0;width:300px;height:100vh;background:#fff;border-right:1px solid var(--line);overflow-y:auto;padding:18px 0;z-index:100}
        .doc-sidebar .brand{padding:14px 24px 18px;border-bottom:1px solid var(--line);margin-bottom:12px;display:flex;align-items:center;gap:12px}
        .doc-sidebar .brand img{width:36px;height:36px;border-radius:8px;object-fit:contain;background:#fff;padding:2px;box-shadow:0 4px 10px rgba(107,45,14,.15)}
        .doc-sidebar .brand h4{font-weight:900;color:var(--primary);margin:0;font-size:1.05rem;line-height:1}
        .doc-sidebar .brand h4 span{color:var(--accent)}
        .doc-sidebar .brand small{color:var(--muted);font-size:.65rem;letter-spacing:.15em;text-transform:uppercase}
        .doc-nav{list-style:none;padding:0;margin:0}
        .doc-nav li a{display:flex;align-items:center;gap:10px;padding:7px 24px;color:var(--muted);font-size:.81rem;text-decoration:none;transition:all .15s;border-left:3px solid transparent}
        .doc-nav li a:hover{color:var(--primary);background:var(--bg);border-left-color:var(--accent-light)}
        .doc-nav li a.active{color:var(--primary);background:var(--bg-warm);border-left-color:var(--accent);font-weight:600}
        .doc-nav li a i{width:18px;text-align:center;font-size:.9rem;flex-shrink:0;color:var(--accent)}
        .doc-nav .nav-section{padding:14px 24px 6px;font-size:.62rem;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.18em}

        .doc-main{margin-left:300px;padding:40px 54px;max-width:960px}
        .doc-main > h1{font-size:2rem;font-weight:900;color:var(--primary);margin:0 0 6px;letter-spacing:-.01em}
        .doc-main > p.lead{color:var(--muted);font-size:.98rem;margin-bottom:24px;line-height:1.7}

        .doc-section{margin-bottom:56px;scroll-margin-top:24px}
        .doc-section h2{font-size:1.45rem;font-weight:800;color:var(--primary);margin:0 0 14px;padding-bottom:10px;border-bottom:2px solid var(--line);display:flex;align-items:center;gap:12px;letter-spacing:-.01em}
        .doc-section h2 i{color:var(--accent);font-size:1.1rem;background:var(--bg-warm);width:36px;height:36px;border-radius:9px;display:inline-flex;align-items:center;justify-content:center}
        .doc-section h3{font-size:1.05rem;font-weight:700;color:var(--secondary);margin:28px 0 10px;display:flex;align-items:center;gap:8px}
        .doc-section h3 i{color:var(--accent);font-size:.95rem}
        .doc-section h4{font-size:.92rem;font-weight:700;color:var(--secondary);margin:18px 0 8px}
        .doc-section p{font-size:.9rem;line-height:1.75;color:var(--text)}
        .doc-section ul,.doc-section ol{padding-left:22px}
        .doc-section ul li,.doc-section ol li{font-size:.88rem;line-height:1.8;color:var(--text);margin-bottom:4px}
        .doc-section strong{color:var(--ink);font-weight:700}

        .cmd-block{background:#1a0a04;border-radius:10px;padding:14px 18px;margin:12px 0;font-family:'JetBrains Mono',monospace;font-size:.78rem;color:#f0d8c4;position:relative;overflow-x:auto;white-space:pre;line-height:1.7;border:1px solid #3a1608}
        .cmd-block .prompt{color:var(--accent-light)}
        .cmd-block .comment{color:#7a5a44;font-style:italic}
        .cmd-block .success{color:#7dc78f}
        .cmd-block .k{color:#f5a56b}
        .cmd-block .s{color:#c8e6a8}
        .cmd-block .q{color:#ffd580}

        .doc-info{background:#fff;border-left:4px solid var(--accent);border-radius:0 10px 10px 0;padding:13px 18px;margin:14px 0;font-size:.86rem;display:flex;gap:12px;align-items:flex-start;box-shadow:0 1px 3px rgba(44,26,14,.04)}
        .doc-info i{color:var(--accent);font-size:1.05rem;margin-top:2px;flex-shrink:0}
        .doc-info.success{border-left-color:var(--success);background:#f4fbf6}
        .doc-info.success i{color:var(--success)}
        .doc-info.warning{border-left-color:var(--warning);background:#fffaf0}
        .doc-info.warning i{color:var(--warning)}
        .doc-info.danger{border-left-color:var(--danger);background:#fdf4f2}
        .doc-info.danger i{color:var(--danger)}
        .doc-info strong{color:inherit}

        .doc-table{width:100%;border-collapse:collapse;margin:14px 0;font-size:.84rem;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 3px rgba(44,26,14,.04)}
        .doc-table th{background:var(--primary);color:#fff;padding:10px 14px;text-align:left;font-weight:700;font-size:.74rem;text-transform:uppercase;letter-spacing:.05em}
        .doc-table td{padding:10px 14px;border-bottom:1px solid var(--line);vertical-align:top}
        .doc-table tr:last-child td{border-bottom:none}
        .doc-table code{background:var(--bg-warm);padding:1px 6px;border-radius:4px;font-size:.76rem;font-family:'JetBrains Mono',monospace;color:var(--secondary)}

        p code, li code, td code{background:var(--bg-warm);padding:1px 6px;border-radius:4px;font-size:.82rem;font-family:'JetBrains Mono',monospace;color:var(--secondary);border:1px solid var(--line)}

        .step-card{background:#fff;border-radius:12px;padding:18px 22px 18px 38px;margin:18px 0;border:1px solid var(--line);border-left:5px solid var(--accent);position:relative;box-shadow:0 1px 3px rgba(44,26,14,.03)}
        .step-card .step-number{position:absolute;top:-12px;left:-14px;width:32px;height:32px;border-radius:50%;background:var(--accent);color:#fff;font-weight:800;font-size:.85rem;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 8px rgba(193,123,78,.35)}
        .step-card h4{margin:0 0 6px;color:var(--primary);font-size:1rem;font-weight:700}

        .kbd{display:inline-block;background:#2C1A0E;color:#fff;padding:2px 8px;border-radius:4px;font-family:'JetBrains Mono',monospace;font-size:.75rem;font-weight:600;box-shadow:0 2px 0 #1a0a04}

        .route-table td:first-child{white-space:nowrap;font-weight:600;font-family:'JetBrains Mono',monospace;font-size:.76rem}
        .method{display:inline-block;padding:2px 7px;border-radius:4px;font-size:.66rem;font-weight:700;font-family:'JetBrains Mono',monospace;letter-spacing:.04em}
        .method.get{background:#E1EDF7;color:#2C5A85}
        .method.post{background:#E7F5EC;color:#2B6B43}
        .method.put{background:#FDF3DD;color:#A77914}
        .method.patch{background:#FAEEDD;color:#A77914}
        .method.delete{background:#FEE4E0;color:#A8332A}

        .pill{display:inline-flex;align-items:center;gap:5px;background:var(--bg-warm);border:1px solid var(--line);border-radius:100px;padding:3px 11px;font-size:.73rem;font-weight:600;color:var(--primary);margin:2px}

        .back-link{position:fixed;bottom:20px;right:20px;z-index:200}
        .back-link a{background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;padding:10px 18px;border-radius:10px;font-size:.82rem;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;box-shadow:0 6px 18px rgba(107,45,14,.3);transition:all .2s}
        .back-link a:hover{transform:translateY(-2px);box-shadow:0 10px 24px rgba(107,45,14,.4)}

        .prompt-box{background:#0d1117;border-radius:10px;padding:14px 18px;margin:12px 0;font-family:'JetBrains Mono',monospace;font-size:.78rem;line-height:1.8;border:1px solid #30363d;overflow-x:auto}
        .prompt-box .pq{color:#79c0ff}
        .prompt-box .po{color:#d2a8ff}
        .prompt-box .pa{color:#56d364;font-weight:600}
        .prompt-box .pc{color:#8b949e;font-style:italic}

        hr{border:none;border-top:1px solid var(--line);margin:28px 0}

        @media(max-width:768px){
            .doc-sidebar{display:none}
            .doc-main{margin-left:0;padding:20px 16px}
        }
    </style>
</head>
<body>

<nav class="doc-sidebar">
    <div class="brand">
        <img src="{{ asset('images/logo.jpeg') }}" alt="">
        <div>
            <h4>FeG<span>Artisan</span></h4>
            <small>Documentation</small>
        </div>
    </div>
    <ul class="doc-nav">
        <li class="nav-section">Présentation</li>
        <li><a href="#intro"><i class="bi bi-book"></i> 1. Introduction</a></li>
        <li><a href="#architecture"><i class="bi bi-diagram-3"></i> 2. Architecture</a></li>
        <li><a href="#prerequis"><i class="bi bi-check2-square"></i> 3. Prérequis</a></li>

        <li class="nav-section">Créer le projet</li>
        <li><a href="#installer"><i class="bi bi-download"></i> 4. Installer Laravel Installer</a></li>
        <li><a href="#new-project"><i class="bi bi-box"></i> 5. Créer le projet</a></li>
        <li><a href="#packages"><i class="bi bi-puzzle"></i> 6. Installer les paquets</a></li>
        <li><a href="#env"><i class="bi bi-gear"></i> 7. Configurer .env</a></li>

        <li class="nav-section">Structure du code</li>
        <li><a href="#folders"><i class="bi bi-folder2-open"></i> 8. Créer les dossiers</a></li>
        <li><a href="#migrations-create"><i class="bi bi-file-earmark-code"></i> 9. Écrire les migrations</a></li>
        <li><a href="#database"><i class="bi bi-database"></i> 10. Base de données TiDB</a></li>
        <li><a href="#models"><i class="bi bi-hexagon"></i> 11. Créer les Modèles</a></li>
        <li><a href="#controllers"><i class="bi bi-cpu"></i> 12. Créer les Controllers</a></li>
        <li><a href="#routes-create"><i class="bi bi-signpost-split"></i> 13. Déclarer les Routes</a></li>
        <li><a href="#views"><i class="bi bi-window"></i> 14. Créer les Vues Blade</a></li>

        <li class="nav-section">Services</li>
        <li><a href="#storage"><i class="bi bi-folder"></i> 15. Storage & fichiers</a></li>
        <li><a href="#firebase"><i class="bi bi-fire"></i> 16. Firebase (FCM)</a></li>
        <li><a href="#reverb"><i class="bi bi-broadcast"></i> 17. WebSockets Reverb</a></li>

        <li class="nav-section">Lancer & tester</li>
        <li><a href="#run"><i class="bi bi-play-circle"></i> 18. Démarrer les serveurs</a></li>
        <li><a href="#admin"><i class="bi bi-shield-lock"></i> 19. Dashboard admin</a></li>
        <li><a href="#api-test"><i class="bi bi-plug"></i> 20. Tester l'API</a></li>

        <li class="nav-section">Références</li>
        <li><a href="#admin-pages"><i class="bi bi-columns"></i> 21. Pages admin</a></li>
        <li><a href="#routes"><i class="bi bi-signpost-2"></i> 22. Toutes les routes API</a></li>
        <li><a href="#commands"><i class="bi bi-terminal"></i> 23. Commandes Artisan</a></li>
        <li><a href="#accounts"><i class="bi bi-people"></i> 24. Comptes de test</a></li>

        <li class="nav-section">Aide</li>
        <li><a href="#troubleshoot"><i class="bi bi-life-preserver"></i> 25. Dépannage</a></li>
        <li><a href="#deploy"><i class="bi bi-rocket"></i> 26. Déploiement</a></li>
    </ul>
</nav>

<div class="doc-main">

<h1>Documentation FeGArtisan</h1>
<p class="lead">Guide complet pour créer le projet <strong>de zéro</strong> sur un ordinateur vierge. Chaque étape est détaillée avec les commandes exactes, les réponses aux questions posées par Laravel, et les explications de pourquoi on fait chaque chose. Suivez les sections dans l'ordre.</p>

<div class="doc-info">
    <i class="bi bi-lightbulb-fill"></i>
    <div>Les blocs <strong>noirs</strong> sont des commandes à taper dans le terminal. Les blocs <strong>bleu nuit</strong> sont des dialogues interactifs où Laravel pose des questions. Copiez-collez les commandes telles quelles.</div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="intro">
    <h2><i class="bi bi-book"></i> 1. Qu'est-ce que FeGArtisan&nbsp;?</h2>
    <p><strong>FeGArtisan</strong> est une plateforme qui met en relation des <strong>artisans</strong> (couturières, plombiers, électriciens…) et des <strong>clients</strong> au Bénin.</p>

    <h3>Les 3 types d'utilisateurs</h3>
    <table class="doc-table">
        <tr><th>Qui</th><th>Où</th><th>Ce qu'il fait</th></tr>
        <tr><td><strong>Client</strong></td><td>Appli mobile Flutter</td><td>Chercher un artisan, discuter, laisser un avis</td></tr>
        <tr><td><strong>Artisan</strong></td><td>Appli mobile Flutter</td><td>Créer son profil, publier du contenu, recevoir des clients</td></tr>
        <tr><td><strong>Admin</strong></td><td>Site web Laravel (ce backend)</td><td>Valider les artisans, modérer, traiter les signalements</td></tr>
    </table>

    <div class="doc-info warning">
        <i class="bi bi-info-circle"></i>
        <div><strong>Important :</strong> les clients et artisans n'ont <strong>pas</strong> de site web. Ils utilisent uniquement l'appli Flutter qui communique avec ce backend via une API REST. Seul l'admin utilise le navigateur.</div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="architecture">
    <h2><i class="bi bi-diagram-3"></i> 2. Architecture technique</h2>

<div class="cmd-block"><span class="comment">#  Vue d'ensemble</span>

  📱  <span class="k">Appli Flutter</span> ─────┐
       (clients + artisans)     │  API REST (JSON)
                                ▼
                        <span class="k">Laravel 12</span>  ◀────▶  <span class="k">MySQL TiDB Cloud</span>
                                ▲
                                │
  🌐  <span class="k">Dashboard Admin</span> ───┤   (Blade + Bootstrap 5, navigateur)
                                │
  🔔  <span class="k">Firebase FCM</span> ◀────┤   (push notifs → téléphones)
                                │
  ⚡  <span class="k">Laravel Reverb</span> ◀──┘   (WebSockets temps réel)</div>

    <h3>Rôle de chaque composant</h3>
    <table class="doc-table">
        <tr><th>Composant</th><th>Rôle</th></tr>
        <tr><td><strong>Laravel 12</strong></td><td>Le cœur du projet. Gère l'API, l'authentification, les règles métier, le dashboard admin</td></tr>
        <tr><td><strong>TiDB Cloud</strong></td><td>Base de données MySQL hébergée dans le cloud. Stocke users, artisans, messages, etc.</td></tr>
        <tr><td><strong>Sanctum</strong></td><td>Génère les tokens d'accès que Flutter envoie dans chaque requête API</td></tr>
        <tr><td><strong>Reverb</strong></td><td>Serveur WebSocket. Permet d'envoyer des messages en temps réel sans recharger</td></tr>
        <tr><td><strong>Firebase FCM</strong></td><td>Envoie des notifications push vers les téléphones Android/iOS quand l'appli est fermée</td></tr>
    </table>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="prerequis">
    <h2><i class="bi bi-check2-square"></i> 3. Prérequis à installer sur votre PC</h2>
    <p>Avant de commencer, installez ces outils dans l'ordre. Tous sont gratuits.</p>

    <table class="doc-table">
        <tr><th>Outil</th><th>Version min.</th><th>Où télécharger</th><th>Rôle</th></tr>
        <tr><td><strong>XAMPP</strong></td><td>8.2+</td><td>apachefriends.org</td><td>Installe PHP + Apache sur votre machine</td></tr>
        <tr><td><strong>Composer</strong></td><td>2.x</td><td>getcomposer.org</td><td>Gestionnaire de dépendances PHP (comme npm pour JS)</td></tr>
        <tr><td><strong>Node.js</strong></td><td>18+</td><td>nodejs.org</td><td>Nécessaire pour compiler le CSS/JS (Vite)</td></tr>
        <tr><td><strong>Git</strong></td><td>—</td><td>git-scm.com</td><td>Gestion de version du code</td></tr>
        <tr><td><strong>VS Code</strong></td><td>—</td><td>code.visualstudio.com</td><td>Éditeur de code recommandé</td></tr>
        <tr><td><strong>Thunder Client</strong></td><td>—</td><td>Extension VS Code</td><td>Tester l'API (comme Postman, mais sans compte)</td></tr>
    </table>

    <h3>Vérifier que PHP et Composer sont installés</h3>
    <p>Ouvrez un terminal (PowerShell sous Windows) et tapez :</p>
<div class="cmd-block"><span class="prompt">$</span> php -v
<span class="success">PHP 8.2.12 (cli) ...</span>

<span class="prompt">$</span> composer --version
<span class="success">Composer version 2.7.1 ...</span>

<span class="prompt">$</span> node --version
<span class="success">v20.11.0</span></div>

    <div class="doc-info warning">
        <i class="bi bi-exclamation-triangle"></i>
        <div><strong>PHP introuvable sous Windows ?</strong> XAMPP installe PHP dans <code>C:\xampp\php\</code>. Ajoutez ce chemin à la variable d'environnement <strong>PATH</strong> : Paramètres Windows → Rechercher "Variables d'environnement" → PATH → Ajouter <code>C:\xampp\php</code>. Redémarrez le terminal.</div>
    </div>

    <h3>Activer l'extension sodium (requise par Firebase)</h3>
    <p>Ouvrez le fichier <code>C:\xampp\php\php.ini</code> dans VS Code. Cherchez la ligne <code>;extension=sodium</code> et enlevez le <code>;</code> :</p>
<div class="cmd-block"><span class="comment"># Avant (ligne commentée = désactivée) :</span>
;extension=sodium

<span class="comment"># Après (activée) :</span>
extension=sodium</div>
    <p>Sauvegardez, fermez le terminal et rouvrez-le. Vérifiez :</p>
<div class="cmd-block"><span class="prompt">$</span> php -m | findstr sodium
<span class="success">sodium</span></div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="installer">
    <h2><i class="bi bi-download"></i> 4. Installer le Laravel Installer</h2>
    <p>Le <strong>Laravel Installer</strong> est un outil global qui ajoute la commande <code>laravel new</code> à votre terminal. On l'installe une seule fois sur votre machine, pas à refaire à chaque projet.</p>

<div class="cmd-block"><span class="prompt">$</span> composer global require laravel/installer
<span class="comment">→ installe l'outil sur votre PC (2-3 min)</span></div>

    <p>Ensuite, ajoutez le dossier global de Composer à votre PATH. Sur Windows, le chemin est généralement :</p>
<div class="cmd-block">C:\Users\VOTRE_NOM\AppData\Roaming\Composer\vendor\bin</div>
    <p>Ajoutez ce chemin dans les Variables d'environnement (même procédure que pour PHP). Redémarrez le terminal puis vérifiez :</p>
<div class="cmd-block"><span class="prompt">$</span> laravel --version
<span class="success">Laravel Installer 5.x.x</span></div>

    <div class="doc-info success">
        <i class="bi bi-check-circle"></i>
        <div>Sur Mac, le chemin est <code>/Users/VOTRE_NOM/.composer/vendor/bin</code>. Ajoutez-le à votre <code>~/.zshrc</code> ou <code>~/.bashrc</code>.</div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="new-project">
    <h2><i class="bi bi-box"></i> 5. Créer le projet Laravel</h2>
    <p>Naviguez dans le dossier où vous voulez travailler, puis lancez la commande de création :</p>

<div class="cmd-block"><span class="prompt">$</span> cd "C:\Mes Projets\Laravel"
<span class="prompt">$</span> laravel new fegartisan</div>

    <p>Laravel va vous poser <strong>5 questions</strong> une par une. Voici exactement quoi répondre et pourquoi :</p>

    <div class="step-card">
        <div class="step-number">Q1</div>
        <h4>Quel starter kit voulez-vous installer ?</h4>
<div class="prompt-box"><span class="pq"> Which starter kit would you like to install?</span>
<span class="po">  None ...............................................................................</span>
<span class="po">  Laravel Breeze</span>
<span class="po">  Laravel Jetstream</span>

<span class="pc">→ Sélectionnez :</span> <span class="pa">None</span></div>
        <p>Breeze et Jetstream sont des kits d'authentification pour les utilisateurs normaux (login, inscription). On n'en a pas besoin ici car on code notre propre système admin et l'API Flutter.</p>
    </div>

    <div class="step-card">
        <div class="step-number">Q2</div>
        <h4>Quel framework de test ?</h4>
<div class="prompt-box"><span class="pq"> Which testing framework do you prefer?</span>
<span class="po">  Pest ................................................................................</span>
<span class="po">  PHPUnit</span>

<span class="pc">→ Sélectionnez :</span> <span class="pa">Pest</span> <span class="pc">(la valeur par défaut, appuyez sur Entrée)</span></div>
        <p>Pest est le framework de test moderne de Laravel. Ce choix n'a aucun impact sur le développement normal.</p>
    </div>

    <div class="step-card">
        <div class="step-number">Q3</div>
        <h4>Initialiser un dépôt Git ?</h4>
<div class="prompt-box"><span class="pq"> Would you like to initialize a Git repository?</span>
<span class="po">  Yes</span>
<span class="po">  No</span>

<span class="pc">→ Sélectionnez :</span> <span class="pa">Yes</span> <span class="pc">(recommandé pour versionner votre code)</span></div>
    </div>

    <div class="step-card">
        <div class="step-number">Q4</div>
        <h4>Quelle base de données ?</h4>
<div class="prompt-box"><span class="pq"> Which database will your application use?</span>
<span class="po">  SQLite .............................................................................</span>
<span class="po">  MySQL</span>
<span class="po">  MariaDB</span>
<span class="po">  PostgreSQL</span>
<span class="po">  SQL Server (Missing PDO extension)</span>

<span class="pc">→ Sélectionnez :</span> <span class="pa">MySQL</span> <span class="pc">(TiDB Cloud est compatible MySQL)</span></div>
        <p>On utilise TiDB Cloud qui est une base MySQL hébergée. Sélectionner MySQL configure le bon driver dans <code>.env</code>.</p>
    </div>

    <div class="step-card">
        <div class="step-number">Q5</div>
        <h4>⚠️ Lancer les migrations maintenant ?</h4>
<div class="prompt-box"><span class="pq"> Would you like to run the default database migrations?</span>
<span class="po">  Yes</span>
<span class="po">  No</span>

<span class="pc">→ Sélectionnez :</span> <span class="pa">No</span> ← <span class="pc">TRÈS IMPORTANT</span></div>
        <div class="doc-info danger">
            <i class="bi bi-exclamation-octagon"></i>
            <div>Répondez <strong>No</strong> ici. Si vous répondez Yes, Laravel essaiera de se connecter à une base locale qui n'existe pas encore (TiDB n'est pas encore configuré dans .env). Vous feriez les migrations plus tard, après avoir configuré la connexion.</div>
        </div>
    </div>

    <p>À la fin, Laravel crée le dossier <code>fegartisan/</code> et installe toutes ses dépendances. Entrez dans le projet :</p>
<div class="cmd-block"><span class="prompt">$</span> cd fegartisan</div>

    <p>Vérifiez que tout tourne :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan serve
<span class="success">→ Server running on [http://127.0.0.1:8000]</span></div>
    <p>Ouvrez <code>http://127.0.0.1:8000</code> — vous devez voir la page Laravel. Arrêtez avec <span class="kbd">Ctrl+C</span>.</p>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="packages">
    <h2><i class="bi bi-puzzle"></i> 6. Installer les paquets requis</h2>
    <p>Un <strong>paquet</strong> (ou dépendance) est du code tiers qu'on ajoute à notre projet. On les installe avec Composer depuis le terminal, dans le dossier <code>fegartisan/</code>.</p>

    <div class="step-card">
        <div class="step-number">1</div>
        <h4>Laravel Sanctum — tokens d'authentification API</h4>
        <p>Sanctum génère des tokens que l'appli Flutter envoie dans ses requêtes pour s'identifier. Il est déjà inclus dans Laravel 12. Vérifiez <code>composer.json</code> que <code>"laravel/sanctum"</code> est présent. Si non :</p>
<div class="cmd-block"><span class="prompt">$</span> composer require laravel/sanctum</div>
        <p>Publiez sa configuration :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
<span class="comment">→ crée config/sanctum.php et la migration personal_access_tokens</span></div>
    </div>

    <div class="step-card">
        <div class="step-number">2</div>
        <h4>Laravel Reverb — WebSockets temps réel</h4>
<div class="cmd-block"><span class="prompt">$</span> composer require laravel/reverb</div>
        <p>Initialisez-le (génère les clés dans <code>.env</code> et crée <code>config/reverb.php</code>) :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan reverb:install

<span class="comment">→ Il posera peut-être des questions, acceptez les valeurs par défaut.</span></div>
    </div>

    <div class="step-card">
        <div class="step-number">3</div>
        <h4>Firebase PHP — notifications push FCM</h4>
        <p>On utilise la version <strong>7.x</strong> car la 8.x exige PHP 8.3+. Si votre PHP est 8.2, utilisez :</p>
<div class="cmd-block"><span class="prompt">$</span> composer require "kreait/firebase-php:^7.16"</div>
        <p>Si vous avez PHP 8.3 ou plus :</p>
<div class="cmd-block"><span class="prompt">$</span> php -v   <span class="comment"># vérifiez votre version</span>
<span class="prompt">$</span> composer require kreait/firebase-php   <span class="comment"># sans contrainte de version</span></div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="env">
    <h2><i class="bi bi-gear"></i> 7. Configurer le fichier <code>.env</code></h2>
    <p>Le fichier <code>.env</code> (à la racine du projet) contient toutes les configurations sensibles. Il <strong>n'est jamais partagé sur Git</strong>. Laravel l'a déjà créé avec des valeurs par défaut — on va juste modifier certaines lignes.</p>
    <p>Ouvrez <code>.env</code> dans VS Code :</p>
<div class="cmd-block"><span class="prompt">$</span> code .env</div>

    <h3>Identité de l'application</h3>
    <p>Modifiez le nom et la locale :</p>
<div class="cmd-block"><span class="k">APP_NAME</span>=FeGArtisan
<span class="k">APP_ENV</span>=local
<span class="k">APP_DEBUG</span>=true
<span class="k">APP_URL</span>=http://localhost:8000
<span class="k">APP_LOCALE</span>=fr
<span class="k">APP_FALLBACK_LOCALE</span>=fr
<span class="k">APP_FAKER_LOCALE</span>=fr_FR</div>

    <h3>Base de données TiDB Cloud</h3>
    <p>Remplacez les lignes <code>DB_*</code> par défaut :</p>
<div class="cmd-block"><span class="k">DB_CONNECTION</span>=mysql
<span class="k">DB_HOST</span>=<span class="s">gateway01.us-east-1.prod.aws.tidbcloud.com</span>   <span class="comment"># votre host TiDB</span>
<span class="k">DB_PORT</span>=4000
<span class="k">DB_DATABASE</span>=fegartisan
<span class="k">DB_USERNAME</span>=<span class="s">votre-username-tidb</span>
<span class="k">DB_PASSWORD</span>=<span class="s">votre-password-tidb</span>
<span class="k">MYSQL_ATTR_SSL_CA</span>=ssl/ca.pem</div>
    <div class="doc-info warning">
        <i class="bi bi-shield-lock"></i>
        <div>Le fichier <code>ssl/ca.pem</code> est le certificat SSL de TiDB. Créez le dossier <code>ssl/</code> à la racine du projet et placez-y ce fichier (téléchargeable depuis TiDB Cloud → votre cluster → <strong>Connect</strong> → <strong>CA Certificate</strong>).</div>
    </div>

    <h3>Sessions, queues et cache</h3>
<div class="cmd-block"><span class="k">SESSION_DRIVER</span>=database
<span class="k">QUEUE_CONNECTION</span>=database
<span class="k">CACHE_STORE</span>=database
<span class="k">BROADCAST_CONNECTION</span>=reverb</div>

    <h3>Laravel Reverb (WebSockets)</h3>
    <p>Ces valeurs ont été générées automatiquement par <code>reverb:install</code>. Vérifiez qu'elles sont présentes :</p>
<div class="cmd-block"><span class="k">REVERB_APP_ID</span>=<span class="s">votre-id-genere</span>
<span class="k">REVERB_APP_KEY</span>=<span class="s">votre-key-generee</span>
<span class="k">REVERB_APP_SECRET</span>=<span class="s">votre-secret-genere</span>
<span class="k">REVERB_HOST</span>="localhost"
<span class="k">REVERB_PORT</span>=8080
<span class="k">REVERB_SCHEME</span>=http</div>

    <h3>Firebase FCM</h3>
<div class="cmd-block"><span class="k">FIREBASE_CREDENTIALS</span>=storage/firebase/service-account.json
<span class="k">FIREBASE_PUSH_ENABLED</span>=true</div>
    <p>Le fichier <code>service-account.json</code> est placé manuellement (voir section 16).</p>

    <h3>Vider le cache de config après chaque modification</h3>
    <p>Chaque fois que vous modifiez <code>.env</code>, exécutez :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan config:clear</div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="folders">
    <h2><i class="bi bi-folder2-open"></i> 8. Créer la structure des dossiers et fichiers</h2>
    <p>Laravel crée une structure de base, mais FeGArtisan a besoin de dossiers supplémentaires pour séparer le code admin du code API. Voici comment les créer et à quoi ils servent.</p>

    <h3>Dossiers des Controllers</h3>
    <p>Les controllers contiennent la logique de l'application. On les sépare en deux groupes :</p>
<div class="cmd-block"><span class="comment"># app/Http/Controllers/ contient déjà Controller.php de base</span>
<span class="comment"># On crée deux sous-dossiers :</span>

app/Http/Controllers/
├── Admin/          <span class="comment"># ← controllers du dashboard web (navigateur)</span>
│   ├── AuthController.php
│   ├── DashboardController.php
│   ├── UserController.php
│   ├── CategoryController.php
│   ├── PublicationController.php
│   ├── ReportController.php
│   └── ProfileController.php
└── Api/            <span class="comment"># ← controllers de l'API REST (Flutter)</span>
    ├── AuthController.php
    ├── ArtisanController.php
    ├── PublicationController.php
    └── ...</div>

    <p>Laravel peut créer les dossiers automatiquement quand vous créez un controller (voir section 12). Ou créez-les manuellement dans VS Code.</p>

    <h3>Dossiers des Vues Blade</h3>
    <p>Les vues sont dans <code>resources/views/</code>. Créez cette arborescence :</p>
<div class="cmd-block">resources/views/
├── welcome.blade.php           <span class="comment"># page d'accueil publique (déjà existante)</span>
├── docs/
│   └── index.blade.php         <span class="comment"># cette documentation</span>
└── admin/
    ├── layouts/
    │   └── app.blade.php       <span class="comment"># template principal (sidebar + navbar)</span>
    ├── auth/
    │   └── login.blade.php     <span class="comment"># page de connexion admin</span>
    ├── dashboard.blade.php
    ├── users/
    │   ├── index.blade.php
    │   └── show.blade.php
    ├── categories/
    │   └── index.blade.php
    ├── publications/
    │   └── index.blade.php
    ├── reports/
    │   └── index.blade.php
    └── profile/
        └── show.blade.php</div>

    <p>Pour créer un fichier Blade, faites <strong>clic-droit → Nouveau fichier</strong> dans VS Code, ou via le terminal :</p>
<div class="cmd-block"><span class="comment"># Windows PowerShell — créer un fichier vide :</span>
<span class="prompt">$</span> New-Item -ItemType File -Path "resources\views\admin\layouts\app.blade.php" -Force

<span class="comment"># Mac/Linux :</span>
<span class="prompt">$</span> mkdir -p resources/views/admin/layouts
<span class="prompt">$</span> touch resources/views/admin/layouts/app.blade.php</div>

    <h3>Dossier des Events et Listeners (WebSockets + FCM)</h3>
<div class="cmd-block">app/
├── Events/
│   ├── NewMessageSent.php
│   ├── NewNotification.php
│   └── ArtisanValidationUpdated.php
├── Listeners/
│   ├── SendFcmForMessage.php
│   └── SendFcmForNotification.php
└── Services/
    └── FirebasePushService.php</div>

    <p>Pour créer un Event ou Listener avec Artisan :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan make:event NewMessageSent
<span class="prompt">$</span> php artisan make:listener SendFcmForMessage --event=NewMessageSent</div>

    <h3>Fichier de configuration Firebase</h3>
    <p>Créez le fichier <code>config/firebase.php</code> :</p>
<div class="cmd-block"><span class="comment"># Créez le fichier config/firebase.php et écrivez dedans :</span>
&lt;?php
return [
    'credentials' =&gt; env('FIREBASE_CREDENTIALS'),
    'push_enabled' =&gt; env('FIREBASE_PUSH_ENABLED', true),
];</div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="migrations-create">
    <h2><i class="bi bi-file-earmark-code"></i> 9. Créer et écrire les migrations</h2>
    <p>Une <strong>migration</strong> est un fichier PHP qui décrit la structure d'une table (colonnes, types, relations). C'est comme le plan de construction d'une table. On crée d'abord ce plan, puis on l'exécute pour que la base soit créée réellement.</p>

    <h3>Étape 1 — Générer le fichier de migration</h3>
    <p>La commande <code>make:migration</code> crée un fichier vide dans <code>database/migrations/</code> :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan make:migration create_categories_table --create=categories
<span class="success">→ Created Migration: 2026_04_17_000001_create_categories_table.php</span>

<span class="comment"># Pour ajouter une colonne à une table existante :</span>
<span class="prompt">$</span> php artisan make:migration add_image_to_categories_table --table=categories</div>

    <h3>Étape 2 — Écrire les colonnes dans le fichier</h3>
    <p>Ouvrez le fichier généré dans <code>database/migrations/</code>. Vous trouverez une méthode <code>up()</code> vide. C'est là qu'on définit les colonnes :</p>

<div class="cmd-block">public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();                           <span class="comment">// colonne id auto-incrémentée (toujours en premier)</span>
        $table->string('name');                 <span class="comment">// VARCHAR 255 — texte court</span>
        $table->string('slug')-&gt;unique();      <span class="comment">// unique = pas de doublons</span>
        $table->string('icon')-&gt;nullable();    <span class="comment">// nullable = peut être vide</span>
        $table->text('description')-&gt;nullable();<span class="comment">// TEXT — texte long</span>
        $table->boolean('is_active')-&gt;default(true); <span class="comment">// true/false avec valeur par défaut</span>
        $table->timestamps();                   <span class="comment">// created_at + updated_at automatiques</span>
    });
}</div>

    <h3>Types de colonnes les plus utilisés</h3>
    <table class="doc-table">
        <tr><th>Méthode</th><th>Type SQL</th><th>Utilisation</th></tr>
        <tr><td><code>$table->string('nom')</code></td><td>VARCHAR(255)</td><td>Noms, emails, textes courts</td></tr>
        <tr><td><code>$table->text('contenu')</code></td><td>TEXT</td><td>Descriptions, messages longs</td></tr>
        <tr><td><code>$table->integer('quantite')</code></td><td>INT</td><td>Nombres entiers</td></tr>
        <tr><td><code>$table->decimal('prix', 8, 2)</code></td><td>DECIMAL</td><td>Prix, coordonnées GPS</td></tr>
        <tr><td><code>$table->boolean('actif')</code></td><td>TINYINT(1)</td><td>Vrai/Faux</td></tr>
        <tr><td><code>$table->enum('role', ['a','b'])</code></td><td>ENUM</td><td>Valeur parmi une liste fixe</td></tr>
        <tr><td><code>$table->timestamp('publié_le')</code></td><td>TIMESTAMP</td><td>Date + heure</td></tr>
        <tr><td><code>$table->foreignId('user_id')->constrained()</code></td><td>FK</td><td>Lien vers la table users</td></tr>
        <tr><td><code>->nullable()</code></td><td>—</td><td>La colonne peut être NULL</td></tr>
        <tr><td><code>->default('valeur')</code></td><td>—</td><td>Valeur si rien n'est fourni</td></tr>
        <tr><td><code>->unique()</code></td><td>—</td><td>Interdit les doublons</td></tr>
    </table>

    <h3>Toutes les migrations de FeGArtisan</h3>
    <p>Voici toutes les tables du projet avec leurs colonnes principales :</p>

    <h4>Table users (créée par défaut par Laravel, modifiée)</h4>
<div class="cmd-block">$table->id();
$table->string('first_name');
$table->string('last_name');
$table->string('name')-&gt;nullable();               <span class="comment">// nom complet pour compatibilité</span>
$table->string('email')-&gt;unique();
$table->string('phone')-&gt;nullable()-&gt;unique();
$table->enum('role', ['client', 'artisan', 'admin'])-&gt;default('client');
$table->string('avatar')-&gt;nullable();
$table->string('ville')-&gt;nullable();
$table->string('quartier')-&gt;nullable();
$table->boolean('is_active')-&gt;default(true);
$table->timestamp('email_verified_at')-&gt;nullable();
$table->string('password');
$table->rememberToken();
$table->timestamps();</div>

    <h4>Table artisan_profiles</h4>
<div class="cmd-block">$table->id();
$table->foreignId('user_id')-&gt;constrained()-&gt;cascadeOnDelete();
$table->foreignId('category_id')-&gt;nullable()-&gt;constrained()-&gt;nullOnDelete();
$table->string('metier');
$table->text('description')-&gt;nullable();
$table->string('ville');
$table->string('quartier');
$table->string('proof_document')-&gt;nullable();
$table->string('proof_type')-&gt;nullable();         <span class="comment">// diplome, certificat, preuve_experience</span>
$table->enum('validation_status', ['pending','approved','rejected','suspended'])-&gt;default('pending');
$table->text('rejection_reason')-&gt;nullable();
$table->timestamp('validated_at')-&gt;nullable();
$table->boolean('is_available')-&gt;default(true);
$table->decimal('rating_avg', 3, 2)-&gt;default(0);
$table->unsignedInteger('rating_count')-&gt;default(0);
$table->unsignedInteger('views_count')-&gt;default(0);
$table->timestamps();</div>

    <h4>Table publications</h4>
<div class="cmd-block">$table->id();
$table->foreignId('artisan_profile_id')-&gt;constrained()-&gt;cascadeOnDelete();
$table->enum('type', ['text','image','video'])-&gt;default('text');
$table->text('content')-&gt;nullable();
$table->string('media_url')-&gt;nullable();
$table->unsignedInteger('views_count')-&gt;default(0);
$table->timestamps();</div>

    <h4>Table conversations &amp; messages</h4>
<div class="cmd-block"><span class="comment"># conversations</span>
$table->id();
$table->foreignId('client_id')-&gt;constrained('users')-&gt;cascadeOnDelete();
$table->foreignId('artisan_id')-&gt;constrained('users')-&gt;cascadeOnDelete();
$table->timestamp('last_message_at')-&gt;nullable();
$table->timestamps();

<span class="comment"># messages</span>
$table->id();
$table->foreignId('conversation_id')-&gt;constrained()-&gt;cascadeOnDelete();
$table->foreignId('sender_id')-&gt;constrained('users')-&gt;cascadeOnDelete();
$table->text('content')-&gt;nullable();
$table->string('type')-&gt;default('text');   <span class="comment">// text, image, file</span>
$table->string('media_url')-&gt;nullable();
$table->timestamp('read_at')-&gt;nullable();
$table->timestamps();</div>

    <div class="doc-info">
        <i class="bi bi-info-circle"></i>
        <div><strong>Astuce :</strong> créez d'abord les tables <em>sans</em> clés étrangères (ex : <code>users</code>, <code>categories</code>), puis les tables <em>avec</em> clés étrangères (ex : <code>artisan_profiles</code> qui référence <code>users</code>). Le numéro dans le nom du fichier fixe l'ordre d'exécution.</div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="database">
    <h2><i class="bi bi-database"></i> 10. Base de données TiDB Cloud</h2>
    <p>TiDB Cloud est une base MySQL hébergée en ligne. Pas besoin d'installer MySQL sur votre PC.</p>

    <h3>Créer un compte et un cluster TiDB (si pas encore fait)</h3>
    <ol>
        <li>Allez sur <strong>tidbcloud.com</strong> et créez un compte gratuit</li>
        <li>Créez un cluster <strong>Serverless</strong> (gratuit, pas de carte bancaire)</li>
        <li>Dans <strong>Connect</strong> → choisissez le driver <em>General</em></li>
        <li>Notez le <strong>Host</strong>, <strong>Username</strong>, <strong>Password</strong> → mettez-les dans <code>.env</code></li>
        <li>Téléchargez le <strong>CA Certificate</strong> et placez-le dans <code>ssl/ca.pem</code> à la racine du projet</li>
    </ol>

    <h3>Créer la base de données</h3>
    <p>Depuis l'interface TiDB Cloud, allez dans <strong>SQL Editor</strong> et exécutez :</p>
<div class="cmd-block">CREATE DATABASE fegartisan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;</div>

    <h3>Exécuter les migrations</h3>
    <p>Une fois <code>.env</code> configuré et la base créée, lancez les migrations pour créer toutes les tables :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan migrate

<span class="success">INFO  Running migrations.</span>
  0001_01_01_000000_create_users_table ............ <span class="success">DONE</span>
  0001_01_01_000001_create_cache_table ............ <span class="success">DONE</span>
  0001_01_01_000002_create_jobs_table ............. <span class="success">DONE</span>
  2026_04_17_000001_create_categories_table ....... <span class="success">DONE</span>
  2026_04_17_000002_create_artisan_profiles_table . <span class="success">DONE</span>
  2026_04_17_000003_create_publications_table ..... <span class="success">DONE</span>
  ...
  2026_04_18_000002_add_fcm_token_to_users_table .. <span class="success">DONE</span></div>

    <div class="doc-info danger">
        <i class="bi bi-exclamation-octagon"></i>
        <div><strong>Réinitialiser complètement la base :</strong> <code>php artisan migrate:fresh</code> supprime <strong>toutes les données</strong> et recrée tout. Ne faites cela qu'en développement. Ajoutez <code>--seed</code> pour remettre les données de test.</div>
    </div>

    <h3>Remplir la base avec des données de test (Seeder)</h3>
    <p>Le seeder crée automatiquement l'admin, des catégories, un artisan validé et un client de démo :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan db:seed

<span class="comment"># En une seule commande (recrée tout + seed) :</span>
<span class="prompt">$</span> php artisan migrate:fresh --seed</div>
    <p>Le fichier seeder est <code>database/seeders/DatabaseSeeder.php</code>. Voir la section <a href="#accounts">24 — Comptes de test</a> pour les identifiants créés.</p>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="models">
    <h2><i class="bi bi-hexagon"></i> 11. Créer les Modèles Eloquent</h2>
    <p>Un <strong>modèle</strong> est une classe PHP qui représente une table en base de données. Via Eloquent (l'ORM de Laravel), vous pouvez lire/écrire dans la base avec du PHP simple, sans écrire de SQL.</p>

    <h3>Créer un modèle</h3>
<div class="cmd-block"><span class="comment"># Modèle seul :</span>
<span class="prompt">$</span> php artisan make:model Category

<span class="comment"># Modèle + migration + factory + seeder en une commande :</span>
<span class="prompt">$</span> php artisan make:model Category -mfs

<span class="comment"># Options : -m migration, -f factory, -s seeder, -c controller, -r resource controller</span></div>

    <p>Le fichier est créé dans <code>app/Models/</code>. Voici la structure d'un modèle FeGArtisan :</p>

<div class="cmd-block">&lt;?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    <span class="comment">// Colonnes qu'on peut remplir en masse (obligatoire pour sécurité)</span>
    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active', 'image'];

    <span class="comment">// Relation : une catégorie a plusieurs profils artisans</span>
    public function artisanProfiles()
    {
        return $this->hasMany(ArtisanProfile::class);
    }
}</div>

    <h3>Les modèles de FeGArtisan</h3>
    <table class="doc-table">
        <tr><th>Modèle</th><th>Table</th><th>Relations principales</th></tr>
        <tr><td><code>User</code></td><td>users</td><td>hasOne ArtisanProfile, hasMany Messages</td></tr>
        <tr><td><code>ArtisanProfile</code></td><td>artisan_profiles</td><td>belongsTo User, belongsTo Category</td></tr>
        <tr><td><code>Category</code></td><td>categories</td><td>hasMany ArtisanProfiles</td></tr>
        <tr><td><code>Publication</code></td><td>publications</td><td>belongsTo ArtisanProfile, hasMany Likes, Comments</td></tr>
        <tr><td><code>Conversation</code></td><td>conversations</td><td>hasMany Messages, belongsTo User (client + artisan)</td></tr>
        <tr><td><code>Message</code></td><td>messages</td><td>belongsTo Conversation, belongsTo User (sender)</td></tr>
        <tr><td><code>Report</code></td><td>reports</td><td>belongsTo User (reporter + cible)</td></tr>
        <tr><td><code>Review</code></td><td>reviews</td><td>belongsTo User, belongsTo ArtisanProfile</td></tr>
    </table>

    <h3>Utiliser un modèle (exemples concrets)</h3>
<div class="cmd-block"><span class="comment"># Récupérer tous les artisans approuvés</span>
$artisans = User::where('role', 'artisan')
               ->whereHas('artisanProfile', fn($q) => $q->where('validation_status', 'approved'))
               ->get();

<span class="comment"># Créer un utilisateur</span>
$user = User::create([
    'first_name' =&gt; 'Jean',
    'email'      =&gt; 'jean@test.bj',
    'password'   =&gt; 'motdepasse',
    'role'       =&gt; 'client',
]);

<span class="comment"># Compter les artisans en attente</span>
$count = ArtisanProfile::where('validation_status', 'pending')-&gt;count();</div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="controllers">
    <h2><i class="bi bi-cpu"></i> 12. Créer les Controllers</h2>
    <p>Un <strong>controller</strong> reçoit les requêtes HTTP (clic sur un bouton, appel Flutter), appelle les modèles, et renvoie une réponse (page HTML ou JSON).</p>

    <h3>Créer un controller</h3>
<div class="cmd-block"><span class="comment"># Controller simple :</span>
<span class="prompt">$</span> php artisan make:controller Admin/DashboardController

<span class="comment"># Controller avec toutes les méthodes CRUD (index, create, store, show, edit, update, destroy) :</span>
<span class="prompt">$</span> php artisan make:controller Admin/CategoryController --resource

<span class="comment"># Controller API (mêmes méthodes, sans create/edit) :</span>
<span class="prompt">$</span> php artisan make:controller Api/ArtisanController --api</div>

    <p>Exemple : le controller admin qui affiche le dashboard :</p>
<div class="cmd-block">&lt;?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        <span class="comment">// On récupère les stats pour la vue</span>
        $stats = [
            'clients'  =&gt; User::where('role', 'client')-&gt;count(),
            'artisans' =&gt; User::where('role', 'artisan')-&gt;count(),
            'pending'  =&gt; \App\Models\ArtisanProfile::where('validation_status','pending')-&gt;count(),
        ];

        <span class="comment">// On passe ces stats à la vue Blade</span>
        return view('admin.dashboard', compact('stats'));
    }
}</div>

    <h3>Controllers API — retourner du JSON</h3>
    <p>Pour l'API (utilisée par Flutter), on retourne du JSON au lieu d'une vue :</p>
<div class="cmd-block">public function login(Request $request)
{
    <span class="comment">// Valider les champs reçus</span>
    $validated = $request-&gt;validate([
        'email'    =&gt; ['required', 'email'],
        'password' =&gt; ['required'],
    ]);

    if (!Auth::attempt($validated)) {
        return response()-&gt;json(['message' =&gt; 'Identifiants incorrects.'], 401);
    }

    $token = Auth::user()-&gt;createToken('auth-token')-&gt;plainTextToken;

    return response()-&gt;json([
        'message' =&gt; 'Connexion réussie.',
        'user'    =&gt; Auth::user(),
        'token'   =&gt; $token,
    ]);
}</div>

    <h3>Liste des controllers créés</h3>
    <table class="doc-table">
        <tr><th>Fichier</th><th>Rôle</th></tr>
        <tr><td><code>Admin/AuthController.php</code></td><td>Login/logout admin (session web)</td></tr>
        <tr><td><code>Admin/DashboardController.php</code></td><td>Page d'accueil admin</td></tr>
        <tr><td><code>Admin/UserController.php</code></td><td>Liste + dossier artisans, valider/refuser</td></tr>
        <tr><td><code>Admin/CategoryController.php</code></td><td>CRUD catégories + upload image</td></tr>
        <tr><td><code>Admin/PublicationController.php</code></td><td>Modération publications</td></tr>
        <tr><td><code>Admin/ReportController.php</code></td><td>Traitement signalements</td></tr>
        <tr><td><code>Admin/ProfileController.php</code></td><td>Profil de l'admin connecté</td></tr>
        <tr><td><code>Api/AuthController.php</code></td><td>Inscription, connexion, token FCM (API)</td></tr>
        <tr><td><code>Api/ArtisanController.php</code></td><td>Recherche artisans (API)</td></tr>
        <tr><td><code>Api/ConversationController.php</code></td><td>Messagerie (API)</td></tr>
    </table>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="routes-create">
    <h2><i class="bi bi-signpost-split"></i> 13. Déclarer les routes</h2>
    <p>Une <strong>route</strong> connecte une URL à un controller. Il y a deux fichiers de routes dans FeGArtisan :</p>

    <table class="doc-table">
        <tr><th>Fichier</th><th>Préfixe</th><th>Utilisé par</th></tr>
        <tr><td><code>routes/web.php</code></td><td><code>/admin/...</code></td><td>Dashboard admin (navigateur, session)</td></tr>
        <tr><td><code>routes/api.php</code></td><td><code>/api/...</code></td><td>API REST (Flutter, tokens Sanctum)</td></tr>
    </table>

    <h3>Exemple routes/web.php (admin)</h3>
<div class="cmd-block">&lt;?php
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

<span class="comment">// Page de connexion admin (publique)</span>
Route::get('/admin/login',  [Admin\AuthController::class, 'showLogin'])-&gt;name('admin.login');
Route::post('/admin/login', [Admin\AuthController::class, 'login']);

<span class="comment">// Routes protégées (l'admin doit être connecté)</span>
Route::prefix('admin')-&gt;middleware(['auth', 'admin'])-&gt;name('admin.')-&gt;group(function () {
    Route::get('/',           [Admin\DashboardController::class, 'index'])-&gt;name('dashboard');
    Route::get('/users',      [Admin\UserController::class, 'index'])-&gt;name('users.index');
    Route::get('/users/{id}', [Admin\UserController::class, 'show'])-&gt;name('users.show');
    Route::resource('categories', Admin\CategoryController::class);
});</div>

    <h3>Exemple routes/api.php (Flutter)</h3>
<div class="cmd-block">&lt;?php
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;

<span class="comment">// Publiques (sans token)</span>
Route::post('/login',            [Api\AuthController::class, 'login']);
Route::post('/register/client',  [Api\AuthController::class, 'registerClient']);
Route::get('/artisans',          [Api\ArtisanController::class, 'index']);

<span class="comment">// Protégées (token Sanctum requis dans le header Authorization)</span>
Route::middleware('auth:sanctum')-&gt;group(function () {
    Route::get('/me',       [Api\AuthController::class, 'me']);
    Route::post('/logout',  [Api\AuthController::class, 'logout']);
    Route::post('/me/fcm-token',    [Api\AuthController::class, 'saveFcmToken']);
    Route::delete('/me/fcm-token',  [Api\AuthController::class, 'deleteFcmToken']);
});</div>

    <h3>Vérifier que vos routes sont bien enregistrées</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan route:list
<span class="comment">→ affiche toutes les routes de l'application</span>

<span class="prompt">$</span> php artisan route:list --path=api
<span class="comment">→ seulement les routes API</span></div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="views">
    <h2><i class="bi bi-window"></i> 14. Créer les vues Blade</h2>
    <p>Blade est le moteur de templates de Laravel. Un fichier <code>.blade.php</code> est un fichier HTML avec du PHP simplifié dedans.</p>

    <h3>Syntaxe Blade de base</h3>
@verbatim
<div class="cmd-block"><span class="comment">{{-- Ceci est un commentaire Blade (n'apparaît pas dans le HTML) --}}</span>

<span class="comment">{{-- Afficher une variable (échappe le HTML pour sécurité) --}}</span>
{{ $user->first_name }}

<span class="comment">{{-- Condition --}}</span>
@if ($user->isAdmin())
    &lt;p&gt;Bonjour Admin&lt;/p&gt;
@else
    &lt;p&gt;Bonjour {{ $user->first_name }}&lt;/p&gt;
@endif

<span class="comment">{{-- Boucle --}}</span>
@foreach ($artisans as $artisan)
    &lt;div&gt;{{ $artisan->name }}&lt;/div&gt;
@endforeach

<span class="comment">{{-- Inclure une sous-vue --}}</span>
@include('admin.partials.sidebar')

<span class="comment">{{-- Lien vers une route nommée --}}</span>
&lt;a href="{{ route('admin.dashboard') }}"&gt;Dashboard&lt;/a&gt;

<span class="comment">{{-- URL d'un asset (image, CSS) dans public/ --}}</span>
&lt;img src="{{ asset('images/logo.jpeg') }}"&gt;

<span class="comment">{{-- URL d'un fichier uploadé dans storage/ --}}</span>
&lt;img src="{{ Storage::url($user->avatar) }}"&gt;</div>
@endverbatim

    <h3>Layout partagé (héritage de template)</h3>
    <p>Le dashboard admin a un layout commun (sidebar + navbar). Les pages <em>héritent</em> de ce layout :</p>

@verbatim
<div class="cmd-block"><span class="comment">{{-- resources/views/admin/layouts/app.blade.php --}}</span>
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;@yield('title', 'Admin') — FeGArtisan&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;!-- sidebar ici --&gt;
    &lt;main&gt;
        @yield('content')   {{-- ← les pages mettent leur contenu ici --}}
    &lt;/main&gt;
&lt;/body&gt;
&lt;/html&gt;

<span class="comment">{{-- resources/views/admin/dashboard.blade.php --}}</span>
@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    &lt;h1&gt;Bonjour, {{ $currentUser->first_name }}&lt;/h1&gt;
    &lt;p&gt;Il y a {{ $stats['pending'] }} dossiers en attente.&lt;/p&gt;
@endsection</div>
@endverbatim

    <h3>Formulaires avec protection CSRF</h3>
    <p>Tout formulaire POST/PUT/DELETE doit avoir <code>@csrf</code> pour la sécurité :</p>
@verbatim
<div class="cmd-block">&lt;form method="POST" action="{{ route('admin.categories.store') }}"&gt;
    @csrf
    &lt;input type="text" name="name" placeholder="Nom de la catégorie"&gt;
    &lt;button type="submit"&gt;Créer&lt;/button&gt;
&lt;/form&gt;

<span class="comment">{{-- Pour simuler PUT (HTML ne supporte pas PUT nativement) --}}</span>
&lt;form method="POST" action="{{ route('admin.categories.update', $cat->id) }}"&gt;
    @csrf
    @method('PUT')
    ...
&lt;/form&gt;</div>

    <h3>Afficher les erreurs de validation</h3>
<div class="cmd-block">@if ($errors->any())
    &lt;div class="alert alert-danger"&gt;
        @foreach ($errors->all() as $error)
            &lt;p&gt;{{ $error }}&lt;/p&gt;
        @endforeach
    &lt;/div&gt;
@endif</div>
@endverbatim
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="storage">
    <h2><i class="bi bi-folder"></i> 15. Storage &amp; fichiers uploadés</h2>
    <p>Laravel stocke les fichiers uploadés (avatars, documents, images) dans <code>storage/app/public/</code>. Pour que le navigateur y accède via l'URL <code>/storage/...</code>, il faut créer un lien symbolique une seule fois :</p>

<div class="cmd-block"><span class="prompt">$</span> php artisan storage:link
<span class="success">→ The [public/storage] link has been connected to [storage/app/public].</span></div>

    <h3>Uploader un fichier dans un controller</h3>
@verbatim
<div class="cmd-block"><span class="comment">// Dans un controller, $request->file('image') est le fichier envoyé par le formulaire</span>
if ($request->hasFile('image')) {
    $path = $request->file('image')->store('categories', 'public');
    <span class="comment">// $path = "categories/nom-du-fichier.jpg"</span>
    <span class="comment">// Le fichier est dans storage/app/public/categories/</span>
}

<span class="comment">// Dans la vue, pour afficher :</span>
&lt;img src="{{ Storage::url($category->image) }}"&gt;
<span class="comment">// → génère /storage/categories/nom-du-fichier.jpg</span></div>
@endverbatim

    <h3>Supprimer un fichier</h3>
<div class="cmd-block">use Illuminate\Support\Facades\Storage;

Storage::disk('public')->delete($category->image);</div>

    <h3>Dossiers créés automatiquement</h3>
    <table class="doc-table">
        <tr><th>Dossier</th><th>Contenu</th></tr>
        <tr><td><code>storage/app/public/avatars/</code></td><td>Photos de profil (admins, utilisateurs)</td></tr>
        <tr><td><code>storage/app/public/categories/</code></td><td>Images des catégories de métiers</td></tr>
        <tr><td><code>storage/app/public/proofs/</code></td><td>Justificatifs soumis par les artisans</td></tr>
        <tr><td><code>storage/firebase/</code></td><td>Clé privée Firebase (voir section suivante)</td></tr>
    </table>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="firebase">
    <h2><i class="bi bi-fire"></i> 16. Firebase Cloud Messaging (notifications push)</h2>
    <p>Firebase envoie des notifications push vers les téléphones quand l'appli Flutter est fermée (ex : "Jean vous a envoyé un message").</p>

    <div class="step-card">
        <div class="step-number">1</div>
        <h4>Créer un projet Firebase</h4>
        <ol>
            <li>Allez sur <strong>console.firebase.google.com</strong></li>
            <li>Créez un projet (nommez-le <em>fegartisan</em>)</li>
            <li>Dans les paramètres (⚙️) → <strong>Paramètres du projet</strong> → onglet <strong>Comptes de service</strong></li>
            <li>Cliquez <strong>Générer une nouvelle clé privée</strong> → téléchargez le fichier JSON</li>
            <li>Renommez-le <code>service-account.json</code></li>
        </ol>
    </div>

    <div class="step-card">
        <div class="step-number">2</div>
        <h4>Placer la clé dans le projet</h4>
<div class="cmd-block"><span class="comment"># Créez le dossier (Windows) :</span>
<span class="prompt">$</span> mkdir storage\firebase

<span class="comment"># Déplacez le fichier téléchargé dans :</span>
storage/firebase/service-account.json</div>
        <div class="doc-info danger">
            <i class="bi bi-shield-exclamation"></i>
            <div><strong>Ce fichier est une clé maîtresse.</strong> Ne le partagez jamais (ni sur Git, ni par email). Le <code>.gitignore</code> exclut déjà <code>/storage/firebase</code>. Ne changez pas ça.</div>
        </div>
    </div>

    <div class="step-card">
        <div class="step-number">3</div>
        <h4>Vérifier la configuration</h4>
<div class="cmd-block"><span class="prompt">$</span> php artisan fcm:check

▶ Diagnostic FCM FeGArtisan

1. Push activé          : <span class="success">oui</span>
2. Chemin credentials   : storage/firebase/service-account.json
3. Fichier présent      : <span class="success">oui</span>
4. JSON valide          : <span class="success">oui (project: fegartisan)</span>
5. Extension sodium     : <span class="success">chargée</span>
6. Connexion Firebase   : <span class="success">OK</span>

<span class="comment">→ Config OK. Pour tester un envoi : php artisan fcm:check &lt;user_id&gt;</span></div>
        <p>Si une ligne est rouge, le message d'erreur indique quoi corriger. Erreur la plus fréquente : sodium non activé dans php.ini (voir section 3).</p>
    </div>

    <div class="step-card">
        <div class="step-number">4</div>
        <h4>Tester un envoi réel vers un téléphone</h4>
<div class="cmd-block"><span class="comment"># L'utilisateur doit d'abord être connecté depuis Flutter</span>
<span class="comment"># et avoir envoyé son FCM token via POST /api/me/fcm-token</span>

<span class="prompt">$</span> php artisan fcm:check 1
<span class="comment"># → envoie une notification de test à l'utilisateur #1</span>
<span class="success">✓ Push envoyé avec succès.</span></div>
    </div>

    <h3>Comment ça marche concrètement</h3>
    <ol>
        <li>Flutter ouvre l'appli → appelle <code>POST /api/me/fcm-token</code> avec le token FCM du téléphone</li>
        <li>Laravel stocke ce token dans la colonne <code>users.fcm_token</code></li>
        <li>Quand un événement se passe (nouveau message), un Listener est déclenché</li>
        <li>Ce Listener appelle <code>FirebasePushService::sendToUser()</code> via la queue</li>
        <li>Le service contacte Firebase → Firebase pousse la notification vers le téléphone</li>
    </ol>

    <div class="doc-info warning">
        <i class="bi bi-info-circle"></i>
        <div>Les notifications passent par la <strong>queue</strong>. Le worker <code>php artisan queue:work</code> doit donc tourner en permanence pour que les notifications soient envoyées.</div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="reverb">
    <h2><i class="bi bi-broadcast"></i> 17. WebSockets temps réel (Reverb)</h2>
    <p>Reverb permet d'envoyer des données instantanément (sans que Flutter rafraîchisse) : messages de chat, notifications en temps réel.</p>

    <h3>Vérifier la config dans .env</h3>
<div class="cmd-block"><span class="k">BROADCAST_CONNECTION</span>=reverb
<span class="k">REVERB_HOST</span>="localhost"
<span class="k">REVERB_PORT</span>=8080</div>

    <h3>Lancer le serveur Reverb</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan reverb:start
<span class="comment">→ Starting server on 0.0.0.0:8080...</span></div>
    <p>Flutter écoute sur ce port pour recevoir les messages en temps réel. Laissez ce terminal ouvert pendant le développement.</p>

    <h3>Comment un événement est diffusé</h3>
<div class="cmd-block"><span class="comment"># Dans un controller, après avoir sauvegardé un message :</span>
$message = Message::create([...]);

<span class="comment"># On déclenche l'événement → Reverb le diffuse vers Flutter</span>
event(new NewMessageSent($message));</div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="run">
    <h2><i class="bi bi-play-circle"></i> 18. Démarrer les serveurs</h2>
    <p>En développement, vous avez besoin de <strong>3 terminaux ouverts en parallèle</strong>. Chaque terminal fait une chose différente :</p>

    <table class="doc-table">
        <tr><th>Terminal</th><th>Commande</th><th>Rôle</th><th>Port</th></tr>
        <tr><td><strong>1</strong></td><td><code>php artisan serve</code></td><td>Serveur HTTP Laravel (site + API)</td><td>8000</td></tr>
        <tr><td><strong>2</strong></td><td><code>php artisan reverb:start</code></td><td>Serveur WebSocket (messages temps réel)</td><td>8080</td></tr>
        <tr><td><strong>3</strong></td><td><code>php artisan queue:work</code></td><td>Traite les jobs en arrière-plan (push FCM, emails)</td><td>—</td></tr>
    </table>

<div class="cmd-block"><span class="comment"># Terminal 1 — le plus important, toujours ouvert</span>
<span class="prompt">$</span> php artisan serve
<span class="success">→ Server running on [http://127.0.0.1:8000]</span>

<span class="comment"># Terminal 2 — pour les messages temps réel</span>
<span class="prompt">$</span> php artisan reverb:start
<span class="success">→ Starting server on 0.0.0.0:8080...</span>

<span class="comment"># Terminal 3 — pour les notifications push FCM</span>
<span class="prompt">$</span> php artisan queue:work
<span class="success">→ Processing jobs from the [default] queue...</span></div>

    <div class="doc-info success">
        <i class="bi bi-lightbulb"></i>
        <div>Pour les tests simples, seul le Terminal 1 (<code>php artisan serve</code>) est obligatoire. Ouvrez les terminaux 2 et 3 seulement quand vous testez la messagerie ou les notifications push.</div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="admin">
    <h2><i class="bi bi-shield-lock"></i> 19. Accéder au dashboard admin</h2>
    <p>Le dashboard admin est une interface web qui tourne dans le navigateur. C'est là que l'admin gère les artisans, les signalements, les catégories, etc.</p>

    <h3>Se connecter</h3>
    <ol>
        <li>Lancez <code>php artisan serve</code></li>
        <li>Ouvrez <code>http://127.0.0.1:8000/admin/login</code></li>
        <li>Connectez-vous avec le compte admin créé par le seeder :<br>
            Email : <code>admin@fegartisan.com</code> &nbsp;·&nbsp; Mot de passe : <code>admin1234</code>
        </li>
    </ol>

    <div class="doc-info warning">
        <i class="bi bi-exclamation-triangle"></i>
        <div>Les comptes artisan et client ne peuvent pas se connecter au dashboard. L'admin ne peut pas non plus se connecter via l'API (c'est intentionnel pour la sécurité).</div>
    </div>

    <h3>Pages du dashboard</h3>
    <table class="doc-table">
        <tr><th>URL</th><th>Page</th></tr>
        <tr><td><code>/admin</code></td><td>Tableau de bord (stats, dossiers en attente, graphique)</td></tr>
        <tr><td><code>/admin/users?validation=pending</code></td><td>Dossiers artisans à valider</td></tr>
        <tr><td><code>/admin/users?role=artisan</code></td><td>Liste artisans validés</td></tr>
        <tr><td><code>/admin/users?role=client</code></td><td>Liste clients</td></tr>
        <tr><td><code>/admin/users/{id}</code></td><td>Dossier détaillé d'un utilisateur</td></tr>
        <tr><td><code>/admin/categories</code></td><td>Catégories (CRUD + upload image)</td></tr>
        <tr><td><code>/admin/publications</code></td><td>Modération du contenu</td></tr>
        <tr><td><code>/admin/reports</code></td><td>Signalements à traiter</td></tr>
        <tr><td><code>/admin/profile</code></td><td>Votre profil admin</td></tr>
        <tr><td><code>/documentation</code></td><td>Cette documentation</td></tr>
    </table>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="api-test">
    <h2><i class="bi bi-plug"></i> 20. Tester l'API</h2>
    <p>L'API est ce que l'appli Flutter appelle. Vous pouvez la tester sans Flutter en utilisant un client HTTP.</p>

    <h3>Option A — Thunder Client (recommandé, sans compte)</h3>
    <p>Thunder Client est une extension VS Code gratuite, sans inscription :</p>
    <ol>
        <li>Dans VS Code : Extensions (<span class="kbd">Ctrl+Shift+X</span>) → cherchez <strong>Thunder Client</strong> → Installer</li>
        <li>Un éclair ⚡ apparaît dans la barre latérale de VS Code</li>
        <li>Cliquez <strong>New Request</strong></li>
        <li>Sélectionnez la méthode (POST, GET…), entrez l'URL, ajoutez les paramètres</li>
        <li>Cliquez <strong>Send</strong></li>
    </ol>

    <h4>Exemple — Se connecter</h4>
<div class="cmd-block"><span class="comment">Méthode :</span> POST
<span class="comment">URL :</span>     http://127.0.0.1:8000/api/login
<span class="comment">Body (JSON) :</span>
{
  "email": "artisan@fegartisan.com",
  "password": "artisan1234"
}

<span class="comment">→ Réponse 200 :</span>
{
  "message": "Connexion réussie.",
  "token": "1|AbCdEfGh...",
  "user": { ... }
}</div>

    <h4>Exemple — Appel authentifié (avec token)</h4>
<div class="cmd-block"><span class="comment">Méthode :</span> GET
<span class="comment">URL :</span>     http://127.0.0.1:8000/api/me
<span class="comment">Headers :</span>
  Authorization: Bearer 1|AbCdEfGh...    <span class="comment">← le token reçu au login</span>
  Accept: application/json</div>

    <h3>Option B — Postman (nécessite un compte gratuit)</h3>
    <p>Si vous souhaitez utiliser Postman pour importer des collections de requêtes, vous devez vous connecter à un compte Postman (gratuit). Sans connexion, l'import de fichier <code>.json</code> est bloqué.</p>
    <ol>
        <li>Créez un compte sur <strong>postman.com</strong> (gratuit)</li>
        <li>Connectez-vous dans l'appli Postman</li>
        <li>Import → glissez les fichiers depuis <code>public/postman/</code></li>
        <li>Sélectionnez l'environnement <strong>FeGArtisan Local</strong> en haut à droite</li>
    </ol>

    <div class="doc-info warning">
        <i class="bi bi-exclamation-triangle"></i>
        <div>Postman sans connexion affiche "Sign up to unlock all import methods". C'est normal. Soit vous créez un compte gratuit, soit vous utilisez Thunder Client qui ne demande rien.</div>
    </div>

    <h3>Option C — cURL depuis le terminal</h3>
<div class="cmd-block"><span class="comment"># Login</span>
<span class="prompt">$</span> curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"artisan@fegartisan.com","password":"artisan1234"}'

<span class="comment"># Récupérer son profil (remplacez TON_TOKEN par le token reçu)</span>
<span class="prompt">$</span> curl http://127.0.0.1:8000/api/me \
  -H "Authorization: Bearer TON_TOKEN" \
  -H "Accept: application/json"</div>

    <h3>Tester depuis un émulateur Android</h3>
    <p>L'émulateur Android ne peut pas utiliser <code>127.0.0.1</code> (c'est son propre loopback). Utilisez l'IP spéciale :</p>
<div class="cmd-block"><span class="comment"># Dans Flutter, remplacez la base_url :</span>
const String baseUrl = 'http://10.0.2.2:8000/api';
<span class="comment"># 10.0.2.2 = l'IP de votre PC vue depuis l'émulateur Android</span></div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="admin-pages">
    <h2><i class="bi bi-columns"></i> 21. Référence — Pages admin</h2>

    <h3>Layout partagé</h3>
    <p><code>resources/views/admin/layouts/app.blade.php</code> — sidebar fixe (dégradé brun, liste des pages, badges alertes) + top navbar (date du jour + pill utilisateur cliquable).</p>

    <h3>Toutes les pages</h3>
    <table class="doc-table">
        <tr><th>Route nommée</th><th>Vue Blade</th><th>Description</th></tr>
        <tr><td><code>admin.dashboard</code></td><td><code>admin.dashboard</code></td><td>4 stats cards, donut répartition, tableau en attente, feed activité</td></tr>
        <tr><td><code>admin.users.index</code></td><td><code>admin.users.index</code></td><td>Mode <em>pending</em> / <em>artisans</em> / <em>clients</em> selon les paramètres GET</td></tr>
        <tr><td><code>admin.users.show</code></td><td><code>admin.users.show</code></td><td>Dossier complet (infos perso, justificatif PDF, boutons décision)</td></tr>
        <tr><td><code>admin.categories.index</code></td><td><code>admin.categories.index</code></td><td>Liste avec image, stats, modals création/édition + upload image</td></tr>
        <tr><td><code>admin.publications.index</code></td><td><code>admin.publications.index</code></td><td>Fil d'actualité avec filtres et suppression</td></tr>
        <tr><td><code>admin.reports.index</code></td><td><code>admin.reports.index</code></td><td>Signalements avec statuts et actions</td></tr>
        <tr><td><code>admin.profile</code></td><td><code>admin.profile.show</code></td><td>Modifier infos, changer photo, changer mot de passe</td></tr>
    </table>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="routes">
    <h2><i class="bi bi-signpost-2"></i> 22. Toutes les routes API</h2>
    <p>Base URL en local : <code>http://127.0.0.1:8000/api</code></p>

    <h3>Routes publiques (sans token)</h3>
    <table class="doc-table route-table">
        <tr><th>Méthode + Endpoint</th><th>Rôle</th></tr>
        <tr><td><span class="method post">POST</span> /register/client</td><td>Inscription client (étape unique)</td></tr>
        <tr><td><span class="method post">POST</span> /register/artisan</td><td>Inscription artisan — étape 1 (infos de base)</td></tr>
        <tr><td><span class="method post">POST</span> /login</td><td>Connexion → retourne un token</td></tr>
        <tr><td><span class="method post">POST</span> /forgot-password</td><td>Demande de reset mot de passe</td></tr>
        <tr><td><span class="method get">GET</span> /categories</td><td>Liste des catégories de métiers</td></tr>
        <tr><td><span class="method get">GET</span> /artisans</td><td>Recherche artisans (filtres : ville, catégorie)</td></tr>
        <tr><td><span class="method get">GET</span> /artisans/{id}</td><td>Fiche détaillée d'un artisan</td></tr>
        <tr><td><span class="method get">GET</span> /artisans/{id}/reviews</td><td>Avis laissés sur un artisan</td></tr>
        <tr><td><span class="method get">GET</span> /publications</td><td>Feed de publications</td></tr>
        <tr><td><span class="method get">GET</span> /publications/{id}</td><td>Détail d'une publication</td></tr>
    </table>

    <h3>Routes authentifiées (header <code>Authorization: Bearer &lt;token&gt;</code>)</h3>
    <table class="doc-table route-table">
        <tr><th>Méthode + Endpoint</th><th>Rôle</th></tr>
        <tr><td><span class="method get">GET</span> /me</td><td>Profil de l'utilisateur connecté</td></tr>
        <tr><td><span class="method post">POST</span> /me</td><td>Mettre à jour son profil (avatar, ville…)</td></tr>
        <tr><td><span class="method post">POST</span> /logout</td><td>Déconnexion (révoque le token courant)</td></tr>
        <tr><td><span class="method post">POST</span> /me/fcm-token</td><td>Enregistrer le token FCM du téléphone</td></tr>
        <tr><td><span class="method delete">DELETE</span> /me/fcm-token</td><td>Supprimer le token (au logout Flutter)</td></tr>
        <tr><td><span class="method post">POST</span> /register/artisan/verification</td><td>Artisan — étape 2 : upload du justificatif</td></tr>
        <tr><td><span class="method post">POST</span> /publications/{id}/like</td><td>Liker ou déliker une publication</td></tr>
        <tr><td><span class="method post">POST</span> /publications/{id}/comments</td><td>Commenter une publication</td></tr>
        <tr><td><span class="method post">POST</span> /favorites/{artisanId}</td><td>Ajouter/retirer un artisan des favoris</td></tr>
        <tr><td><span class="method get">GET</span> /favorites</td><td>Mes artisans favoris</td></tr>
        <tr><td><span class="method post">POST</span> /reports</td><td>Signaler un contenu ou profil</td></tr>
        <tr><td><span class="method get">GET</span> /conversations</td><td>Mes conversations</td></tr>
        <tr><td><span class="method post">POST</span> /conversations</td><td>Démarrer ou récupérer une conversation</td></tr>
        <tr><td><span class="method post">POST</span> /conversations/{id}/messages</td><td>Envoyer un message</td></tr>
    </table>

    <h3>Routes artisan seulement (role = artisan)</h3>
    <table class="doc-table route-table">
        <tr><th>Méthode + Endpoint</th><th>Rôle</th></tr>
        <tr><td><span class="method get">GET</span> /artisan/dashboard</td><td>Stats artisan (vues profil, likes, avis)</td></tr>
        <tr><td><span class="method get">GET</span> /artisan/publications</td><td>Mes publications</td></tr>
        <tr><td><span class="method post">POST</span> /artisan/publications</td><td>Créer une publication</td></tr>
        <tr><td><span class="method put">PUT</span> /artisan/publications/{id}</td><td>Modifier une publication</td></tr>
        <tr><td><span class="method delete">DELETE</span> /artisan/publications/{id}</td><td>Supprimer une publication</td></tr>
    </table>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="commands">
    <h2><i class="bi bi-terminal"></i> 23. Toutes les commandes Artisan utiles</h2>

    <h3>Création d'éléments</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan make:model NomModel -mfs   <span class="comment"># modèle + migration + factory + seeder</span>
<span class="prompt">$</span> php artisan make:controller NomController --resource  <span class="comment"># avec méthodes CRUD</span>
<span class="prompt">$</span> php artisan make:migration create_table_name --create=table_name
<span class="prompt">$</span> php artisan make:migration add_colonne_to_table --table=table_name
<span class="prompt">$</span> php artisan make:middleware NomMiddleware
<span class="prompt">$</span> php artisan make:event NomEvent
<span class="prompt">$</span> php artisan make:listener NomListener --event=NomEvent
<span class="prompt">$</span> php artisan make:seeder NomSeeder
<span class="prompt">$</span> php artisan make:command NomCommande</div>

    <h3>Base de données</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan migrate                     <span class="comment"># appliquer les nouvelles migrations</span>
<span class="prompt">$</span> php artisan migrate:fresh               <span class="comment"># ⚠ supprimer tout + recréer</span>
<span class="prompt">$</span> php artisan migrate:fresh --seed        <span class="comment"># ⚠ supprimer tout + recréer + données test</span>
<span class="prompt">$</span> php artisan migrate:rollback            <span class="comment"># annuler la dernière migration</span>
<span class="prompt">$</span> php artisan migrate:status             <span class="comment"># voir quelles migrations ont été exécutées</span>
<span class="prompt">$</span> php artisan db:seed                     <span class="comment"># remplir avec données de test</span></div>

    <h3>Serveurs</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan serve                       <span class="comment"># HTTP sur 8000</span>
<span class="prompt">$</span> php artisan serve --port=8001           <span class="comment"># autre port</span>
<span class="prompt">$</span> php artisan reverb:start                <span class="comment"># WebSocket sur 8080</span>
<span class="prompt">$</span> php artisan queue:work                  <span class="comment"># worker jobs (FCM, emails)</span>
<span class="prompt">$</span> php artisan queue:work --tries=3        <span class="comment"># avec retry automatique</span></div>

    <h3>Cache &amp; configuration</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan config:clear     <span class="comment"># vider le cache de .env (faire après chaque modif .env)</span>
<span class="prompt">$</span> php artisan route:clear      <span class="comment"># vider le cache des routes</span>
<span class="prompt">$</span> php artisan view:clear       <span class="comment"># vider les vues compilées</span>
<span class="prompt">$</span> php artisan optimize:clear   <span class="comment"># tout vider en une commande</span>
<span class="prompt">$</span> php artisan storage:link     <span class="comment"># créer le lien public/storage</span></div>

    <h3>Inspection et debug</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan route:list          <span class="comment"># lister toutes les routes</span>
<span class="prompt">$</span> php artisan route:list --path=api <span class="comment"># seulement les routes API</span>
<span class="prompt">$</span> php artisan about               <span class="comment"># infos sur l'app (versions, config, driver)</span>
<span class="prompt">$</span> php artisan tinker              <span class="comment"># console interactive pour tester les modèles</span></div>

    <h4>Exemples Tinker (tester les modèles sans passer par le navigateur)</h4>
<div class="cmd-block"><span class="prompt">$</span> php artisan tinker
<span class="prompt">&gt;</span> App\Models\User::count()
<span class="success">= 4</span>
<span class="prompt">&gt;</span> App\Models\User::where('role','artisan')-&gt;first()-&gt;first_name
<span class="success">= "Pierre"</span>
<span class="prompt">&gt;</span> App\Models\ArtisanProfile::where('validation_status','pending')-&gt;count()
<span class="success">= 1</span>
<span class="prompt">&gt;</span> exit</div>

    <h3>Commandes spécifiques FeGArtisan</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan fcm:check            <span class="comment"># diagnostiquer la config Firebase</span>
<span class="prompt">$</span> php artisan fcm:check 1          <span class="comment"># envoyer un push test à l'user #1</span></div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="accounts">
    <h2><i class="bi bi-people"></i> 24. Comptes de test (après <code>php artisan db:seed</code>)</h2>

    <table class="doc-table">
        <tr><th>Email</th><th>Mot de passe</th><th>Rôle</th><th>Utilité</th></tr>
        <tr><td><code>admin@fegartisan.com</code></td><td><code>admin1234</code></td><td>Admin</td><td>Accès au dashboard web <code>/admin</code></td></tr>
        <tr><td><code>artisan@fegartisan.com</code></td><td><code>artisan1234</code></td><td>Artisan validé</td><td>Tester l'API côté artisan (Thunder Client)</td></tr>
        <tr><td><code>client@fegartisan.com</code></td><td><code>client1234</code></td><td>Client</td><td>Tester l'API côté client</td></tr>
        <tr><td><code>marie@fegartisan.com</code></td><td><code>marie1234</code></td><td>Artisan en attente</td><td>Tester la modération admin (valider/refuser)</td></tr>
    </table>

    <div class="doc-info warning">
        <i class="bi bi-key"></i>
        <div>Changez ces mots de passe si vous exposez le projet en ligne. Ces comptes ne servent qu'en développement local.</div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="troubleshoot">
    <h2><i class="bi bi-life-preserver"></i> 25. Dépannage</h2>

    <h3>« SQLSTATE[HY000] [2002] Connection refused »</h3>
    <p>Laravel ne peut pas se connecter à la base. Vérifiez :</p>
    <ul>
        <li>Que les variables <code>DB_HOST</code>, <code>DB_USERNAME</code>, <code>DB_PASSWORD</code> dans <code>.env</code> sont correctes</li>
        <li>Que le fichier <code>ssl/ca.pem</code> existe à la racine du projet</li>
        <li>Que vous avez bien une connexion Internet (TiDB est dans le cloud)</li>
    </ul>
<div class="cmd-block"><span class="prompt">$</span> php artisan config:clear
<span class="prompt">$</span> php artisan migrate</div>

    <h3>« laravel: command not found » après <code>composer global require laravel/installer</code></h3>
    <p>Le dossier global de Composer n'est pas dans votre PATH. Sur Windows :</p>
<div class="cmd-block"><span class="comment"># Ajoutez ce dossier au PATH :</span>
C:\Users\VOTRE_NOM\AppData\Roaming\Composer\vendor\bin

<span class="comment"># Vérifiez où Composer est installé :</span>
<span class="prompt">$</span> composer global config bin-dir --absolute</div>

    <h3>« Class 'Sodium' not found » / erreurs JWT Firebase</h3>
    <p>L'extension sodium n'est pas activée. Ouvrez <code>C:\xampp\php\php.ini</code>, décommentez <code>;extension=sodium</code> (enlevez le <code>;</code>), sauvegardez et redémarrez le terminal.</p>
<div class="cmd-block"><span class="prompt">$</span> php -m | findstr sodium   <span class="comment"># doit afficher "sodium"</span></div>

    <h3>« Would you like to run the default database migrations? » — j'ai dit Yes par erreur</h3>
    <p>Laravel a essayé de migrer avec SQLite (la base locale par défaut). Changez <code>.env</code> pour pointer vers TiDB, puis :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan config:clear
<span class="prompt">$</span> php artisan migrate:fresh</div>

    <h3>Les images uploadées ne s'affichent pas</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan storage:link
<span class="comment">→ crée le lien public/storage → storage/app/public</span></div>

    <h3>« View [admin.dashboard] not found »</h3>
    <p>Le fichier de vue n'existe pas au bon endroit. Vérifiez que <code>resources/views/admin/dashboard.blade.php</code> existe bien. Si c'est un cache :</p>
<div class="cmd-block"><span class="prompt">$</span> php artisan view:clear
<span class="prompt">$</span> php artisan optimize:clear</div>

    <h3>Les notifications FCM ne sont pas envoyées</h3>
    <ol>
        <li>Vérifiez que <code>php artisan queue:work</code> tourne (les listeners sont <code>ShouldQueue</code>)</li>
        <li>Lancez <code>php artisan fcm:check</code> — toutes les lignes doivent être vertes</li>
        <li>Regardez les erreurs dans <code>storage/logs/laravel.log</code></li>
        <li>Vérifiez que l'utilisateur a bien un <code>fcm_token</code> en base (Flutter doit l'enregistrer)</li>
    </ol>

    <h3>Postman ne laisse pas importer sans compte</h3>
    <p>C'est un changement récent de Postman. Deux solutions :</p>
    <ul>
        <li>Créez un compte Postman gratuit sur postman.com</li>
        <li>Utilisez <strong>Thunder Client</strong> dans VS Code (aucun compte requis, même fonctionnalités)</li>
    </ul>

    <h3>Commande globale de nettoyage si quelque chose ne va pas</h3>
<div class="cmd-block"><span class="prompt">$</span> php artisan optimize:clear   <span class="comment"># vide tout les caches</span>
<span class="prompt">$</span> php artisan config:clear
<span class="prompt">$</span> php artisan route:clear
<span class="prompt">$</span> php artisan view:clear
<span class="prompt">$</span> composer dump-autoload       <span class="comment"># recharger les classes PHP</span></div>
</div>

{{-- ══════════════════════════════════════════════════════════════════════════ --}}
<div class="doc-section" id="deploy">
    <h2><i class="bi bi-rocket"></i> 26. Déploiement en production</h2>
    <p>Pour mettre le projet en ligne sur un serveur (VPS, Hostinger, Infomaniak…) :</p>

    <ol>
        <li>Envoyer les fichiers (git pull ou FTP)</li>
        <li>Installer les dépendances sans les packages de dev :
<div class="cmd-block"><span class="prompt">$</span> composer install <span class="k">--no-dev</span> <span class="k">--optimize-autoloader</span></div>
        </li>
        <li>Créer <code>.env</code> sur le serveur avec <code>APP_ENV=production</code>, <code>APP_DEBUG=false</code></li>
        <li>Générer la clé :
<div class="cmd-block"><span class="prompt">$</span> php artisan key:generate</div>
        </li>
        <li>Migrations, storage, caches :
<div class="cmd-block"><span class="prompt">$</span> php artisan migrate <span class="k">--force</span>
<span class="prompt">$</span> php artisan storage:link
<span class="prompt">$</span> php artisan config:cache
<span class="prompt">$</span> php artisan route:cache
<span class="prompt">$</span> php artisan view:cache</div>
        </li>
        <li>Configurer le worker queue en service (Supervisor) pour qu'il reste actif</li>
        <li>Pointer le DocumentRoot du serveur web sur le dossier <code>public/</code></li>
        <li>Copier le fichier <code>storage/firebase/service-account.json</code> manuellement (jamais via Git)</li>
    </ol>

    <div class="doc-info success">
        <i class="bi bi-check-circle"></i>
        <div><code>php artisan about</code> affiche l'état de tous les composants (config cachée, routes cachées, driver queue, driver broadcast…). Utile pour vérifier que tout est bien configuré avant de livrer.</div>
    </div>
</div>

</div>

<div class="back-link">
    <a href="/"><i class="bi bi-arrow-left"></i> Retour au site</a>
</div>

<script>
    const sections = document.querySelectorAll('.doc-section[id]');
    const navLinks = document.querySelectorAll('.doc-nav a[href^="#"]');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            if (window.scrollY >= section.offsetTop - 100) current = section.id;
        });
        navLinks.forEach(link => {
            link.classList.toggle('active', link.getAttribute('href') === '#' + current);
        });
    });
</script>
</body>
</html>
