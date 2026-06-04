<?php
$timeout_duration = 900;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    if (!isset($_SESSION['last_activity'])) {
        $_SESSION['last_activity'] = time();
    }
    $elapsed = time() - $_SESSION['last_activity'];
    if ($elapsed > $timeout_duration) {
        session_unset();
        session_destroy();
        header('Location: /finalphpproject/pages/login.php?timeout=1');
        exit;
    }
    $_SESSION['last_activity'] = time();
}
