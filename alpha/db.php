<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// require the config array
$config = require_once __DIR__ . '/config.php';

// enable strict error reporting for mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // connect using the values from the returned array (with MAMP port support)
    $db = mysqli_connect(
        $config['host'], 
        $config['username'], 
        $config['password'], 
        $config['database'], 
        (int)$config['port']
    );
    mysqli_set_charset($db, 'utf8mb4');
} catch (mysqli_sql_exception $e) {
    exit("Database connection failed: " . htmlspecialchars($e->getMessage()));
}