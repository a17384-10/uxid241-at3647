<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$message = '';

// Handle adding a new recipe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_recipe') {
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $servings = (int)($_POST['servings'] ?? 1);
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if (!empty($title) && !empty($category) && !empty($description)) {
        $stmt = mysqli_prepare($db, "INSERT INTO recipes (title, subtitle, category, servings, description, image) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssiss", $title, $subtitle, $category, $servings, $description, $image);
        if (mysqli_stmt_execute($stmt)) {
            $message = "🎉 Recipe added successfully!";
        } else {
            $message = "❌ Error adding recipe.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "⚠️ Please fill in all required fields (Title, Category, Description).";
    }
}

// Handle search query
$search = trim($_GET['search'] ?? '');

if (!empty($search)) {
    $searchTerm = "%" . $search . "%";
    $stmt = mysqli_prepare($db, "SELECT * FROM recipes WHERE title LIKE ? OR category LIKE ? OR description LIKE ? ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmt, "sss", $searchTerm, $searchTerm, $searchTerm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
} else {
    // Fetch all recipes from the database
    $query = "SELECT * FROM recipes ORDER BY created_at DESC";
    $result = mysqli_query($db, $query);
    $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alpha build</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <h1>🌮📚🥞 Cookbook 🍩📖🧁</h1>

    <?php if (!empty($message)): ?>
        <div class="message-banner"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <!-- search and add new recipe form -->
    <div class="controls-container">
        <form method="GET" action="alpha.php" class="search-form">
            <input type="text" name="search" placeholder="🔍 Search recipes by title, category..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn">Search</button>
            <?php if (!empty($search)): ?>
                <button type="button" class="btn-secondary" onclick="location.href='alpha.php'">Reset</button>
            <?php endif; ?>
        </form>
        
        <button type="button" class="btn" onclick="toggleAddForm()"> + Add New Recipe</button>
    </div>

    <!-- add recipe form -->
    <div id="add-recipe-modal" class="recipe-card" style="display: none; margin-top: 20px; width: auto;">
        <h3>✨ Add a New Recipe</h3>
        <form method="POST" action="alpha.php" class="add-form">
            <input type="hidden" name="action" value="add_recipe">
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" required>
            </div>

            <div class="form-group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" placeholder="e.g., with Kale Rice & Roasted Carrots">
            </div>

            <div class="form-group">
                <label>Category *</label>
                <input type="text" name="category" placeholder="e.g., Chicken, Vegetarian, Beef">
            </div>

            <div class="form-group">
                <label>Servings *</label>
                <input type="number" name="servings" value="2" min="1" required>
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="text" name="image" placeholder="Link image here">
            </div>

            <button type="submit" class="btn">💾 Save Recipe</button>
        </form>
    </div>

    <hr>

    <!-- in case of error -->
    <?php if (empty($recipes)): ?>
        <p>No recipes found</p>
    <?php else: ?>
        
        <!-- recipes -->
        <p><em>Showing <?= count($recipes) ?> recipe(s)</em></p>
        
        <div class="recipe-grid">
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <div class="recipe-top-row">
                        <div class="recipe-info">
                            <h3><?= htmlspecialchars($recipe['title']) ?></h3>
                            
                            <?php if (!empty($recipe['subtitle'])): ?>
                                <div class="subtitle"><?= htmlspecialchars($recipe['subtitle']) ?></div>
                            <?php endif; ?>
                            
                            <div class="meta">
                                <span class="badge">Category: <?= htmlspecialchars($recipe['category']) ?></span> | 
                                <strong>Servings:</strong> <?= htmlspecialchars((string)$recipe['servings']) ?>
                            </div>
                        </div>

                        <?php if (!empty($recipe['image'])): ?>
                            <img src="<?= htmlspecialchars($recipe['image']) ?>" alt="<?= htmlspecialchars($recipe['title']) ?>" class="recipe-img">
                        <?php endif; ?>
                    </div>

                    <!-- description -->
                    <div class="recipe-description">
                        <p><?= htmlspecialchars($recipe['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <script>
        function toggleAddForm() {
            const formCard = document.getElementById('add-recipe-modal');
            if (formCard.style.display === 'none') {
                formCard.style.display = 'block';
            } else {
                formCard.style.display = 'none';
            }
        }
    </script>
</body>
</html>