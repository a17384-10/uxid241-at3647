<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

$error_message = '';
$recipes = [];

try {
    $pdo_or_conn = get_db_connection();
    
    // Since this list-all query takes no user input, mysqli_query is acceptable here.
    $sql = "SELECT id, title, description, prep_time_minutes, created_at FROM recipes ORDER BY created_at DESC";
    $result = $pdo_or_conn->query($sql);
    
    // Fetch all rows into an associative array
    $recipes = $result->fetch_all(MYSQLI_ASSOC);
    
    $pdo_or_conn->close();
} catch (mysqli_sql_exception $e) {
    // Log the actual error internally in production, show a friendly message to the user
    $error_message = 'Could not load recipes at this time. Please try again later.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cookbook - Recipes</title>
    <style>
        body { 
            font-family: sans-serif; 
            max-width: 800px; 
            margin: 40px auto; 
            padding: 0 20px; 
            line-height: 1.6; 
            color: #333; 
        }
        
        .recipe-card { 
            border: 1px solid #ffecffff; 
            border-radius: 6px; 
            padding: 20px; 
            margin-bottom: 20px; 
            background: #eefffdff; 
        }

        .recipe-card h2 { 
            margin-top: 0; 
            color: #e404acff; 
        }

        .meta { 
            font-size: 0.9rem; 
            color: #980f71ff; 
            margin-bottom: 10px; 
        }
        
        .error { 
            color: #c02b2bff; 
            background: #fad8d8ff; 
            padding: 10px; 
            border-radius: 4px; 
        }
    </style>
</head>
<body>

    <h1>Welcome to My Cookbook</h1>
    <p>check out some recipes below!</p>

    <?php if (!empty($error_message)): ?>
        <div class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php elseif (empty($recipes)): ?>
        <p>No recipes found in the database yet.</p>
    <?php else: ?>

        <div class="recipe-list">
            <?php foreach ($recipes as $recipe): ?>
                <div class="recipe-card">
                    <h2><?php echo htmlspecialchars($recipe['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <div class="meta">
                        Prep Time: <?php echo htmlspecialchars((string)$recipe['prep_time_minutes'], ENT_QUOTES, 'UTF-8'); ?> minutes | 
                        Added: <?php echo htmlspecialchars($recipe['created_at'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <p><?php echo nl2br(htmlspecialchars($recipe['description'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</body>
</html>