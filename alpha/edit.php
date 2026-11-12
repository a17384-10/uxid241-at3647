<?php
declare(strict_types=1);

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/db.php';

$message = '';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: alpha.php');
    exit;
}

// used ai for whole page

// update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $servings = (int)($_POST['servings'] ?? 1);
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image'] ?? '');

    if (!empty($title) && !empty($category) && !empty($description) && $servings > 0) {
        $stmt = mysqli_prepare($db, "UPDATE recipes SET title = ?, subtitle = ?, category = ?, servings = ?, description = ?, image = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssissi", $title, $subtitle, $category, $servings, $description, $image, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            header('Location: alpha.php');
            exit;
        } else {
            $message = "❌ Error updating recipe.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "⚠️ Please fill in all required fields correctly.";
    }
}

// fetch existing recipe data
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Recipe - Cookbook</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header class="top-bar">
        <h1>✏️ Edit Recipe</h1>
        <div class="user-nav">
            <a href="alpha.php" class="btn-secondary" style="text-decoration: none;">← Back to Dashboard</a>
        </div>
    </header>

    <?php if (!empty($message)): ?>
        <div class="message-banner"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <div class="recipe-card" style="width: auto; max-width: 600px; margin: 20px auto;">
        <h3>Editing: <?= htmlspecialchars($recipe['title']) ?></h3>
        <form method="POST" action="edit.php?id=<?= $id ?>" class="add-form">
            <input type="hidden" name="id" value="<?= $id ?>">
            
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required>
            </div>

            <div class="form-group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" value="<?= htmlspecialchars($recipe['subtitle'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Category *</label>
                <input type="text" name="category" value="<?= htmlspecialchars($recipe['category']) ?>" required>
            </div>

            <div class="form-group">
                <label>Servings *</label>
                <input type="number" name="servings" value="<?= (int)$recipe['servings'] ?>" min="1" required>
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" rows="4" required><%= htmlspecialchars($recipe['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image" value="<?= htmlspecialchars($recipe['image'] ?? '') ?>">
            </div>

            <button type="submit" class="btn">💾 Update Recipe</button>
        </form>
    </div>
</body>
</html>