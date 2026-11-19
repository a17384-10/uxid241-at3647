<?php
declare(strict_types=1);

<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/db.php';

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

// Helper to read CSV rows for this recipe
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
            if ($header && count($header) === count($data)) {
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

// Helper to update/overwrite CSV rows for this recipe
function update_csv_rows(string $filename, int $recipe_id, string $title, array $new_lines, string $type): void {
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
    if (!$filepath) {
        $filepath = __DIR__ . '/../data/' . $filename;
    }

    $all_rows = [];
    $header = null;
    if (file_exists($filepath) && ($handle = fopen($filepath, 'r')) !== FALSE) {
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($header && count($header) === count($data)) {
                $row = array_combine($header, $data);
                if (isset($row['recipe_id']) && (int)$row['recipe_id'] === $recipe_id) {
                    continue; // Skip old rows for this recipe
                }
                $all_rows[] = $data;
            }
        }
        fclose($handle);
    }

    if (!$header) {
        if ($type === 'ingredients') {
            $header = ['', 'recipe_id', 'title', 'sort_order', 'col4', 'col5', 'col6', 'full_text', 'source'];
        } else {
            $header = ['', 'recipe_id', 'title', 'step_number', 'step_title', 'instructions', 'col6', 'col7', 'source'];
        }
    }

    $fp = fopen($filepath, 'w');
    fputcsv($fp, $header);
    foreach ($all_rows as $r) {
        fputcsv($fp, $r);
    }

    $counter = 1;
    foreach ($new_lines as $line) {
        $line = trim($line);
        if (!empty($line)) {
            if ($type === 'ingredients') {
                fputcsv($fp, ['', $recipe_id, $title, $counter, '', '', '', $line, 'user']);
            } else {
                fputcsv($fp, ['', $recipe_id, $title, $counter, "Step $counter", $line, '', '', 'user']);
            }
            $counter++;
        }
    }
    fclose($fp);
}

// Fetch existing recipe data first
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

// Fetch existing ingredients and steps for pre-filling textareas
$existing_ingredients = get_csv_rows('recipes_data_ver8.xlsx - ingredients.csv', $id);
$ing_texts = [];
foreach ($existing_ingredients as $ing) {
    $ing_texts[] = $ing['full_text'] ?? $ing['name'] ?? '';
}
$ingredients_string = implode("\n", $ing_texts);

$existing_steps = get_csv_rows('recipes_data_ver8.xlsx - steps.csv', $id);
usort($existing_steps, fn($a, $b) => ((int)($a['step_number'] ?? 0)) <=> ((int)($b['step_number'] ?? 0)));
$step_texts = [];
foreach ($existing_steps as $step) {
    $step_texts[] = $step['instructions'] ?? '';
}
$steps_string = implode("\n", $step_texts);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $servings = (int)($_POST['servings'] ?? 1);
    $description = trim($_POST['description'] ?? '');
    $ingredients_input = trim($_POST['ingredients_list'] ?? '');
    $steps_input = trim($_POST['steps_list'] ?? '');
    $image_path = $recipe['image']; // Keep existing image by default

    // Optional secure image replacement upload
    if (isset($_FILES['recipe_image']) && $_FILES['recipe_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['recipe_image']['tmp_name'];
        $file_size = $_FILES['recipe_image']['size'];

        if ($file_size > 5 * 1024 * 1024) {
            $message = "⚠️ File is too large. Maximum size is 5MB.";
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file_tmp);
            finfo_close($finfo);

            $allowed_mimes = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp'
            ];

            if (array_key_exists($mime_type, $allowed_mimes)) {
                $ext = $allowed_mimes[$mime_type];
                $upload_dir = __DIR__ . '/uploads/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $new_filename = uniqid('recipe_', true) . '.' . $ext;
                $destination = $upload_dir . $new_filename;

                if (move_uploaded_file($file_tmp, $destination)) {
                    $image_path = 'uploads/' . $new_filename;
                } else {
                    $message = "❌ Failed to move uploaded file.";
                }
            } else {
                $message = "⚠️ Invalid file type. Only JPEG, PNG, and WebP images are allowed.";
            }
        }
    }

    if (empty($message) && !empty($title) && !empty($category) && !empty($description) && !empty($ingredients_input) && !empty($steps_input) && $servings > 0) {
        // Update database recipe record using prepared statement
        $stmt = mysqli_prepare($db, "UPDATE recipes SET title = ?, subtitle = ?, category = ?, servings = ?, description = ?, image = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "sssissi", $title, $subtitle, $category, $servings, $description, $image_path, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            // Update ingredients and steps CSV files
            update_csv_rows('recipes_data_ver8.xlsx - ingredients.csv', $id, $title, explode("\n", $ingredients_input), 'ingredients');
            update_csv_rows('recipes_data_ver8.xlsx - steps.csv', $id, $title, explode("\n", $steps_input), 'steps');

            header('Location: alpha.php');
            exit;
        } else {
            $message = "❌ Error updating recipe in database.";
        }
        mysqli_stmt_close($stmt);
    } elseif (empty($message)) {
        $message = "⚠️ Please fill in all required fields correctly.";
    }
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
        <form method="POST" action="edit.php?id=<?= $id ?>" enctype="multipart/form-data" class="add-form">
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
                <label>Description & Overview *</label>
                <textarea name="description" rows="3" required><?= htmlspecialchars($recipe['description']) ?></textarea>
            </div>

            <div class="form-group">
                <label>Ingredients (One per line) *</label>
                <textarea name="ingredients_list" rows="4" required><?= htmlspecialchars($ingredients_string) ?></textarea>
            </div>

            <div class="form-group">
                <label>Step-by-Step Instructions (One per line) *</label>
                <textarea name="steps_list" rows="5" required><?= htmlspecialchars($steps_string) ?></textarea>
            </div>

            <div class="form-group">
                <label>Replace Recipe Image (Leave blank to keep current)</label>
                <input type="file" name="recipe_image" accept=".jpg, .jpeg, .png, .webp">
            </div>

            <button type="submit" class="btn">💾 Update Recipe</button>
        </form>
    </div>
</body>
</html>