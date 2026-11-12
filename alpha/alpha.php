<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/db.php';

$message = '';

// add recipes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_recipe') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $servings = (int)($_POST['servings'] ?? 1);
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $ingredients_input = trim($_POST['ingredients_list'] ?? '');
    $steps_input = trim($_POST['steps_list'] ?? '');

    if (!empty($title) && !empty($category) && !empty($description) && !empty($ingredients_input) && !empty($steps_input) && $servings > 0) {
        // uploads everything to the database and CSV files
        $stmt = mysqli_prepare($db, "INSERT INTO recipes (title, subtitle, category, servings, description, image) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssiss", $title, $subtitle, $category, $servings, $description, $image);
        
        if (mysqli_stmt_execute($stmt)) {
            $new_recipe_id = mysqli_insert_id($db);
            mysqli_stmt_close($stmt);

            // directs to the correct CSV file for ingredients
            $ing_file = __DIR__ . '/../data/recipes_data_ver8.xlsx - ingredients.csv';
            if (!file_exists($ing_file)) {
                $ing_file = 'recipes_data_ver8.xlsx - ingredients.csv';
            }
            
            $ing_lines = explode("\n", $ingredients_input);
            $fp = fopen($ing_file, 'a');
            $sort_order = 1;
            foreach ($ing_lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    fputcsv($fp, ['', $new_recipe_id, $title, $sort_order, '', '', '', $line, 'user']);
                    $sort_order++;
                }
            }
            fclose($fp);

            // steps
            $step_file = __DIR__ . '/../data/recipes_data_ver8.xlsx - steps.csv';
            if (!file_exists($step_file)) {
                $step_file = 'recipes_data_ver8.xlsx - steps.csv';
            }

            $step_lines = explode("\n", $steps_input);
            $fp = fopen($step_file, 'a');
            $step_num = 1;
            foreach ($step_lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    fputcsv($fp, ['', $new_recipe_id, $title, $step_num, "Step $step_num", $line, '', '', 'user']);
                    $step_num++;
                }
            }
            fclose($fp);

            $message = "🎉 Recipe added successfully with all ingredients and steps!";
        } else {
            $message = "❌ Error adding recipe to database.";
        }
    } else {
        $message = "⚠️ Please fill in all required fields, including ingredients and steps.";
    }
}

// delete recipes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_recipe') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = mysqli_prepare($db, "DELETE FROM recipes WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $message = "🗑️ Recipe deleted successfully!";
        } else {
            $message = "❌ Error deleting recipe.";
        }
        mysqli_stmt_close($stmt);
    }
}

// search
$search = trim($_GET['search'] ?? '');

