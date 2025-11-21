<?php
    session_start();

    if(isset($_SESSION["usuario"])){
        header("Location: ../Bienvenida.php");
        exit();
    }

    if(isset($_COOKIE["usuario_autenticado"])){
        $_SESSION["usuario"] = $_COOKIE["usuario_autenticado"]; // Revivimos la sesión
        header("Location: ../Bienvenida.php");
        exit();
    }

    if(isset($_POST['correo']) && isset($_POST['Contrasena'])) { 
        
        $conexion = mysqli_connect("localhost", "root", "", "proyectofinal"); 

        $Correo = mysqli_real_escape_string($conexion, $_POST['correo']); 
        $Password = mysqli_real_escape_string($conexion, $_POST['Contrasena']); 
        
        $consulta = "SELECT * FROM usuarios WHERE Correo = '$Correo' AND password = '$Password'";       
        $resultado = mysqli_query($conexion, $consulta);
        
        if ($EncontroUsuario = mysqli_fetch_array($resultado)) {
            
            $NombreDelUsuario = $EncontroUsuario['Nombre'];            


            $_SESSION["usuario"] = $NombreDelUsuario;
            
            // COOKIE Solo si se puso "Recordarme" 
            setcookie("usuario_autenticado", $NombreDelUsuario, time() + 60, "/");
            
            // Cookie del correo 
            if (isset($_POST["recordarme"])){ 
                setcookie("correo_recordado", $Correo, time() + 60, "/");
            }

            header("Location: ../Bienvenida.php");
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