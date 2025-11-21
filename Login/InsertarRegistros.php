<?php
    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");

    $Usuario = $_POST['nombre']; 
    $Correo = $_POST['correo'];
    $Password = $_POST['contraseña']; 
   
    $duplicadoDeUsuarios = "SELECT * FROM usuarios WHERE Correo = '$Correo' OR Nombre = '$Usuario'";
    $resultadoD = mysqli_query($conexion, $duplicadoDeUsuarios);

    if ($yaExiste = mysqli_fetch_array($resultadoD)) {
        
        header("Location: FormularioRegistroUsuarios.php?error=repetido");
        exit(); 
    }

    try {
        // insertamos
        $consulta = "INSERT INTO usuarios (Nombre, password, Correo) VALUES ('$Usuario', '$Password', '$Correo')";        
        $resultado_consulta = mysqli_query($conexion, $consulta);

        if (!$resultado_consulta) {
            throw new Exception(mysqli_error($conexion));
        }

    } catch (Exception $e) {
        header("Location: FormularioRegistroUsuarios.php?error=1");
        exit(); 
    }
    
    mysqli_close($conexion);
    header("Location: loginInicioSesion.php");
    exit();
?>