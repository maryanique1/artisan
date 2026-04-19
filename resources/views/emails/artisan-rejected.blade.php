<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Décision sur votre dossier — FeGArtisan</title>
</head>
<body style="margin:0;padding:0;background:#FAF3E8;font-family:'Segoe UI',Arial,sans-serif;color:#4A3424">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#FAF3E8;padding:40px 20px">
<tr><td align="center">

  <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

    <!-- Header -->
    <tr>
      <td style="background:linear-gradient(135deg,#2C1006 0%,#6B2D0E 55%,#7A3415 100%);border-radius:16px 16px 0 0;padding:40px 48px;text-align:center">
        <div style="font-size:2rem;font-weight:900;color:#fff;letter-spacing:-.01em;font-family:Georgia,serif">
          Feg<span style="color:#E8B088">Artisan</span>
        </div>
        <div style="color:rgba(255,255,255,.5);font-size:.75rem;letter-spacing:.25em;text-transform:uppercase;margin-top:6px">Plateforme artisanale</div>
      </td>
    </tr>

    <!-- Body -->
    <tr>
      <td style="background:#fff;padding:48px 48px 40px;border-left:1px solid #E8D5C0;border-right:1px solid #E8D5C0">

        <h1 style="font-size:1.4rem;font-weight:800;color:#6B2D0E;margin:0 0 16px">
          Bonjour {{ $user->first_name }},
        </h1>

        <p style="color:#4A3424;font-size:.95rem;line-height:1.7;margin:0 0 24px">
          Nous avons bien examiné votre dossier de demande d'accréditation artisan sur la plateforme FeGArtisan. Après vérification, nous ne sommes <strong>pas en mesure de valider votre compte</strong> pour le moment.
        </p>

        <!-- Reason box -->
        <div style="background:#FEF2F2;border:1px solid #FCA5A5;border-left:4px solid #C94A3A;border-radius:10px;padding:20px 24px;margin:0 0 28px">
          <p style="margin:0 0 10px;font-weight:700;color:#991B1B;font-size:.88rem;text-transform:uppercase;letter-spacing:.05em">Motif du refus</p>
          <p style="margin:0;color:#7F1D1D;font-size:.92rem;line-height:1.6">{{ $reason }}</p>
        </div>

        <!-- What to do -->
        <div style="background:#FDF6EE;border:1px solid #F1E1CD;border-radius:12px;padding:24px 28px;margin:0 0 28px">
          <p style="margin:0 0 14px;font-weight:700;color:#6B2D0E;font-size:.9rem">Que faire maintenant ?</p>
          <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
              <td style="padding:6px 0;color:#4A3424;font-size:.88rem">
                <span style="color:#C17B4E;font-weight:700;margin-right:8px">1.</span> Corrigez les points mentionnés ci-dessus
              </td>
            </tr>
            <tr>
              <td style="padding:6px 0;color:#4A3424;font-size:.88rem">
                <span style="color:#C17B4E;font-weight:700;margin-right:8px">2.</span> Mettez à jour votre profil et vos documents dans l'application
              </td>
            </tr>
            <tr>
              <td style="padding:6px 0;color:#4A3424;font-size:.88rem">
                <span style="color:#C17B4E;font-weight:700;margin-right:8px">3.</span> Soumettez à nouveau votre dossier pour une nouvelle évaluation
              </td>
            </tr>
          </table>
        </div>

        <p style="color:#9A7A64;font-size:.87rem;line-height:1.6;margin:0">
          Cette décision n'est pas définitive. Vous pouvez soumettre un nouveau dossier une fois les corrections apportées. Notre équipe fera tout son possible pour examiner votre dossier dans les meilleurs délais.
        </p>
      </td>
    </tr>

    <!-- Footer -->
    <tr>
      <td style="background:#F5EDE0;border:1px solid #E8D5C0;border-top:none;border-radius:0 0 16px 16px;padding:24px 48px;text-align:center">
        <p style="margin:0;color:#9A7A64;font-size:.78rem;line-height:1.6">
          © {{ date('Y') }} FeGArtisan · Tous droits réservés<br>
          Vous recevez cet email car vous avez créé un compte artisan sur notre plateforme.
        </p>
      </td>
    </tr>

  </table>

</td></tr>
</table>

</body>
</html>
