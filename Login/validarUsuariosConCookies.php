<?php
    // valida si existen los archivos q quieren iniciar sesion, tbm valida las cookies


    // si ya hay cookies 
    if(isset($_COOKIE["correo"]) && isset($_COOKIE["contraseña"])){
        header("Location: ../PaginaPrincipalBienvenida.php");
        exit();
    }

    // Si no hay cookies,
    if(isset($_POST['correo']) && isset($_POST['Contrasena'])) { 
        
        // Conexión a la BD
        $conexion = mysqli_connect("localhost", "root", "", "proyectofinal"); 

        $Correo = $_POST['correo']; 
        $Password = $_POST['Contrasena']; 
        
        $consulta = "SELECT * FROM usuarios WHERE Correo = '$Correo' AND password = '$Password'";       
        $resultado = mysqli_query($conexion, $consulta);
        
        $usuariosEncontrados = mysqli_num_rows($resultado);
        
        if ($usuariosEncontrados > 0) {
            
            // Si encontró al usuario
            $EncontroUsuario = mysqli_fetch_assoc($resultado);
            $NombreDelUsuario = $EncontroUsuario['Nombre'];            
            // Botón de Recordarme
            if (isset($_POST["recordarme"])){ 
                setcookie("correo", $Correo, time()+120, "/");  //nomas tiene 2minutos
                setcookie("contraseña", $Password, time()+120, "/");
                setcookie("nombreUsuario", $NombreDelUsuario, time()+120, "/"); 
            }

            header("Location: ../PaginaPrincipalBienvenida.php");
            exit();

        } else {
            header("Location: loginInicioSesion.php?error=1");
            exit();
        }

        mysqli_close($conexion);
    } else {
        // Si entra sin datos
        header("Location: loginInicioSesion.php");
        exit();
    }
?>