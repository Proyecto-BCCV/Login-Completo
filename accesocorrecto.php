<?php
/*
session_start();

// Redirect to login if session is not set
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
*/  
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>¡Bienvenido!</h2>
        
        <!-- Logout button -->
        <form method="post" action="logout.php" class="logout-form">
            <input type="submit" value="Cerrar sesión" class="logout-button">
        </form>
    </div>
</body>
</html>
