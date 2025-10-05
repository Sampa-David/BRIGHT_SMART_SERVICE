<?php

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

try {
    $pdo = DB::connection()->getPdo();
    echo "✓ Connexion à Supabase établie avec succès!\n";
    echo "Base de données: " . DB::connection()->getDatabaseName() . "\n";
} catch (\Exception $e) {
    die("❌ Erreur de connexion: " . $e->getMessage() . "\n");
}