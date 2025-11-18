<?php
    //este archivo funciona para el login, para iniciar sesion con
    //el usuario/contraseña
    //y tambien para manejar las cookies si es que ya habia iniciado sesion antes
    
    // validar usuarios Cookies con Base de Datos



    //Si ya existen cookies, es un autologin
    if(isset($_COOKIE["usuario"]) && isset($_COOKIE["password"])){
        header("Location: PaginaPrincipalBienvenida.php");
        exit();
    }

    // Si no existen las cookies, se verifica  si mandó el formulario con post
    if(isset($_POST['usuario']) && isset($_POST['contraseña'])) { 
        
        // Conexión a la BD
        $conexion = mysqli_connect("localhost", "root", "", "proyectofinal"); 

        $Usuario = $_POST['usuario'];
        $Password = $_POST['contraseña'];

        // consulta con select a la bdd
        $consulta = "SELECT * FROM usuarios WHERE usuario = '$Usuario' AND password = '$Password'";
        $resultado = mysqli_query($conexion, $consulta);
        
        // si se encontro un usuario
        $usuariosEncontrados = mysqli_num_rows($resultado);
        if ($usuariosEncontrados > 0) {
            //botón de Recordarme
            if (isset($_POST["recordarme"])){
                // las cookies por 1 día (60*60*24)
                setcookie("usuario", $Usuario, time()+86400, "/");
                setcookie("password", $Password, time()+86400, "/");
            }

            header("Location: PaginaPrincipalBienvenida.php");
            exit();

        } else {
            header("Location: login.php?error=1");
            exit();
        }

        mysqli_close($conexion);
    } else {
        header("Location: login.php");
        exit();
    }
?>