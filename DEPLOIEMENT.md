# Guide de déploiement — Laravel sur Hostinger avec GitHub Actions

Ce guide détaille chaque étape pour déployer un projet Laravel sur Hostinger en utilisant GitHub Actions pour l'automatisation.

---

## Prérequis

- Un projet Laravel sur GitHub (repo public ou privé)
- Un compte Hostinger avec hébergement partagé
- SSH activé sur Hostinger (hPanel → Avancé → Accès SSH)
- Git installé sur Hostinger (disponible par défaut)

---

## Étape 1 — Cloner le projet sur le serveur

### 1.1 Se connecter en SSH

Hostinger utilise le port **65002** (pas le port 22 standard).

```bash
ssh -p 65002 u[USERNAME]@[IP_SERVEUR]
```

Les infos de connexion se trouvent dans hPanel → Avancé → Accès SSH.

### 1.2 Cloner le dépôt

```bash
git clone https://github.com/[USER]/[REPO].git [NOM_DOSSIER]
```

Exemple :
```bash
git clone https://github.com/maryanique1/artisan.git fegartisan
```

Le dossier sera créé dans `/home/[USERNAME]/[NOM_DOSSIER]`.

---

## Étape 2 — Configurer le projet

### 2.1 Installer les dépendances

```bash
cd [NOM_DOSSIER]
composer install --no-dev --optimize-autoloader --no-interaction
```

### 2.2 Créer le fichier .env et générer la clé

```bash
cp .env.example .env && php artisan key:generate
```

### 2.3 Configurer le .env

La méthode la plus fiable : créer le `.env` de production sur ton PC, puis l'envoyer via SCP.

Sur ton PC, crée un fichier `.env.production` avec les valeurs de production :

```env
APP_NAME=MonApp
APP_ENV=production
APP_KEY=base64:[CLÉ_GÉNÉRÉE]
APP_DEBUG=false
APP_URL=https://[DOMAINE]

DB_CONNECTION=mysql
DB_HOST=[HOST_DB]
DB_PORT=[PORT_DB]
DB_DATABASE=[NOM_DB]
DB_USERNAME=[USER_DB]
DB_PASSWORD=[PASS_DB]

# ... autres variables
```

Envoyer le fichier depuis ton PC :

```bash
scp -P 65002 .env.production [USERNAME]@[IP]:/home/[USERNAME]/[NOM_DOSSIER]/.env
```

### 2.4 Lancer les migrations

```bash
php artisan migrate --force
```

### 2.5 Créer le lien de stockage

> `php artisan storage:link` ne fonctionne pas sur l'hébergement partagé Hostinger car `exec()` est désactivé. Utiliser la commande manuelle :

```bash
ln -s /home/[USERNAME]/[NOM_DOSSIER]/storage/app/public /home/[USERNAME]/[NOM_DOSSIER]/public/storage
```

### 2.6 Configurer les permissions

```bash
chmod -R 775 storage bootstrap/cache
```

### 2.7 Mettre en cache les configurations

```bash
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## Étape 3 — Configurer le document root

Par défaut, Hostinger sert le dossier `public_html`. Or, Laravel doit servir son sous-dossier `public/`.

### Solution : remplacer public_html par un lien symbolique

```bash
# Vérifier le chemin du domaine
ls ~/domains/

# Supprimer le public_html existant et le remplacer par un lien vers Laravel/public
rm -rf ~/domains/[DOMAINE]/public_html
ln -s /home/[USERNAME]/[NOM_DOSSIER]/public /home/[USERNAME]/domains/[DOMAINE]/public_html
```

Vérifier que le lien est bien créé :

```bash
ls -la ~/domains/[DOMAINE]/
# Doit afficher : public_html -> /home/[USERNAME]/[NOM_DOSSIER]/public
```

---

## Étape 4 — Configurer GitHub Actions

### 4.1 Générer une clé SSH sur ton PC

```bash
ssh-keygen -t ed25519 -C "github-actions" -f ~/.ssh/id_ed25519 -N ""
```

### 4.2 Ajouter la clé publique au serveur

Afficher la clé publique :
```bash
cat ~/.ssh/id_ed25519.pub
```

Sur le serveur (via SSH) :
```bash
mkdir -p ~/.ssh && echo "[CLÉ_PUBLIQUE]" >> ~/.ssh/authorized_keys && chmod 700 ~/.ssh && chmod 600 ~/.ssh/authorized_keys
```

Tester la connexion sans mot de passe :
```bash
ssh -p 65002 -i ~/.ssh/id_ed25519 [USERNAME]@[IP]
```

### 4.3 Ajouter les secrets GitHub

Dans GitHub → Settings → Secrets and variables → Actions → **New repository secret** :

| Nom | Valeur |
|-----|--------|
| `SSH_HOST` | IP du serveur (ex: `72.60.93.176`) |
| `SSH_USER` | Nom d'utilisateur (ex: `u942487893`) |
| `SSH_PASSWORD` | Mot de passe Hostinger |
| `SSH_PORT` | `65002` |
| `DEPLOY_PATH` | `/home/[USERNAME]/[NOM_DOSSIER]` |

> **Note :** On utilise l'authentification par mot de passe dans le workflow (plus simple que la clé sur Hostinger partagé).

### 4.4 Créer le fichier workflow

Créer `.github/workflows/deploy.yml` à la racine du projet :

```yaml
name: Deploy to Hostinger

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
      - name: Deploy via SSH
        uses: appleboy/ssh-action@v1.0.3
        with:
          host: ${{ secrets.SSH_HOST }}
          username: ${{ secrets.SSH_USER }}
          password: ${{ secrets.SSH_PASSWORD }}
          port: ${{ secrets.SSH_PORT }}
          script: |
            set -e

            cd ${{ secrets.DEPLOY_PATH }}

            git pull origin main

            composer install --no-dev --optimize-autoloader --no-interaction

            php artisan migrate --force
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            [ -L public/storage ] || ln -s /home/[USERNAME]/[NOM_DOSSIER]/storage/app/public public/storage

            echo "Deployment successful!"
