<?php
    session_start(); 

    // ¿No hay sesión ni cookies? ¡Vámonos al login!
    if (!isset($_SESSION["usuario"]) && !isset($_COOKIE["usuario_autenticado"])) {
        header("Location: Login/login.php"); 
        exit();
    }
    
    // Si hay cookie y no sesión, abrimos la sesión
    if (!isset($_SESSION["usuario"]) && isset($_COOKIE["usuario_autenticado"])) {
        $_SESSION["usuario"] = $_COOKIE["usuario_autenticado"];
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GYM RAT - Inicio</title>

    <style>
    /* --- ESTILOS BELICOSOS --- */

    /* 1. BASE */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f3f4f6; 
        color: #1f2937;
        margin: 0;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    /* 2. TÍTULOS */
    h1, h2, h3 {
        font-weight: 800;
        color: #111827;
        margin-bottom: 10px; /* Menos margen porque abajo va el subtítulo */
        letter-spacing: -0.03em;
        text-align: center;
    }

    /* 3. ESTILO PARA EL TEXTO QUE SE VEÍA PLANO (NUEVO) */
    .texto-destacado {
        font-size: 1.1rem;
        font-weight: 500;
        color: #6b7280; /* Gris elegante */
        text-align: center;
        margin-top: 0;
        margin-bottom: 30px;
        border-bottom: 2px solid #f3f4f6;
        padding-bottom: 20px;
    }

    /* 4. CONTENEDORES */
    .contenedor {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        width: 100%;
        max-width: 480px;
        box-sizing: border-box;
        border: 1px solid #f3f4f6;
    }

    /* 5. BOTONES */
    .btn {
        width: 100%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 16px 24px;
        margin-top: 16px; /* Separación entre botones */
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
        background-color: #111827;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.1s, background-color 0.2s;
        box-sizing: border-box;
    }

    .btn:hover {
        background-color: #000000;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Botón Rojo (Cerrar Sesión) */
    .btn-rojo { 
        background-color: #ffffff;
        color: #dc2626;
        border: 2px solid #f3f4f6;
        margin-top: 12px;
        box-shadow: none;
    }

    .btn-rojo:hover {
        background-color: #fef2f2;
        border-color: #fee2e2;
        color: #991b1b;
        transform: translateY(-1px);
    }

    /* Detalles */
    hr {
        border: 0;
        height: 1px;
        background: #e5e7eb;
        margin: 30px 0;
    }
    </style>

</head>
<body>

    <div class="contenedor">
        <h1>GYM RAT</h1>
        
        <p class="texto-destacado">Sistema de Control</p>
        

        <a href="formsABC/formAltaMiembro.php" class="btn">Registrar Nuevo Cliente</a>

        <a href="formsABC/formConsultas.php" class="btn">Ver Lista de Miembros</a>

        <a href="Descargas.php" class="btn">Ir a Descargas</a>

        <hr>
        <a href="CerrarSesion.php" class="btn btn-rojo">Cerrar Sesión</a>
    </div>

</body>
</html>