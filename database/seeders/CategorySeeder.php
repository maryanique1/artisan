<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            [
                'name'        => 'Bâtiment & Travaux',
                'description' => 'Construction, rénovation et travaux du bâtiment',
                'children'    => [
                    ['name' => 'Maçon',                 'description' => 'Construction, rénovation, fondations'],
                    ['name' => 'Plombier',              'description' => 'Plomberie, tuyauterie, sanitaire'],
                    ['name' => 'Électricien bâtiment',  'description' => 'Installation et dépannage électrique'],
                    ['name' => 'Carreleur',             'description' => 'Pose de carrelage et faïence'],
                    ['name' => 'Peintre en bâtiment',  'description' => 'Peinture intérieure et extérieure'],
                    ['name' => 'Ferrailleur',           'description' => 'Armatures métalliques, ferronnerie'],
                    ['name' => 'Menuisier aluminium',   'description' => 'Fenêtres, portes et structures aluminium'],
                    ['name' => 'Vitrier',               'description' => 'Pose et remplacement de vitres'],
                    ['name' => 'Étancheur',             'description' => 'Imperméabilisation de toitures et terrasses'],
                    ['name' => 'Foreur (puits)',        'description' => 'Forage de puits et captage d\'eau'],
                ],
            ],
            [
                'name'        => 'Bois & Ameublement',
                'description' => 'Travaux de bois, menuiserie et fabrication de meubles',
                'children'    => [
                    ['name' => 'Menuisier bois',                  'description' => 'Travaux de bois, portes, parquets'],
                    ['name' => 'Ébéniste',                        'description' => 'Mobilier haut de gamme, restauration d\'antiquités'],
                    ['name' => 'Charpentier',                     'description' => 'Charpente bois, toiture, ossature'],
                    ['name' => 'Tapissier',                       'description' => 'Rembourrage et habillage de meubles'],
                    ['name' => 'Fabricant de meubles sur mesure', 'description' => 'Conception et fabrication de meubles personnalisés'],
                ],
            ],
            [
                'name'        => 'Réparation & Technique',
                'description' => 'Réparation, maintenance et services techniques',
                'children'    => [
                    ['name' => 'Mécanicien auto',               'description' => 'Entretien et réparation automobile'],
                    ['name' => 'Électricien auto',              'description' => 'Électronique et câblage automobile'],
                    ['name' => 'Soudeur',                       'description' => 'Soudure métallique, ferronnerie'],
                    ['name' => 'Frigoriste',                    'description' => 'Installation et maintenance climatisation et réfrigération'],
                    ['name' => 'Réparateur TV',                 'description' => 'Réparation téléviseurs et écrans'],
                    ['name' => 'Réparateur téléphone',          'description' => 'Réparation smartphones et tablettes'],
                    ['name' => 'Réparateur ordinateur',         'description' => 'Dépannage et maintenance informatique'],
                    ['name' => 'Installateur panneaux solaires','description' => 'Installation de systèmes photovoltaïques'],
                    ['name' => 'Technicien réseau / internet',  'description' => 'Installation et maintenance réseaux et internet'],
                    ['name' => 'Réparateur électroménager',     'description' => 'Réparation lave-linge, réfrigérateur, etc.'],
                ],
            ],
            [
                'name'        => 'Mode & Beauté',
                'description' => 'Couture, coiffure, esthétique et mode',
                'children'    => [
                    ['name' => 'Couturier / Styliste', 'description' => 'Couture, confection et stylisme'],
                    ['name' => 'Brodeur',              'description' => 'Broderie sur tissu et vêtements'],
                    ['name' => 'Teinturier',           'description' => 'Batik, tie-dye, teinture indigo'],
                    ['name' => 'Coiffeur',             'description' => 'Coiffure hommes, femmes et enfants'],
                    ['name' => 'Tresseuse',            'description' => 'Tressage et coiffures africaines'],
                    ['name' => 'Barbier',              'description' => 'Coupe et rasage pour hommes'],
                    ['name' => 'Esthéticienne',        'description' => 'Soins du corps, ongles, épilation'],
                    ['name' => 'Maquilleuse',          'description' => 'Maquillage événementiel et professionnel'],
                ],
            ],
            [
                'name'        => 'Alimentation & Services',
                'description' => 'Boulangerie, restauration et transformation alimentaire',
                'children'    => [
                    ['name' => 'Boulanger',                      'description' => 'Fabrication de pain et viennoiseries'],
                    ['name' => 'Pâtissier',                      'description' => 'Gâteaux, desserts et pâtisseries'],
                    ['name' => 'Traiteur',                       'description' => 'Préparation repas pour événements'],
                    ['name' => 'Cuisinier à domicile',           'description' => 'Cuisine à domicile sur commande'],
                    ['name' => 'Transformateur agroalimentaire', 'description' => 'Transformation de produits alimentaires locaux'],
                    ['name' => 'Fabricant de jus naturels',      'description' => 'Jus de fruits et boissons naturelles artisanales'],
                ],
            ],
            [
                'name'        => 'Artisanat & Création',
                'description' => 'Bijouterie, poterie, sculpture et artisanat local',
                'children'    => [
                    ['name' => 'Bijoutier',                    'description' => 'Création et réparation de bijoux'],
                    ['name' => 'Potier',                       'description' => 'Poterie et céramique artisanale'],
                    ['name' => 'Sculpteur',                    'description' => 'Sculpture sur bois, pierre ou métal'],
                    ['name' => 'Fabricant de déco artisanale', 'description' => 'Objets décoratifs et artisanat local'],
                    ['name' => 'Sérigraphe',                   'description' => 'Impression sur t-shirts et textiles'],
                ],
            ],
            [
                'name'        => 'Services du Quotidien',
                'description' => 'Services pratiques du quotidien à domicile',
                'children'    => [
                    ['name' => 'Cordonnier',               'description' => 'Réparation et entretien de chaussures'],
                    ['name' => 'Serrurier',                'description' => 'Ouverture, remplacement et installation de serrures'],
                    ['name' => 'Laveur de voitures',       'description' => 'Nettoyage et lavage de véhicules'],
                    ['name' => 'Jardinier / Paysagiste',   'description' => 'Entretien de jardins et espaces verts'],
                    ['name' => 'Agent d\'entretien',       'description' => 'Nettoyage de maisons et bureaux'],
                    ['name' => 'Décorateur événementiel',  'description' => 'Décoration et mise en scène d\'événements'],
                ],
            ],
        ];

        foreach ($tree as $branchData) {
            $branch = Category::firstOrCreate(
                ['slug' => Str::slug($branchData['name'])],
                [
                    'name'        => $branchData['name'],
                    'description' => $branchData['description'],
                    'parent_id'   => null,
                    'is_active'   => true,
                ]
            );

            foreach ($branchData['children'] as $child) {
                Category::firstOrCreate(
                    ['slug' => Str::slug($child['name'])],
                    [
                        'name'        => $child['name'],
                        'description' => $child['description'],
                        'parent_id'   => $branch->id,
                        'is_active'   => true,
                    ]
                );
            }
        }
    }
}
