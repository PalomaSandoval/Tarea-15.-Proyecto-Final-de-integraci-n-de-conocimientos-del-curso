<?php

//Validar el inicio de sesion de los usuarios 
    session_start();

    if(isset($_SESSION["usuario"])){
        header("Location: ../Bienvenida.php");
        exit();
    }

    if(isset($_POST['correo']) && isset($_POST['Contrasena'])) { 
        
        //  base
        $conexion = mysqli_connect("localhost", "root", "", "proyectofinal"); 

        $Correo = $_POST['correo']; 
        $Password = $_POST['Contrasena']; 
        
        //  select
        $consulta = "SELECT * FROM usuarios WHERE Correo = '$Correo' AND password = '$Password'";       
        $resultado = mysqli_query($conexion, $consulta);
        
        if ($EncontroUsuario = mysqli_fetch_array($resultado)) {
            
            $NombreDelUsuario = $EncontroUsuario['Nombre'];            
            $_SESSION["usuario"] = $NombreDelUsuario;
            $_SESSION["correo"] = $Correo;

            if (isset($_POST["recordarme"])){ 
                setcookie("correo", $Correo, time()+120, "/");
                
                setcookie("usuario", $NombreDelUsuario, time()+120, "/"); 
                
            }

            header("Location: ../Bienvenida.php");
            exit();

        } else {
            header("Location: loginInicioSesion.php?error=1");
            exit();
        }

        mysqli_close($conexion);

    } else {
        header("Location: loginInicioSesion.php");
        exit();
    }
?>