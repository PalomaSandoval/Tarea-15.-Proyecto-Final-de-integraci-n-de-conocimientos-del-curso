<?php
    session_start(); 

    // Si tien SESIÓN O tienes COOKIE
    if(isset($_SESSION["usuario"]) || isset($_COOKIE["usuario_autenticado"])){ 
        header("Location: ../Bienvenida.php"); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>
    
<h2>Inicio de Sesión</h2>
<form action="autenticar.php" method="post">

    <label for="correo">Correo Electrónico: </label>
    <input type="email" id="correo" name="correo" 
       value="<?php if(isset($_COOKIE['correo_recordado'])) echo htmlspecialchars($_COOKIE['correo_recordado']); ?>" required>
   
    <label for="Contrasena">Contraseña: </label>
    <input type="password" id="Contrasena" name="Contrasena" required>

    <input type="submit" value="Iniciar sesión">

    <div class="checkbox-container">
        <input type="checkbox" ... <?php if(isset($_COOKIE['correo_recordado'])) echo "checked"; ?>>    
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