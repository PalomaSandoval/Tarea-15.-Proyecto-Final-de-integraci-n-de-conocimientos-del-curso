<?php
    session_start();
    
    session_unset();
    
    session_destroy();
    
    if (isset($_COOKIE['usuario'])) {
        setcookie("usuario", "", time() - 3600, "/");
        setcookie("correo", "", time() - 3600, "/");
    }

    header("Location: loginInicioSesion.php");
    exit();
?>