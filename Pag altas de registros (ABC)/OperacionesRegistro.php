<?php
    // Conexión 
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");

    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: FormularioAlta.php");
        exit();
    }

    //  datos de la bdd
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    $tipo_membresia = $_POST['tipo_membresia'];
    $fecha_pago = $_POST['fecha_pago'];

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
        header("Location: FormularioAlta.php?estatus=ok");
    } else {
        echo " " . mysqli_error($conexion);
    }
    
    mysqli_close($conexion);
?>