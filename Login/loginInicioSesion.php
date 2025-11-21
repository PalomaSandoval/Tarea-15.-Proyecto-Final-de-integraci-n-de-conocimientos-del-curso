<?php
session_start();

if(isset($_SESSION["usuario"])){ 
    header("Location: ../Bienvenida.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>
    
<h2>Inicio de Sesión</h2>
<form action="validarUsuariosConCookies.php" method="post">

    <label for="correo">Correo Electrónico: </label>
    <input type="email" id="correo" name="correo" 
           value="<?php if(isset($_COOKIE['correo'])) echo $_COOKIE['correo']; ?>" required> 

    <label for="Contrasena">Contraseña: </label>
    <input type="password" id="Contrasena" name="Contrasena" required>

    <input type="submit" value="Iniciar sesión">

    <div class="checkbox-container">
        <input type="checkbox" id="recordar" name="recordarme" <?php if(isset($_COOKIE['correo'])) echo "checked"; ?>> 
        <label for="recordarme">Recordar usuario</label>
    </div>



    <div class="error-message">
        <?php
        if(isset($_GET['error']) && $_GET['error'] == 1) { 
            echo "Correo o contraseña incorrectos"; 
        }
        ?>
    </div>
</form>

</body>
</html>