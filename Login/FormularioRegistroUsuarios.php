<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    
    <h2>Registro de Usuarios</h2>
    
    <form action="InsertarRegistros.php" method="post">

        <label for="nombre">Nombre de Usuario: </label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="correo">Correo Electrónico: </label>
        <input type="email" id="correo" name="correo" required> 

        <label for="contraseña">Contraseña: </label>
        <input type="password" id="contraseña" name="contraseña" required>

        <input type="submit" value="Registrarse">
       
        <div>
        <p>¿Ya tienes una cuenta?</p>
        <a href="loginInicioSesion.php">Inicia Sesión</a>
        </div>
    </form>

</body>
</html>