<?php
    session_start(); // Necesario para poder destruir la sesión

    session_unset();
    session_destroy();

    setcookie("usuario_autenticado", "", time() - 3600, "/");
    setcookie("correo_recordado", "", time() - 3600, "/");
    
    setcookie("usuario", "", time() - 3600, "/");
    setcookie("correo", "", time() - 3600, "/");

    header("Location: Login/login.php");
    exit();
?>