<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Teste la connexion à la base de données
 * 
 * @return bool True si la connexion réussit, False sinon
 */
function testDatabaseConnection() {
    $pdo = getDatabaseConnection();
    return $pdo !== null;
}

/**
 * Génère des noms de groupes de musique aléatoires
 * 
 * @param string $genre Le genre musical ('metal' ou 'speedcore')
 * @param int $count Le nombre de noms à générer (par défaut 10)
 * @return array Liste des noms de groupes générés
 */
function generateBandNames($genre, $count = 10) {
    $pdo = getDatabaseConnection();
    
    if ($pdo === null) {
        return [];
    }
    
    try {
        $sql = "SELECT a.word as adjective, n.word as noun 
                FROM adjectives a, nouns n 
                WHERE a.genre = :genre1 AND n.genre = :genre2 
                ORDER BY RAND() 
                LIMIT :limit";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':genre1', $genre, PDO::PARAM_STR);
        $stmt->bindValue(':genre2', $genre, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $count, PDO::PARAM_INT);
        $stmt->execute();
        
        $results = $stmt->fetchAll();
        
        $bandNames = [];
        foreach ($results as $row) {
            $bandNames[] = "The " . ucfirst($row['adjective']) . " " . ucfirst($row['noun']);
        }
        
        return $bandNames;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return [];
    }
}