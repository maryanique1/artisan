<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invitation administrateur — FeGArtisan</title>
</head>
<body style="margin:0;padding:0;background:#FAF3E8;font-family:'Segoe UI',Arial,sans-serif;color:#4A3424">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#FAF3E8;padding:40px 20px">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

          <!-- Header -->
          <tr>
            <td style="background:linear-gradient(135deg,#2C1006 0%,#6B2D0E 55%,#7A3415 100%);border-radius:16px 16px 0 0;padding:40px 48px;text-align:center">
              <div style="font-size:2rem;font-weight:900;color:#fff;letter-spacing:-.01em;font-family:Georgia,serif">
                Feg<span style="color:#E8B088">Artisan</span>
              </div>
              <div style="color:rgba(255,255,255,.5);font-size:.75rem;letter-spacing:.25em;text-transform:uppercase;margin-top:6px">
                Administration
              </div>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="background:#fff;padding:48px 48px 40px;border-left:1px solid #E8D5C0;border-right:1px solid #E8D5C0">

              <!-- Badge -->
              <div style="text-align:center;margin-bottom:32px">
                <div style="display:inline-block;background:#FDF3DD;border:2px solid #F1CC7A;border-radius:50%;width:72px;height:72px;line-height:72px;font-size:2rem;text-align:center">
                  🛡️
                </div>
              </div>

              <h1 style="font-size:1.4rem;font-weight:800;color:#6B2D0E;margin:0 0 16px;text-align:center">
                Vous êtes invité à rejoindre l'équipe admin
              </h1>

              <p style="color:#4A3424;font-size:.95rem;line-height:1.7;margin:0 0 28px;text-align:center">
                Bonjour {{ $admin->first_name ?? $admin->name }},<br>
                un administrateur FeGArtisan vous a invité à accéder<br>
                au tableau de bord d'administration.
              </p>

              <!-- Credentials box -->
              <div style="background:#FDF6EE;border:1px solid #F1E1CD;border-radius:12px;padding:24px 28px;margin-bottom:28px">
                <p style="margin:0 0 6px;font-size:.8rem;font-weight:700;color:#9A7A64;text-transform:uppercase;letter-spacing:.1em">Vos identifiants de connexion</p>
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="padding:8px 0;border-bottom:1px solid #EEE0CC">
                      <span style="font-size:.85rem;color:#9A7A64">Email</span>
                    </td>
                    <td style="padding:8px 0;border-bottom:1px solid #EEE0CC;text-align:right">
                      <strong style="color:#4A3424;font-size:.9rem">{{ $admin->email }}</strong>
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:8px 0">
                      <span style="font-size:.85rem;color:#9A7A64">Mot de passe temporaire</span>
                    </td>
                    <td style="padding:8px 0;text-align:right">
                      <strong style="color:#6B2D0E;font-size:1.1rem;letter-spacing:.05em;font-family:monospace">{{ $plainPassword }}</strong>
                    </td>
                  </tr>
                </table>
              </div>

              <!-- CTA -->
              <div style="text-align:center;margin:0 0 28px">
                <a href="{{ $loginUrl }}"
                   style="display:inline-block;background:linear-gradient(135deg,#6B2D0E,#8B3D1A);color:#fff;text-decoration:none;font-weight:700;font-size:.95rem;padding:14px 36px;border-radius:12px;letter-spacing:.01em">
                  Accéder au tableau de bord
                </a>
              </div>

              <!-- Warning -->
              <div style="background:#FFF8F0;border:1px solid #F1E1CD;border-radius:12px;padding:16px 20px;margin-bottom:16px">
                <p style="margin:0;color:#9A7A64;font-size:.82rem;line-height:1.7">
                  <strong style="color:#6B2D0E">⚠️ Changez votre mot de passe</strong> dès votre première connexion via votre profil.
                </p>
              </div>

              <p style="color:#9A7A64;font-size:.82rem;line-height:1.6;margin:0;text-align:center">
                Si vous n'attendiez pas cette invitation, ignorez cet email.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background:#F5EDE0;border:1px solid #E8D5C0;border-top:none;border-radius:0 0 16px 16px;padding:24px 48px;text-align:center">
              <p style="margin:0;color:#9A7A64;font-size:.78rem;line-height:1.6">
                © {{ date('Y') }} FeGArtisan · Tous droits réservés<br>
                Tableau de bord d'administration
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
