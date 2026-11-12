<?php
declare(strict_types=1);

function sanitize_output(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$error = '';
$recipe_name = '';
$is_submitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $is_submitted = true;

    // extracts and sanitizes the recipe name from the POST request
    $recipe_name = trim($_POST['recipe_name'] ?? '');

    // checks if the box was left empty or if the recipe name is within the rules
    if ($recipe_name === '') {
        $error = 'Recipe name is required.';
    } elseif (mb_strlen($recipe_name) < 3 || mb_strlen($recipe_name) > 100) {
        $error = 'Recipe name must be between 3 and 100 characters long.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cookbook - Add Recipe</title>
</head>
<body>
  <h1>Cookbook: Add New Recipe</h1>
 
  <!-- AI used for the following code: Gemini -->
  <?php if ($is_submitted && $error === ''): ?>
    <div style="padding: 10px; background-color: #ffd2f2ff; border: 1px solid #ae0071ff; margin-bottom: 20px;">
      <p><strong>Success!</strong> Saved recipe: <?= sanitize_output($recipe_name) ?></p>
    </div>
  <?php endif; ?>

  <form method="POST" action="">
    <div>
      <label for="recipe_name">Recipe Name:</label><br>
      <input 
        type="text" 
        id="recipe_name" 
        name="recipe_name" 
        value="<?= sanitize_output($recipe_name) ?>"
      >
      <?php if ($error !== ''): ?>
        <p style="color: red; margin: 5px 0 0;"><?= sanitize_output($error) ?></p>
      <?php endif; ?>
    </div>

    <br>

    <button type="submit">Add Recipe</button>
  </form>
</body>
</html>