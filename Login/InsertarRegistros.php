<?php

    //Archivo para registrar usarios nuevos de la BDD en el login ya que usa Insert Into
    //trabaja en conjunto con el archivo FormularioRegistroUsuarios.php


    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");

    $Usuario = $_POST['nombre']; 
    $Correo = $_POST['correo'];
    $Password = $_POST['contraseña']; 

    try {
        $consulta = "INSERT INTO usuarios (Nombre, password, Correo) VALUES ('$Usuario', '$Password', '$Correo')";        
        $resultado_consulta = mysqli_query($conexion, $consulta);

        if (!$resultado_consulta) {
            throw new Exception(mysqli_error($conexion));
        }

        // echo $consulta; 

    } catch (Exception $e) {
        header("Location: FormularioRegistroUsuarios.php?error=1");
        exit(); 
    }
    mysqli_close($conexion);
    header("Location: loginInicioSesion.php");
    exit();
?>