```

> Remplacer `[USERNAME]` et `[NOM_DOSSIER]` dans la ligne `ln -s`.

Committer et pousser :
```bash
git add .github/workflows/deploy.yml
git commit -m "ci: add Hostinger deployment workflow"
git push origin main
```

---

## Étape 5 — Fichiers sensibles hors git

Certains fichiers ne doivent pas être dans git mais sont nécessaires en production. Les envoyer manuellement via SCP après le premier déploiement.

### Certificat SSL TiDB (`ssl/ca.pem`)
Si présent dans git, rien à faire. Sinon :
```bash
scp -P 65002 ssl/ca.pem [USERNAME]@[IP]:/home/[USERNAME]/[NOM_DOSSIER]/ssl/ca.pem
```

### Credentials Firebase (`storage/firebase/service-account.json`)
```bash
# Créer le dossier d'abord (via SSH)
mkdir -p /home/[USERNAME]/[NOM_DOSSIER]/storage/firebase

# Puis depuis Windows
scp -P 65002 storage/firebase/service-account.json [USERNAME]@[IP]:/home/[USERNAME]/[NOM_DOSSIER]/storage/firebase/service-account.json
```

---

## Étape 6 — Vérifier le déploiement

1. Aller sur **GitHub → Actions** pour voir le workflow s'exécuter
2. Un cercle vert = succès. Une croix rouge = erreur (cliquer pour voir les logs)
3. Ouvrir le site dans le navigateur

---

## Fonctionnement continu

À partir de maintenant, chaque `git push origin main` déclenche automatiquement le déploiement :

```
git add .
git commit -m "feat: ma nouvelle fonctionnalité"
git push origin main
# → GitHub Actions déploie en ~30 secondes
```

---

## Connexion Flutter / app mobile

Une fois le backend déployé, mettre à jour l'URL de base dans Flutter :

```dart
// Avant (développement local)
static const String baseUrl = 'http://localhost:8000/api';

// Après (production)
static const String baseUrl = 'https://[DOMAINE]/api';
```

> Si Flutter affiche une erreur "Impossible de charger les données" alors que l'endpoint fonctionne dans le navigateur, c'est presque toujours l'URL qui n'a pas été mise à jour.

---

## Limitations de l'hébergement partagé

| Fonctionnalité | Hébergement partagé | VPS |
|---|---|---|
| API REST | ✅ | ✅ |
| Push notifications FCM | ✅ | ✅ |
| WebSockets (Reverb) | ❌ | ✅ |
| Queue worker | ❌ | ✅ |
| `php artisan storage:link` | ❌ (utiliser `ln -s`) | ✅ |

**Alternative WebSockets sur partagé :** utiliser [Pusher](https://pusher.com) (gratuit jusqu'à 200k messages/jour) à la place de Reverb.

---

## Dépannage fréquent

### Le site affiche une erreur 500
```bash
# Sur le serveur, vider tous les caches
php artisan cache:clear && php artisan config:clear && php artisan route:clear && php artisan view:clear
# Vérifier les logs
tail -50 storage/logs/laravel.log
```

### `storage:link` échoue
Hostinger désactive `exec()`. Utiliser la commande manuelle :
```bash
ln -s /home/[USERNAME]/[NOM_DOSSIER]/storage/app/public /home/[USERNAME]/[NOM_DOSSIER]/public/storage
```

### La connexion SSH timeout
Hostinger utilise le port **65002**, pas le port 22.

### GitHub Actions échoue : `can't connect without key or password`
Vérifier que le secret `SSH_PASSWORD` ou `SSH_KEY` est bien renseigné dans GitHub Secrets.

### Le site montre l'ancienne version
Vider le cache navigateur avec **Ctrl+Shift+R** ou tester dans un autre navigateur.

### `composer: No composer.json`
Le `DEPLOY_PATH` pointe vers le mauvais dossier. Il doit pointer vers la racine Laravel (là où se trouve `composer.json`), pas vers `public/`.

---

## Structure des dossiers sur le serveur

```
/home/[USERNAME]/
├── domains/
│   └── [DOMAINE]/
│       └── public_html -> /home/[USERNAME]/[NOM_DOSSIER]/public  (lien symbolique)
└── [NOM_DOSSIER]/          ← racine du projet Laravel
    ├── app/
    ├── public/             ← servi par le web via le lien symbolique
    ├── storage/
    ├── .env                ← créé manuellement (jamais dans git)
    └── ...
```
