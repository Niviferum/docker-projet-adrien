<?php
/**
 * Contrôleur principal de l'application
 * Gère les requêtes et prépare les données pour la vue
 */

require_once __DIR__ . '/includes/functions.php';

// Initialisation des variables pour la vue
$connectionStatus = '';
$connectionIsOk = false;
$bandNames = [];
$selectedGenre = 'metal';
$error = '';

// Traitement des actions utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'test_connection') {
            // On teste la connexion et on stocke le résultat
            $connectionIsOk = testDatabaseConnection();
            $connectionStatus = $connectionIsOk 
                ? 'Communication avec la base de données établie' 
                : 'Impossible de se connecter à la base de données';
        } 
        elseif ($action === 'generate_names') {
            // Récupération du genre sélectionné
            $selectedGenre = isset($_POST['genre']) ? $_POST['genre'] : 'metal';
            
            // Validation du genre
            if (!in_array($selectedGenre, ['metal', 'speedcore'])) {
                $error = 'Genre invalide';
            } else {
                // Génération des noms
                $bandNames = generateBandNames($selectedGenre);
                
                if (empty($bandNames)) {
                    $error = 'Impossible de générer des noms. Vérifiez la connexion à la base de données.';
                }
            }
        }
    }
}

// Chargement de la vue
// À ce stade, toutes les variables sont prêtes
require_once __DIR__ . '/views/home.php';