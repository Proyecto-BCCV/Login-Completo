<?php
// Conexion con la base
include ('dbcon.php'); 

// Obtener las credenciales del formulario
$password = $_POST['pass'];
$usuario = $_POST['user'];

// Verificar si el usuario existe en la base de datos
$sql = "SELECT * FROM registronuevo WHERE user = '$usuario'";
$result = mysqli_query($conex, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['pass'];

    if (password_verify($password, $hashedPassword)) {
        // Contraseña correcta, iniciar sesión
    
        session_start();
        $_SESSION["usuario"] = $usuario;
        header("Location: accesocorrecto.php");
    } else {
        // Contraseña incorrecta
        echo "Contraseña incorrecta.";
    }
} else {
    // Usuario inexistente
    echo "Usuario inexistente.";
}

mysqli_close($conex);
?>
