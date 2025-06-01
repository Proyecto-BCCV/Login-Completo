<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php
    //Conexion con la base
    $conex = mysqli_connect("localhost","root","","nusuario"); 
    ?>
    
    <div class="register-container">
        <h2>Crear Cuenta</h2>
        
        <form action="registrar.php" method="post">
            <div class="form-row">
                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                </div>
                <div class="input-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido">
                </div>
            </div>
            
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Tu Email">
            </div>
            
            <div class="input-group">
                <label for="User">Usuario</label>
                <input type="text" id="User" name="User" placeholder="Tu Usuario">
            </div>
            
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Contraseña">
            </div>
            
            <div class="input-group">
                <label for="Cpassword">Confirmar Contraseña</label>
                <input type="password" id="Cpassword" name="Cpassword" placeholder="Confirmar Contraseña">
            </div>
            
            <input type="submit" name="Enviar" value="Registrar">
        </form>
        
        <div class="register-section">
            <a href="recuperar_clave.php" target="_blank">Recuperar Contraseña</a>
        </div>
    </div>

    <?php    
    if(isset($_POST['Enviar'])) {
        if(strlen($_POST['nombre']) >= 1 && strlen($_POST['apellido'] >= 1 ) && strlen($_POST['email']) >= 1 && strlen($_POST['User']) >= 1 && strlen($_POST['password']) >= 1 && $_POST['password'] === $_POST['Cpassword']) {
            $nombre=trim($_POST['nombre']);
            $apellido=trim($_POST['apellido']);
            $email=trim($_POST['email']);
            $User=trim($_POST['User']);
            $password = $_POST['password'];
            $pass_cifrada = password_hash($password,PASSWORD_DEFAULT, array("cost"=>10));
            $consulta = "INSERT INTO registronuevo (nombre, apellido, email, user, pass) VALUES ('$nombre','$apellido','$email','$User','$pass_cifrada')";
            $resultado = mysqli_query($conex,$consulta);
            if ($resultado) {
                ?> 
                    <div class="message-overlay">
                        <div class="message ok">¡Te has inscripto correctamente!</div>
                    </div>
                    <script>
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 3000);
                    </script>
                <?php
            } else {
                ?> 
                <div class="message-overlay">
                    <div class="message bad">¡Ups ha ocurrido un error!</div>
                </div>
               <?php
            }
        }   else {
                ?> 
                <div class="message-overlay">
                    <div class="message bad">¡Por favor complete los campos!</div>
                </div>
               <?php           
        }
    }
    ?>
</body>
</html>