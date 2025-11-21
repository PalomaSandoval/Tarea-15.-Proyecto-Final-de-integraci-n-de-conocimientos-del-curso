<?php
    session_start();

    if(isset($_SESSION["usuario"])){
        header("Location: ../PaginaPrincipalBienvenida.php");
        exit();
    }

    if(isset($_POST['correo']) && isset($_POST['Contrasena'])) { 
        
        // Conexión a la BD
        $conexion = mysqli_connect("localhost", "root", "", "proyectofinal"); 

        $Correo = $_POST['correo']; 
        $Password = $_POST['Contrasena']; 
        
        // Buscamos al usuario
        $consulta = "SELECT * FROM usuarios WHERE Correo = '$Correo' AND password = '$Password'";       
        $resultado = mysqli_query($conexion, $consulta);
        
        $usuariosEncontrados = mysqli_num_rows($resultado);
        
        if ($usuariosEncontrados > 0) {
            
            // Si encontró al usuario
            $EncontroUsuario = mysqli_fetch_assoc($resultado);
            $NombreDelUsuario = $EncontroUsuario['Nombre'];            

            
            $_SESSION["usuario"] = $NombreDelUsuario;
            $_SESSION["correo"] = $Correo;

            if (isset($_POST["recordarme"])){ 
                setcookie("correo", $Correo, time()+120, "/");  
                
            }

            //bienvenida
            header("Location: ../PaginaPrincipalBienvenida.php");
            exit();

        } else {
            header("Location: loginInicioSesion.php?error=1");
            exit();
        }

        mysqli_close($conexion);
    } else {
        // Si entra sin datos y sin sesión
        header("Location: loginInicioSesion.php");
        exit();
    }
?>