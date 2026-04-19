<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Firebase Service Account
    |--------------------------------------------------------------------------
    | Chemin ABSOLU vers le fichier JSON de la clé privée de service.
    | Téléchargeable depuis la Console Firebase :
    |   Paramètres du projet → Comptes de service → Générer une nouvelle clé privée
    |
    | Recommandé : placer le fichier sous storage/firebase/service-account.json
    | (dossier ignoré par git) et définir FIREBASE_CREDENTIALS dans .env :
    |
    |   FIREBASE_CREDENTIALS=storage/firebase/service-account.json
    */

    'credentials' => env('FIREBASE_CREDENTIALS'),

    /*
    |--------------------------------------------------------------------------
    | Push notifications enabled
    |--------------------------------------------------------------------------
    | Permet de désactiver l'envoi (utile en dev/tests).
    */

    'push_enabled' => env('FIREBASE_PUSH_ENABLED', true),

];
