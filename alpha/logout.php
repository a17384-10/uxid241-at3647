<?php
declare(strict_types=1);

session_start();
$_SESSION = [];
session_destroy();

// redirect back to public page
header('Location: alpha.php');
exit;

// used ai for this whole page