if (!empty($search)) {
    $search_term = "%" . $search . "%";
    $stmt = mysqli_prepare($db, "SELECT * FROM recipes WHERE title LIKE ? OR category LIKE ? OR description LIKE ? ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmt, "sss", $search_term, $search_term, $search_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
} else {
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
    <title>Cookbook - Home</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header class="top-bar">
        <h1>🌮📚🥞 Cookbook 🍩📖🧁</h1>
        <div class="user-nav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span>Welcome, <strong><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></strong></span>
                <a href="logout.php" class="btn-secondary" style="text-decoration: none;">🔒 Log Out</a>
            <?php else: ?>
                <a href="login.php" class="btn" style="text-decoration: none;">🔑 Log In</a>
            <?php endif; ?>
        </div>
    </header>

    <?php if (!empty($message)): ?>
        <div class="message-banner"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="controls-container">
        <form method="GET" action="alpha.php" class="search-form">
            <input type="text" name="search" placeholder="🔍 Search recipes by title, category..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn">Search</button>
            <?php if (!empty($search)): ?>
                <button type="button" class="btn-secondary" onclick="location.href='alpha.php'">Reset</button>
            <?php endif; ?>
        </form>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <button type="button" class="btn" onclick="toggleAddForm()">+ Add New Recipe</button>
        <?php endif; ?>
    </div>

    <!-- add recipe form -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div id="add-recipe-modal" class="recipe-card" style="display: none; margin: 20px auto; width: auto; max-width: 800px;">
            <h3 style="color: #ff2bb5; margin-top: 0;">✨ Add a New Recipe</h3>
            <form method="POST" action="alpha.php" class="add-form">
                <input type="hidden" name="action" value="add_recipe">
                
                <div class="form-group">
                    <label>Title *</label>
                    <input type="text" name="title" required placeholder="e.g., Creamy Garlic Pasta">
                </div>

                <div class="form-group">
                    <label>Subtitle</label>
                    <input type="text" name="subtitle" placeholder="e.g., with Parmesan & Fresh Herbs">
                </div>

                <div class="form-group">
                    <label>Category *</label>
                    <input type="text" name="category" required placeholder="e.g., Pasta, Chicken, Vegetarian">
                </div>

                <div class="form-group">
                    <label>Servings *</label>
                    <input type="number" name="servings" value="2" min="1" required>
                </div>

                <div class="form-group">
                    <label>Description & Overview *</label>
                    <textarea name="description" rows="3" required placeholder="Briefly describe the recipe..."></textarea>
                </div>

                <div class="form-group">
                    <label>Ingredients (One per line) *</label>
                    <textarea name="ingredients_list" rows="4" required placeholder="1 cup flour&#10;2 eggs&#10;1 tsp salt"></textarea>
                </div>

                <div class="form-group">
                    <label>Step-by-Step Instructions (One per line) *</label>
                    <textarea name="steps_list" rows="5" required placeholder="Mix dry ingredients in a bowl.&#10;Whisk eggs and add to mixture.&#10;Bake at 350°F for 20 minutes."></textarea>
                </div>

                <div class="form-group">
                    <label>Image URL</label>
                    <input type="text" name="image" placeholder="Link image here (e.g., images/folder/dish.jpg)">
                </div>

                <button type="submit" class="btn">💾 Save Recipe</button>
                <button type="button" class="btn-secondary" onclick="toggleAddForm()">Cancel</button>
            </form>
        </div>
    <?php endif; ?>

    <hr style="border: 0; border-top: 2px dashed #ffcce1; margin: 25px 0;">

    <?php if (empty($recipes)): ?>
        <p>No recipes found.</p>
    <?php else: ?>
        <p style="color: #04868f; font-weight: bold;"><em>Showing <?= count($recipes) ?> recipe(s)</em></p>
        
        <div class="recipe-grid">
            <?php foreach ($recipes as $recipe): ?>
                <div>
                    <!-- Entire recipe card is fully clickable -->
                    <a href="recipe.php?id=<?= (int)$recipe['id'] ?>" class="recipe-card recipe-card-link" style="display: block; text-decoration: none; color: inherit;">
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

                        <div class="recipe-description">
                            <p><?= htmlspecialchars($recipe['description']) ?></p>
                        </div>
                    </a>

                    <!-- Admin Action Buttons (Kept separate so clicking Edit/Delete doesn't trigger card link) -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div style="margin-top: 10px; margin-bottom: 15px; display: flex; gap: 10px; position: relative; z-index: 2;">
                            <a href="edit.php?id=<?= (int)$recipe['id'] ?>" class="btn-secondary" style="text-decoration: none; padding: 6px 12px; font-size: 0.85rem;">✏️ Edit</a>
                            
                            <form method="POST" action="alpha.php" onsubmit="return confirm('Are you sure you want to delete this recipe?');" style="display:inline;">
                                <input type="hidden" name="action" value="delete_recipe">
                                <input type="hidden" name="id" value="<?= (int)$recipe['id'] ?>">
                                <button type="submit" class="btn" style="background: #ff3366; padding: 6px 12px; font-size: 0.85rem;">🗑️ Delete</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <script>
            function toggleAddForm() {
                const formCard = document.getElementById('add-recipe-modal');
                formCard.style.display = (formCard.style.display === 'none') ? 'block' : 'none';
            }
        </script>
    <?php endif; ?>
</body>
</html>