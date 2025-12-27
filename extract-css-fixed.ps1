# Script PowerShell pour extraire et externaliser le CSS des fichiers Blade
# Usage: .\extract-css-fixed.ps1

# Configuration
$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$viewsPath = "$projectRoot\resources\views"
$cssPath = "$projectRoot\public\css\views"

# Créer le répertoire CSS s'il n'existe pas
if (-not (Test-Path $cssPath)) {
    New-Item -ItemType Directory -Path $cssPath -Force | Out-Null
    Write-Host "Répertoire créé: $cssPath" -ForegroundColor Green
}

# Compteurs
$totalFiles = 0
$processedFiles = 0
$errorFiles = 0

# Fonction pour extraire et externaliser le CSS
function Extract-CSS {
    param(
        [string]$filePath
    )

    try {
        # Lire le contenu du fichier
        $content = Get-Content -Path $filePath -Raw -Encoding UTF8
        
        # Pattern pour trouver le CSS
        $pattern = '(?s)<style[^>]*>(.*?)</style>'
        
        # Vérifier si le fichier contient du CSS
        if ($content -notmatch $pattern) {
            return $false
        }

        # Extraire le CSS
        if ($content -match $pattern) {
            $cssContent = $matches[1]
            
            # Créer un nom de fichier CSS
            $fileName = [System.IO.Path]::GetFileNameWithoutExtension($filePath)
            $cssFileName = "$fileName.css"
            $cssFilePath = Join-Path $cssPath $cssFileName
            
            # Écrire le CSS dans le nouveau fichier
            Set-Content -Path $cssFilePath -Value $cssContent.Trim() -Encoding UTF8 -Force
            Write-Host "CSS créé: $cssFileName" -ForegroundColor Cyan
            
            # Remplacer le CSS interne par un lien vers le fichier CSS
            $replacement = '    <link rel="stylesheet" href="{{ asset("css/views/' + $cssFileName + '") }}">'
            $newContent = $content -replace $pattern, $replacement
            
            # Écrire le contenu modifié
            Set-Content -Path $filePath -Value $newContent -Encoding UTF8 -Force
            Write-Host "Vue mise à jour: $(Split-Path -Leaf $filePath)" -ForegroundColor Green
            
            return $true
        }
        
        return $false
    }
    catch {
        Write-Host "Erreur pour $filePath : $_" -ForegroundColor Red
        return $false
    }
}

# Traiter tous les fichiers Blade
Write-Host "`nRecherche des fichiers .blade.php avec CSS interne...`n" -ForegroundColor Yellow

$bladeFiles = Get-ChildItem -Path $viewsPath -Filter "*.blade.php" -Recurse

foreach ($file in $bladeFiles) {
    $totalFiles++
    if (Extract-CSS -filePath $file.FullName) {
        $processedFiles++
    }
}

# Afficher le résumé
Write-Host "`n" -ForegroundColor White
Write-Host "==== Résumé du traitement ====" -ForegroundColor Green
Write-Host "Fichiers traités: $totalFiles" -ForegroundColor Green
Write-Host "Réussis: $processedFiles" -ForegroundColor Green
Write-Host "Fichiers CSS créés: $processedFiles" -ForegroundColor Green
Write-Host "Erreurs: $errorFiles" -ForegroundColor Green
Write-Host "============================" -ForegroundColor Green

Write-Host "`nExtraction du CSS terminée !" -ForegroundColor Green
Write-Host "Les fichiers CSS sont dans: public/css/views/" -ForegroundColor Cyan
