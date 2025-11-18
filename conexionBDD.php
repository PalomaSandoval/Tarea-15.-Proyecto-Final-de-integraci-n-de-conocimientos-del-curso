<?php
    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "usuarios");

    $Usuario = $_POST['nombre']; 
    $Correo = $_POST['correo'];
    $Password = $_POST['contraseña']; 

    try {
        $consulta = "INSERT INTO usuarios (usuario, password, correo) VALUES ('$Usuario', '$Password', '$Correo')";
        
        $resultado_consulta = mysqli_query($conexion, $consulta);

        if (!$resultado_consulta) {
            throw new Exception(mysqli_error($conexion));
        }

        // echo $consulta; 

    } catch (Exception $e) {
        header("Location: Formulario.php?error=1");
        exit(); 
    }
    mysqli_close($conexion);
    header("Location: Formulario.php");
    exit();
?>