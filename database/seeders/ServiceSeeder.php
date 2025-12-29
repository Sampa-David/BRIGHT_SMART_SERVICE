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
                'name' => 'Securite Incendie',
                'description' => 'Solutions complètes de sécurité incendie incluant détecteurs de fumée, systèmes d\'extinction automatiques, éclairage de secours et plans d\'évacuation. Conformité aux normes de sécurité.',
                'image_url' => 'https://images.pexels.com/photos/5633666/pexels-photo-5633666.jpeg?auto=compress&cs=tinysrgb&w=800'
            ],
            [
                'name' => 'Telephonie IP & Interphonie',
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

                // Download and save image
                $imagePath = $this->downloadAndSaveImage($serviceData['name'], $serviceData['image_url']);

                // Create service
                Service::create([
                    'name' => $serviceData['name'],
                    'description' => $serviceData['description'],
                    'image' => $imagePath,
                ]);

                echo "✓ Service créé: {$serviceData['name']} (Image: {$imagePath})\n";
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

    /**
     * Download image from URL and save it locally
     */
    private function downloadAndSaveImage(string $serviceName, string $imageUrl): string
    {
        try {
            echo "  → Téléchargement de l'image pour: {$serviceName}...\n";

            // Get image from URL with better timeout and headers
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'Accept' => 'image/*',
            ])->timeout(15)->get($imageUrl);

            if (!$response->successful()) {
                throw new \Exception("Réponse HTTP non-réussie: {$response->status()}");
            }

            // Generate unique filename
            $filename = 'service_' . time() . '_' . uniqid() . '.jpg';
            $path = 'public/uploads/' . $filename;

            // Save image
            Storage::put($path, $response->body());

            // Verify file was saved
            if (!Storage::exists($path)) {
                throw new \Exception("Impossible de sauvegarder le fichier: {$path}");
            }

            // Verify file size (max 2MB)
            $fileSize = Storage::size($path);
            if ($fileSize > 2 * 1024 * 1024) {
                Storage::delete($path);
                throw new \Exception("Image dépasse 2MB: {$fileSize} bytes");
            }

            echo "    ✓ Image téléchargée et sauvegardée ({$fileSize} bytes)\n";

            // Return relative path for database
            return 'uploads/' . $filename;

        } catch (\Exception $e) {
            \Log::error("Erreur téléchargement image {$serviceName}: " . $e->getMessage());
            echo "    ✗ Erreur: {$e->getMessage()}\n";
            
            // Create a placeholder image locally instead of failing
            return $this->createPlaceholderImage($serviceName);
        }
    }

    /**
     * Create a placeholder image if download fails
     */
    private function createPlaceholderImage(string $serviceName): string
    {
        try {
            // Create a simple colored placeholder image
            $image = imagecreatetruecolor(800, 600);
            $bgColor = imagecolorallocate($image, 27, 20, 100); // Dark blue background
            $textColor = imagecolorallocate($image, 255, 107, 0); // Orange text
            
            imagefill($image, 0, 0, $bgColor);
            
            // Add service name to image
            $font = __DIR__ . '/../../storage/fonts/arial.ttf';
            if (!file_exists($font)) {
                // Fallback to imagestring if TTF font not available
                imagestring($image, 5, 20, 280, 'Service: ' . $serviceName, $textColor);
            } else {
                imagettftext($image, 30, 0, 50, 300, $textColor, $font, $serviceName);
            }

            // Save placeholder
            $filename = 'service_placeholder_' . time() . '_' . uniqid() . '.jpg';
            $filepath = storage_path('app/public/uploads/' . $filename);
            
            imagejpeg($image, $filepath, 90);
            imagedestroy($image);

            echo "    ✓ Image placeholder créée\n";
            return 'uploads/' . $filename;

        } catch (\Exception $e) {
            echo "    ! Pas d'image, l'enregistrement continuera sans image\n";
            return '';
        }
    }
}
