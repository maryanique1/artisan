<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réinitialisation du mot de passe — FeGArtisan</title>
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
                Plateforme artisanale
              </div>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="background:#fff;padding:48px 48px 40px;border-left:1px solid #E8D5C0;border-right:1px solid #E8D5C0">

              <!-- Badge -->
              <div style="text-align:center;margin-bottom:32px">
                <div style="display:inline-block;background:#FDF3DD;border:2px solid #F1CC7A;border-radius:50%;width:72px;height:72px;line-height:72px;font-size:2rem;text-align:center">
                  🔐
                </div>
              </div>

              <h1 style="font-size:1.4rem;font-weight:800;color:#6B2D0E;margin:0 0 16px;text-align:center">
                Réinitialisation du mot de passe
              </h1>

              <p style="color:#4A3424;font-size:.95rem;line-height:1.7;margin:0 0 28px;text-align:center">
                Bonjour {{ $user->first_name ?? $user->name }},<br>
                vous avez demandé à réinitialiser votre mot de passe.<br>
                Cliquez sur le bouton ci-dessous pour en choisir un nouveau.
              </p>

              <!-- CTA -->
              <div style="text-align:center;margin:0 0 32px">
                <a href="{{ $url }}"
                   style="display:inline-block;background:linear-gradient(135deg,#6B2D0E,#8B3D1A);color:#fff;text-decoration:none;font-weight:700;font-size:.95rem;padding:14px 36px;border-radius:12px;letter-spacing:.01em">
                  Réinitialiser mon mot de passe
                </a>
              </div>

              <!-- Info box -->
              <div style="background:#FDF6EE;border:1px solid #F1E1CD;border-radius:12px;padding:20px 24px;margin-bottom:28px">
                <p style="margin:0;color:#9A7A64;font-size:.85rem;line-height:1.7">
                  <strong style="color:#6B2D0E">⏱ Ce lien expire dans 60 minutes.</strong><br>
                  Si vous n'avez pas demandé de réinitialisation, ignorez cet email — votre mot de passe restera inchangé.
                </p>
              </div>

              <p style="color:#9A7A64;font-size:.82rem;line-height:1.6;margin:0;text-align:center">
                Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :<br>
                <span style="color:#C17B4E;word-break:break-all">{{ $url }}</span>
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="background:#F5EDE0;border:1px solid #E8D5C0;border-top:none;border-radius:0 0 16px 16px;padding:24px 48px;text-align:center">
              <p style="margin:0;color:#9A7A64;font-size:.78rem;line-height:1.6">
                © {{ date('Y') }} FeGArtisan · Tous droits réservés<br>
                Vous recevez cet email suite à une demande de réinitialisation de mot de passe.
              </p>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>

</body>
</html>
