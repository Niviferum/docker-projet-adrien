<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de Noms de Groupes</title>
    <link rel="icon" type="image/svg+xml" href="assets/images/favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>🎸 Band Name Generator</h1>
        <p class="subtitle">Créez des noms de groupes Metal ou Speedcore en un clic</p>
        
        <div class="section">
            <h2>📡 Test de connexion</h2>
            <form method="POST">
                <input type="hidden" name="action" value="test_connection">
                <button type="submit">Tester la connexion à la base de données</button>
            </form>
            <?php if ($connectionStatus): ?>
                <p class="<?= $connectionIsOk ? 'success' : 'error' ?>">
                    <?= htmlspecialchars($connectionStatus) ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="section">
            <h2>🎵 Générer des noms</h2>
            <form method="POST">
                <input type="hidden" name="action" value="generate_names">
                
                <label for="genre">Genre musical :</label>
                <select name="genre" id="genre">
                    <option value="metal" <?= $selectedGenre === 'metal' ? 'selected' : '' ?>>
                        🤘 Metal
                    </option>
                    <option value="speedcore" <?= $selectedGenre === 'speedcore' ? 'selected' : '' ?>>
                        ⚡ Speedcore
                    </option>
                </select>
                
                <button type="submit">Générer 10 noms</button>
            </form>

            <?php if ($error): ?>
                <p class="error">❌ <?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <?php if (!empty($bandNames)): ?>
                <div class="band-names">
                    <h3>
                        Vos noms de groupe
                        <span class="genre-badge"><?= ucfirst(htmlspecialchars($selectedGenre)) ?></span>
                    </h3>
                    <ul>
                        <?php foreach ($bandNames as $name): ?>
                            <li><?= htmlspecialchars($name) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>