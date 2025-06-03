<?php
// logout.php
session_start();

// Include Google config if Google session exists
if (isset($_SESSION['access_token'])) {
    include('config.php');
    $google_client->revokeToken();
}

// Destroy all session data
session_unset();
session_destroy();

// Redirect to login page (or home)
header('Location: login.php');
exit();
?>
