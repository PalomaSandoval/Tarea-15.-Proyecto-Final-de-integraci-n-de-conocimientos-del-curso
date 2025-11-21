<?php
    session_start();

    // Si no hay usuario logueado
    if(!isset($_SESSION["usuario"])){ 
        header("Location: Login/loginInicioSesion.php");
        exit();
    }
    
    $usuario = $_SESSION["usuario"];
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

        <a href="Pag altas de registros (ABC)/FormularioAlta.php" class="btn">Registrar Nuevo Cliente</a>

        <a href="Pag Consultas (ABC)/ListaMiembros.php" class="btn">Ver Lista de Miembros</a>

        <a href="Descargas.php" class="btn">Ir a Descargas</a>

        <hr>
        <a href="CerrarSesion.php" class="btn btn-rojo">Cerrar Sesión</a>
    </div>

</body>
</html>