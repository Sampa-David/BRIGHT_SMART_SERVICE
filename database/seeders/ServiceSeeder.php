<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Services data with descriptions and image URLs (using reliable sources)
        $services = [
            [
                'name' => 'Video Surveillance',
                'description' => 'Systèmes de vidéosurveillance haute définition pour la protection de votre entreprise et de vos locaux. Installation, maintenance et monitoring 24/7 de caméras IP, DVR et NVR avec enregistrement sécurisé et accès à distance.',
                'image_url' => 'https://images.pexels.com/photos/3587620/pexels-photo-3587620.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'name' => 'Systemes d\'Alarme Anti-Intrusion',
                'description' => 'Alarmes anti-intrusion sophistiquées avec détecteurs de mouvement, capteurs d\'ouverture et système de contrôle centralisé. Alertes instantanées et intervention rapide pour sécuriser vos biens.',
                'image_url' => 'https://images.pexels.com/photos/8192840/pexels-photo-8192840.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'name' => 'Systeme de Securite Incendie',
                'description' => 'Nous installons et maintenons des systèmes de sécurité incendie pour détecter rapidement les risques et protéger les personnes, les biens et les infrastructures. Nous protégeons vos bâtiments contre les risques d’incendie.',
                'image_url' => 'https://images.pexels.com/photos/5633666/pexels-photo-5633666.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'name' => 'Genie Logiciel',
                'description' => 'Systèmes téléphoniques IP modernes avec visioconférence, interconnexion d\'établissements et interfaces d\'interphonie intelligentes. Réduction des coûts de communication et augmentation de la productivité.',
                'image_url' => 'https://images.pexels.com/photos/3791664/pexels-photo-3791664.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'name' => 'Administration & Reseaux Informatique',
                'description' => 'Gestion complète de l\'infrastructure réseau : installation, configuration, administration système et support technique. Optimisation des performances réseau et sécurité des données.',
                'image_url' => 'https://images.pexels.com/photos/3194521/pexels-photo-3194521.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'name' => 'Portails Motorises',
                'description' => 'Installation et maintenance de portails motorisés automatisés avec systèmes de contrôle d\'accès sans contact. Solutions de confort et de sécurité pour entrées résidentielles et commerciales.',
                'image_url' => 'https://images.pexels.com/photos/1957173/pexels-photo-1957173.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'name' => 'Controle d\'Acces',
                'description' => 'Systèmes de contrôle d\'accès par badge, empreinte digitale ou reconnaissance faciale. Gestion granulaire des permissions, logs d\'accès et intégration avec systèmes de sécurité.',
                'image_url' => 'https://images.pexels.com/photos/3182754/pexels-photo-3182754.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'name' => 'Genie Logiciel',
                'description' => 'Développement de logiciels sur mesure, applications métier, intégration système et maintenance logicielle. Solutions adaptées aux besoins spécifiques de votre entreprise avec support technique inclus.',
                'image_url' => 'https://images.pexels.com/photos/3769714/pexels-photo-3769714.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
        ];

        // Create uploads directory if it doesn't exist
        if (!Storage::exists('public/uploads')) {
            Storage::makeDirectory('public/uploads');
            echo "✓ Dossier 'public/uploads' créé\n";
        }

        $createdCount = 0;
        $skippedCount = 0;

        foreach ($services as $serviceData) {
            try {
                // Check if service already exists
                $existingService = Service::where('name', $serviceData['name'])->first();
                if ($existingService) {
                    echo "⊘ Service existant ignoré: {$serviceData['name']}\n";
                    $skippedCount++;
                    continue;
                }

                

                // Create service
                Service::create([
                    'name' => $serviceData['name'],
                    'description' => $serviceData['description'],
                    'image' => null
                ]);

                echo "✓ Service créé: {$serviceData['name']} (Image: {})\n";
                $createdCount++;

            } catch (\Exception $e) {
                echo "✗ Erreur lors de la création de {$serviceData['name']}: {$e->getMessage()}\n";
                $skippedCount++;
            }
        }

        echo "\n=== RÉSUMÉ ===\n";
        echo "✓ Services créés: {$createdCount}\n";
        echo "⊘ Services ignorés: {$skippedCount}\n";
    }

    

    
    }
