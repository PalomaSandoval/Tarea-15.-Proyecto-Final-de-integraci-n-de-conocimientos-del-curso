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

    $nombreUsuario = $_SESSION["usuario"]; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GYM RAT - Panel Principal</title>

    <style>
    /* --- ESTILO "MASTER CLASS" LIMPIO --- */

    /* 1. ESTRUCTURA PRINCIPAL */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background: linear-gradient(135deg, #f3f4f6 0%, #d1d5db 100%);
        color: #1f2937;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column; 
        align-items: center;
        min-height: 100vh;
    }

    /* 2. LA BARRA DE ARRIBA */
    header.barra-superior {
        width: 100%;
        background-color: #111827; 
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); 
        position: fixed; 
        top: 0;
        z-index: 1000;
    }

    .logo-navbar {
        height: 45px;
        width: auto;
        object-fit: contain;
        filter: brightness(0) invert(1);
        transition: opacity 0.2s;
    }
    .logo-navbar:hover { opacity: 0.8; }

    /* 3. LA TARJETA CENTRAL (LIMPIA TOTALMENTE) */
    .dashboard-card {
        background-color: #ffffff;
        padding: 40px 50px;
        border-radius: 20px;
        
        /* Sin sombras pesadas, solo un borde fino */
        box-shadow: none; 
        border: 1px solid #e5e7eb; 

        width: 90%;
        max-width: 500px;
        text-align: center;
        
        /* AQUÍ BORRAMOS LA LÍNEA AZUL (border-top) */
        border-top: none; 

        margin-top: 110px; 
        margin-bottom: 40px;
        position: relative;
    }

    /* 4. EL LOGO DEL PANEL */
    .logo-panel {
        width: 160px; 
        height: 160px;
        object-fit: contain;
        margin: 0 auto 10px auto;
        display: block;
        filter: drop-shadow(0 10px 10px rgba(0,0,0,0.2)); 
        background-color: transparent; 
        border: none;
        border-radius: 0;
        padding: 0;
    }

    /* 5. TEXTOS */
    h1 {
        font-weight: 900;
        font-size: 2rem;
        color: #111827;
        margin: 10px 0 5px 0;
        letter-spacing: -0.02em;
    }

    p.bienvenida {
        font-size: 1rem;
        color: #6b7280;
        margin-bottom: 30px;
        font-weight: 500;
    }

    /* 6. MENU DE BOTONES */
    .menu-opciones {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-menu {
        display: flex;
        align-items: center;
        padding: 16px 24px;
        background-color: #f9fafb;
        color: #1f2937;
        text-decoration: none;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .btn-menu:hover {
        background-color: #ffffff;
        border-color: #4f46e5;
        color: #4f46e5;
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1);
    }

    .icono { font-size: 1.4rem; margin-right: 15px; }

    /* Botón Salir */
    .btn-salir {
        margin-top: 25px;
        display: inline-block;
        color: #ef4444;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 20px;
        border-radius: 50px;
        border: 1px solid transparent;
        transition: all 0.2s;
    }
    .btn-salir:hover { background-color: #fef2f2; border-color: #fee2e2; color: #b91c1c; }

    </style>
</head>
<body>

    <header class="barra-superior">
        <img src="img/logo.png" alt="Gym Rat" class="logo-navbar">
    </header>

    <div class="dashboard-card">
        
        <img src="img/logo.png" alt="Logo Central" class="logo-panel">
        
        <h1>GYM RAT</h1>
        <p class="bienvenida">Panel de Control </p>

        <div class="menu-opciones">
            
            <a href="formsABC/formAltaMiembro.php" class="btn-menu">
                <span class="icono">💪</span> Registrar Nuevo Cliente
            </a>

            <a href="formsABC/formConsultas.php" class="btn-menu">
                <span class="icono">📋</span> Ver Lista de Miembros
            </a>

            <a href="Descargas.php" class="btn-menu">
                <span class="icono">📂</span> Galeria de Nuestros Miembros
            </a>

        </div>

        <a href="CerrarSesion.php" class="btn-salir">Cerrar Sesión 🔐</a>
    </div>

</body>
</html>