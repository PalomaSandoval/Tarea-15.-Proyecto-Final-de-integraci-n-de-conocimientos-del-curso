<?php
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");

    // borrar
    if (isset($_GET['borrar'])) {
        $id_borrar = $_GET['borrar'];
        
        $sql = "DELETE FROM miembros WHERE id = '$id_borrar'";
        mysqli_query($conexion, $sql);

        // lista
        header("Location: ListaMiembros.php?mensaje=borrado");
        exit();
    }

    // actualizar
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $id = $_POST['id']; // ID oculto
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $sexo = $_POST['sexo'];
        $tipo_membresia = $_POST['tipo_membresia'];
        
        // Recalcular costo
        $costo = 0;
        if ($tipo_membresia == 'Mensual') $costo = 500;
        elseif ($tipo_membresia == '3 Meses') $costo = 1250;
        elseif ($tipo_membresia == '6 Meses') $costo = 2500;
        elseif ($tipo_membresia == '1 Año') $costo = 4500;

        // Update
        $sql = "UPDATE miembros SET 
                nombre='$nombre', 
                apellidos='$apellidos', 
                telefono='$telefono', 
                fecha_nacimiento='$fecha_nacimiento', 
                sexo='$sexo', 
                tipo_membresia='$tipo_membresia',
                costo='$costo'
                WHERE id='$id'";

        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            header("Location: ListaMiembros.php?mensaje=actualizado");
        } else {
            echo "Error al actualizar: " . mysqli_error($conexion);
        }
        exit();
    }

    mysqli_close($conexion);
?>