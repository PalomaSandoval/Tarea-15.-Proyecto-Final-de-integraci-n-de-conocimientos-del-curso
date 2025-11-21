<?php
    // Conexión
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");

    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: formAltaMiembro.php");
        exit();
    }


    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $fecha_nacimiento = mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento']);
    $sexo = mysqli_real_escape_string($conexion, $_POST['sexo']);
    $tipo_membresia = mysqli_real_escape_string($conexion, $_POST['tipo_membresia']);
    $fecha_pago = mysqli_real_escape_string($conexion, $_POST['fecha_pago']);

    // Calcular costo 
    $costo = 0;
    if ($tipo_membresia == 'Mensual') $costo = 500;
    elseif ($tipo_membresia == '3 Meses') $costo = 1250;
    elseif ($tipo_membresia == '6 Meses') $costo = 2500;
    elseif ($tipo_membresia == '1 Año') $costo = 4500;

    // Insertar (SQL)
    $consulta = "INSERT INTO miembros (nombre, apellidos, telefono, fecha_nacimiento, sexo, fecha_pago, tipo_membresia, costo) 
                 VALUES ('$nombre', '$apellidos', '$telefono', '$fecha_nacimiento', '$sexo', '$fecha_pago', '$tipo_membresia', '$costo')";

    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        // Regresamos al formulario 
        header("Location: formAltaMiembro.php?estatus=ok");
    } else {
        echo "erro" . mysqli_error($conexion);
    }
    
    mysqli_close($conexion);
?>