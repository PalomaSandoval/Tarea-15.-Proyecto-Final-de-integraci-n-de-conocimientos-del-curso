<?php
    if(!isset($_COOKIE["usuario_autenticado"])){ 
        header("Location: Login/login.php"); 
        exit();
    }
    
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GYM RAT</title>

</head>
<body>

    <div class="contenedor">
        <p>Sistema de Control del Gym.</p>
        <hr>

        <a href="formsABC/formAltaMiembro.php" class="btn">Registrar Nuevo Cliente</a>

        <a href="formsABC/formConsultas.php" class="btn">Ver Lista de Miembros</a>

        <a href="Descargas.php" class="btn">Ir a Descargas</a>

        <hr>
        <a href="CerrarSesion.php" class="btn btn-rojo">Cerrar Sesión</a>
    </div>

</body>
</html>