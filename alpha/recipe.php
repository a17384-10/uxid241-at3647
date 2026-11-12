<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/db.php';

// Get and validate recipe ID
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: alpha.php');
    exit;
}

// Fetch recipe securely
$stmt = mysqli_prepare($db, "SELECT * FROM recipes WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$recipe = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$recipe) {
    header('Location: alpha.php');
    exit;
}

// Helper to read CSV rows
function get_csv_rows(string $filename, int $recipe_id): array {
    $rows = [];
    $possible_paths = [
        __DIR__ . '/../data/' . $filename,
        __DIR__ . '/../' . $filename,
        $filename
    ];
    
    $filepath = '';
    foreach ($possible_paths as $path) {
        if (file_exists($path)) {
            $filepath = $path;
            break;
        }
    }
    
    if ($filepath && ($handle = fopen($filepath, 'r')) !== FALSE) {
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== FALSE) {
            if (count($header) === count($data)) {
                $row = array_combine($header, $data);
                if (isset($row['recipe_id']) && (int)$row['recipe_id'] === $recipe_id) {
                    $rows[] = $row;
                }
            }
        }
        fclose($handle);
    }
    return $rows;
}

// Helper to fix image paths
function fix_image_path(string $path): string {
    if (str_starts_with($path, 'images/')) {
        return '../images-renamed/' . substr($path, 7);
    }
    return $path;
}

$ingredients = get_csv_rows('recipes_data_ver8.xlsx - ingredients.csv', $id);
$steps = get_csv_rows('recipes_data_ver8.xlsx - steps.csv', $id);
$images = get_csv_rows('recipes_data_ver8.xlsx - images.csv', $id);

usort($steps, fn($a, $b) => ((int)($a['step_number'] ?? 0)) <=> ((int)($b['step_number'] ?? 0)));
usort($ingredients, fn($a, $b) => ((int)($a['sort_order'] ?? 0)) <=> ((int)($b['sort_order'] ?? 0)));

$ingredients_image = '';
foreach ($images as $img) {
    if (($img['type'] ?? '') === 'ingredients_grid') {
        $ingredients_image = fix_image_path($img['path']);
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recipe['title']) ?> - Cookbook</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header class="top-bar">
        <h1>🌮📚🥞 Cookbook 🍩📖🧁</h1>
        <div class="user-nav">
            <a href="alpha.php" class="btn-secondary" style="text-decoration: none;">← Back to Recipes</a>
        </div>
    </header>

    <div class="recipe-detail-container">
        <!-- header -->
        <div class="recipe-header-row">
            <div class="recipe-title-area">
                <h2><?= htmlspecialchars($recipe['title']) ?></h2>
                <?php if (!empty($recipe['subtitle'])): ?>
                    <div class="subtitle"><?= htmlspecialchars($recipe['subtitle']) ?></div>
                <?php endif; ?>
                <div class="meta" style="margin-top: 10px;">
                    <span class="badge">Category: <?= htmlspecialchars($recipe['category']) ?></span> &nbsp;|&nbsp; 
                    <strong>Servings:</strong> <?= htmlspecialchars((string)$recipe['servings']) ?>
                </div>
            </div>

            <?php if (!empty($recipe['image'])): ?>
                <img src="<?= htmlspecialchars(fix_image_path($recipe['image'])) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" class="recipe-main-img">
            <?php endif; ?>
        </div>

        <!-- description -->
        <div class="recipe-overview-box">
            <p style="margin: 0;"><?= htmlspecialchars($recipe['description']) ?></p>
        </div>

        <!-- ingredients -->
        <div class="ingredients-section">
            <h3 class="section-title">🛒 Ingredients (<?= count($ingredients) ?>)</h3>
            <?php if (!empty($ingredients)): ?>
                <div class="ingredients-card">
                    <ul class="ingredients-grid">
                        <?php foreach ($ingredients as $ing): ?>
                            <li><?= htmlspecialchars($ing['full_text'] ?? $ing['name']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <p>No ingredients listed.</p>
            <?php endif; ?>

            <?php if (!empty($ingredients_image)): ?>
                <div class="ingredients-grid-img">
                    <img src="<?= htmlspecialchars($ingredients_image) ?>" alt="All Ingredients Grid">
                </div>
            <?php endif; ?>
        </div>

        <!-- steps -->
        <div class="steps-section">
            <h3 class="section-title">👩‍🍳 Step-by-Step Instructions</h3>
            <?php if (empty($steps)): ?>
                <p>No steps available for this recipe.</p>
            <?php else: ?>
                <div class="steps-container">
                    <?php foreach ($steps as $step): ?>
                        <div class="step-card-section">
                            <div class="step-card-content">
                                <div class="step-header-flex">
                                    <div class="step-number-badge"><?= htmlspecialchars((string)($step['step_number'] ?? '')) ?></div>
                                    <?php if (!empty($step['step_title'])): ?>
                                        <span class="step-title-text"><?= htmlspecialchars($step['step_title']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <p class="step-desc-text"><?= htmlspecialchars($step['instructions']) ?></p>
                            </div>
                            
                            <?php if (!empty($step['image'])): ?>
                                <div class="step-card-img-wrap">
                                    <img src="<?= htmlspecialchars(fix_image_path($step['image'])) ?>" alt="Step <?= htmlspecialchars((string)$step['step_number']) ?>" class="step-card-img">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- admin actions -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div style="margin-top: 40px; border-top: 2px solid #ffcce1; padding-top: 25px; display: flex; gap: 10px;">
                <a href="edit.php?id=<?= (int)$recipe['id'] ?>" class="btn-secondary" style="text-decoration: none;">✏️ Edit Recipe</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>