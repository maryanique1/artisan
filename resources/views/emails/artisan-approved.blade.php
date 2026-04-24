<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compte artisan validé — FeGArtisan</title>
</head>

<body style="margin:0;padding:0;background:#FAF3E8;font-family:'Segoe UI',Arial,sans-serif;color:#4A3424">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#FAF3E8;padding:40px 20px">
    <tr>
      <td align="center">

        <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

          <!-- Header -->
          <tr>
            <td
              style="background:linear-gradient(135deg,#2C1006 0%,#6B2D0E 55%,#7A3415 100%);border-radius:16px 16px 0 0;padding:40px 48px;text-align:center">
              <div style="font-size:2rem;font-weight:900;color:#fff;letter-spacing:-.01em;font-family:Georgia,serif">
                Feg<span style="color:#E8B088">Artisan</span>
              </div>
              <div
                style="color:rgba(255,255,255,.5);font-size:.75rem;letter-spacing:.25em;text-transform:uppercase;margin-top:6px">
                Plateforme artisanale</div>
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td
              style="background:#fff;padding:48px 48px 40px;border-left:1px solid #E8D5C0;border-right:1px solid #E8D5C0">

              <!-- Badge -->
              <div style="text-align:center;margin-bottom:32px">
                <div
                  style="display:inline-block;background:#f0faf4;border:2px solid #a3d9b5;border-radius:50%;width:72px;height:72px;line-height:72px;font-size:2rem;text-align:center">
                  ✅</div>
              </div>

              <h1 style="font-size:1.5rem;font-weight:800;color:#6B2D0E;margin:0 0 16px;text-align:center">
                Félicitations, {{ $user->first_name }} !
              </h1>
              <p style="color:#4A3424;font-size:.95rem;line-height:1.7;margin:0 0 20px;text-align:center">
                Votre dossier artisan a été <strong style="color:#2d6a4f">examiné et approuvé</strong> par notre
                équipe.<br>
                Vous faites maintenant partie de la communauté FeGArtisan.
              </p>

              <!-- Info box -->
              <div
                style="background:#FDF6EE;border:1px solid #F1E1CD;border-radius:12px;padding:24px 28px;margin:28px 0">
                <p style="margin:0 0 14px;font-weight:700;color:#6B2D0E;font-size:.9rem">Ce que vous pouvez faire
                  maintenant :</p>
                <table cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                    <td style="padding:6px 0;color:#4A3424;font-size:.88rem">
                      <span style="color:#C17B4E;font-weight:700;margin-right:8px">→</span> Publier vos réalisations et
                      services
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:6px 0;color:#4A3424;font-size:.88rem">
                      <span style="color:#C17B4E;font-weight:700;margin-right:8px">→</span> Recevoir des demandes de
                      clients
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:6px 0;color:#4A3424;font-size:.88rem">
                      <span style="color:#C17B4E;font-weight:700;margin-right:8px">→</span> Communiquer via la
                      messagerie intégrée
                    </td>
                  </tr>
                  <tr>
                    <td style="padding:6px 0;color:#4A3424;font-size:.88rem">
                      <span style="color:#C17B4E;font-weight:700;margin-right:8px">→</span> Gérer votre profil et votre
                      disponibilité
                    </td>
                  </tr>
                </table>
              </div>

              <p style="color:#9A7A64;font-size:.87rem;line-height:1.6;margin:0">
                Si vous avez des questions, n'hésitez pas à nous contacter. Nous sommes là pour vous accompagner dans
                votre développement sur la plateforme.
              </p>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td
              style="background:#F5EDE0;border:1px solid #E8D5C0;border-top:none;border-radius:0 0 16px 16px;padding:24px 48px;text-align:center">
              <p style="margin:0;color:#9A7A64;font-size:.78rem;line-height:1.6">
                © {{ date('Y') }} FeGArtisan · Tous droits réservés<br>
                Vous recevez cet email car vous avez créé un compte artisan sur notre plateforme.
              </p>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>

</html>