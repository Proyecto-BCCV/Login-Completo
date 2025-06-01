<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Recuperar Contraseña</h2>

        <form action="recuperar_clave.php" method="post">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Ingrese Email">
            </div>
            
            <input type="submit" value="Enviar">
        </form>

        <div class="register-section">
            <a href="login.php">¿Ya recordaste tu contraseña? Volver al login</a>
        </div>
    </div>

    <?php 
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        //Conexion con la base
        $conex = mysqli_connect("localhost", "root", "", "nusuario");

        $email = mysqli_real_escape_string($conex, $_POST['email']);
        $c = "SELECT *, IFNULL(email, 'registronuevo') as email FROM registronuevo WHERE email='$email' LIMIT 1";
        $f = mysqli_query($conex, $c);
        $a = mysqli_fetch_assoc($f);
        if (!$a) {
            $_SESSION['error'] = 'Usuario inexistente';
            echo '<div class="message-overlay"><div class="message bad">Usuario inexistente</div></div>';
            //header( "Location: ../" );
            die();
        }
        //generar una clave aleatoria y el token

        $token = md5($a['email'] . time() . rand(1000, 9999));
        $clave_nueva = rand(10000000, 99999999);
        $idusuario = $a['email'];
        $c2 = "INSERT INTO recuperar SET email='$email', TOKEN='$token', FECHA_ALTA=NOW(), CLAVE_NUEVA='$clave_nueva' ON DUPLICATE KEY UPDATE TOKEN='$token', CLAVE_NUEVA='$clave_nueva'";
        mysqli_query($conex, $c2);

        $link = "http://localhost/recuperar_clave_confirmar.php?e=$email&t=$token";

        //envío de mail
        $mensaje = <<<EMAIL
        <div style='font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: #e0e0e0; padding: 40px; border-radius: 16px; max-width: 600px; margin: 0 auto;'>
            <div style='background: #2a2a2a; border-radius: 12px; padding: 30px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4); border-top: 4px solid; border-image: linear-gradient(90deg, #d32f2f 0%, #ffd700 100%) 1;'>
                <h2 style='color: #ffffff; text-align: center; margin-bottom: 24px; font-size: 24px; font-weight: 600;'>Recuperación de Contraseña</h2>
                <p style='color: #e0e0e0; line-height: 1.6; margin-bottom: 16px;'>Hola <strong style='color: #ffd700;'>{$a['email']}</strong>,</p>
                <p style='color: #e0e0e0; line-height: 1.6; margin-bottom: 16px;'>Has solicitado recuperar tu contraseña. El sistema te ha generado una nueva clave temporal:</p>
                <div style='background: #1e1e1e; border: 2px solid #d32f2f; border-radius: 8px; padding: 16px; margin: 20px 0; text-align: center;'>
                    <code style='background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%); color: #ffffff; padding: 12px 20px; border-radius: 6px; font-family: "Courier New", monospace; font-size: 18px; font-weight: bold; letter-spacing: 1px;'>$clave_nueva</code>
                </div>
                <p style='color: #e0e0e0; line-height: 1.6; margin-bottom: 16px;'>Para activar tu nueva contraseña, debes hacer clic en el siguiente enlace:</p>
                <div style='text-align: center; margin: 24px 0;'>
                    <a href='$link' style='display: inline-block; background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%); color: #ffffff; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px; box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);'>Activar Nueva Contraseña</a>
                </div>
                <p style='color: #b0b0b0; font-size: 14px; margin-bottom: 16px;'>O copia y pega este enlace en tu navegador:</p>
                
                <div style='background: #000000; border-radius: 6px; padding: 12px; margin: 16px 0; word-break: break-all;'>
                    <code style='color: #ffd700; font-family: "Courier New", monospace; font-size: 12px;'>$link</code>
                </div>
                <div style='border-top: 1px solid #404040; padding-top: 20px; margin-top: 30px;'>
                    <p style='color: #666666; font-size: 13px; line-height: 1.5; text-align: center;'>
                        <strong>Nota de seguridad:</strong> Si tú no has solicitado este cambio de contraseña, puedes ignorar este mensaje. Tu cuenta permanecerá segura.
                    </p>
                </div>
            </div>
        </div>
        EMAIL;

        echo '<div class="email-preview">';
        echo '<h3>Instrucciones de recuperación:</h3>';
        echo $mensaje;
        echo '</div>';

        //enviar ese mail 
        //redireccionar al formulario....
    }
    ?>
</body>
</html>