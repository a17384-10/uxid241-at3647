<?php
declare(strict_types=1);

<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/db.php';

session_start();
$_SESSION = [];
session_destroy();

// redirect back to public page
header('Location: alpha.php');
exit;

// used ai for this whole page