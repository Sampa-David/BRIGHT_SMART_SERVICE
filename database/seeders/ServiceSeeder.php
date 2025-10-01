<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ServiceSeeder extends Seeder
{
    private function downloadAndSaveImage($imageUrl, $imageName)
    {
        try {
            $response = Http::get($imageUrl);
            if ($response->successful()) {
                Storage::disk('public')->put('services/' . $imageName, $response->body());
                return 'services/' . $imageName;
            }
        } catch (\Exception $e) {
            \Log::error('Error downloading image: ' . $e->getMessage());
        }
        return null;
    }

    public function run()
    {
        // Créer le dossier services s'il n'existe pas
        if (!Storage::disk('public')->exists('services')) {
            Storage::disk('public')->makeDirectory('services');
        }

        $services = [
            [
                'name' => 'Réparation Mécanique',
                'title' => 'Réparation Mécanique Générale',
                'description' => 'Service complet de réparation mécanique pour tous types de véhicules. Nos experts qualifiés utilisent des équipements de pointe pour diagnostiquer et résoudre tous les problèmes mécaniques.',
                'price' => 80,
                'image_url' => 'https://images.unsplash.com/photo-1606577924006-27d39b132ae2?w=800&q=80',
                'filename' => 'mechanic.jpg'
            ],
            [
                'name' => 'Entretien',
                'title' => 'Entretien Périodique',
                'description' => 'Service d\'entretien régulier comprenant changement d\'huile, filtres, et inspection complète du véhicule pour garantir sa performance et sa longévité.',
                'price' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1617886322168-72b949e5a43f?w=800&q=80',
                'filename' => 'maintenance.jpg'
            ],
            [
                'name' => 'Diagnostic',
                'title' => 'Diagnostic Électronique',
                'description' => 'Diagnostic complet des systèmes électroniques de votre véhicule avec des outils de dernière génération pour identifier précisément tout dysfonctionnement.',
                'price' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1631548066293-b07779494769?w=800&q=80',
                'filename' => 'diagnostic.jpg'
            ],
            [
                'name' => 'Climatisation',
                'title' => 'Climatisation Auto',
                'description' => 'Service complet de maintenance et réparation de climatisation automobile, incluant la recharge de gaz et la réparation des fuites.',
                'price' => 70,
                'image_url' => 'https://images.unsplash.com/photo-1623012672852-7e5f94e82a3e?w=800&q=80',
                'filename' => 'ac.jpg'
            ],
            [
                'name' => 'Carrosserie',
                'title' => 'Carrosserie et Peinture',
                'description' => 'Services professionnels de réparation de carrosserie et de peinture, de la petite rayure à la rénovation complète de votre véhicule.',
                'price' => 150,
                'image_url' => 'https://images.unsplash.com/photo-1507136566006-cfc505b114fc?w=800&q=80',
                'filename' => 'bodywork.jpg'
            ],
            [
                'name' => 'Pneumatiques',
                'title' => 'Service Pneumatiques',
                'description' => 'Service complet pour vos pneumatiques : montage, équilibrage, permutation et alignement des roues pour une tenue de route optimale.',
                'price' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1580657018950-c7f7d6a6d990?w=800&q=80',
                'filename' => 'tires.jpg'
            ],
        ];

        foreach ($services as $service) {
            // Télécharger et sauvegarder l'image
            $imagePath = $this->downloadAndSaveImage($service['image_url'], $service['filename']);
            
            // Créer le service avec l'image téléchargée
            Service::create([
                'name' => $service['name'],
                'title' => $service['title'],
                'description' => $service['description'],
                'price' => $service['price'],
                'image' => $imagePath ?? 'services/default.jpg' // Image par défaut si le téléchargement échoue
            ]);
        }
    }
}
