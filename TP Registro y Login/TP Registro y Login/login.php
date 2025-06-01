<?php
// Merged login.php and inicio_sesion.php
session_start();
include('config.php');

//Conexion con la base
$conex = mysqli_connect("localhost","root","","nusuario"); 

// Google OAuth callback handling
if (isset($_GET["code"])) {
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if (!isset($token['error'])) {
        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
            $_SESSION['nombre'] = $data['given_name']; // For accesocorrecto.php
        }
        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }
        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
            $_SESSION['email'] = $data['email']; // For accesocorrecto.php
        }

        header("Location: accesocorrecto.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
}

// Create styled Google login button
$login_button = '<a href="' . $google_client->createAuthUrl() . '" class="google-login-btn">
    <img src="images/google_logo.png" alt="Google" class="google-icon"> 
    <span>Continuar con Google</span>
</a>';

// Process traditional login form
if(isset($_POST['Enviar'])) {
    $identificador = trim($_POST['identificador']);
    $password = $_POST['password'];
    
    // Verificar si el identificador es un email o un nombre de usuario
    if(filter_var($identificador, FILTER_VALIDATE_EMAIL)) {
        // Buscar por email
        $consulta = "SELECT * FROM registronuevo WHERE email = ?";
    } else {
        // Buscar por nombre de usuario
        $consulta = "SELECT * FROM registronuevo WHERE user = ?";
    }
    
    // Preparar la consulta para evitar inyección SQL
    $stmt = mysqli_prepare($conex, $consulta);
    mysqli_stmt_bind_param($stmt, "s", $identificador);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);
        
        // Verificar contraseña
        if(password_verify($password, $usuario['pass'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION["usuario"] = $usuario['user'];
            $_SESSION["nombre"] = $usuario['nombre']; // For accesocorrecto.php
            $_SESSION["email"] = $usuario['email']; // For accesocorrecto.php
            
            // Redireccionar a la página de acceso correcto
            header("Location: accesocorrecto.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "<div class='message-overlay'><div class='message bad'>Contraseña incorrecta.</div></div>";
        }
    } else {
        // Usuario o email no encontrado
        echo "<div class='message-overlay'><div class='message bad'>Usuario o email no encontrado.</div></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Link to your CSS file - adjust path as needed -->
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <!-- Traditional login form -->
        <form action="" method="post">
            <div class="input-group">
                <label for="identificador">Usuario o Email</label>
                <input type="text" id="identificador" name="identificador" placeholder="Ingresar usuario o email">
            </div>
            
            <div class="input-group">
                <label for="password">Contraseña</label>
                <div class="password-input-container">
                    <input type="password" id="password" name="password" placeholder="Ingrese Contraseña">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                    <span class="eye-icon eye-visible" id="eyeIcon"></span>
                    </button>
                </div>
            </div>
            
            <input type="submit" name="Enviar" value="Iniciar Sesión">
        </form>

        <a href="recuperar_clave.php" class="forgot-password" target="_blank">Recuperar Contraseña</a>

        <!-- Google login button -->
        <div class="social-login">
            <p>O inicia sesión con:</p>
            <?php echo $login_button; ?>
        </div>

        <div class="register-section">
            <a href="registrar.php">¿No tienes cuenta? Regístrate aquí</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'eye-icon eye-hidden';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'eye-icon eye-visible';
            }
        }
    </script>
</body>
</html>