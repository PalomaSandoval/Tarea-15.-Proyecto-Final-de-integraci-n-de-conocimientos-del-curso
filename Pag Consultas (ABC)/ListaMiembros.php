<?php
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");

    $where = "";
    $busqueda = "";

    // Lógica del buscador
    if (isset($_POST['buscar'])) {
        $busqueda = $_POST['caja_busqueda'];
        $where = "WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'";
    }

    $sql = "SELECT * FROM miembros $where";
    $resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista Miembros</title>
</head>
<body>

    <h1>Administración y Consultas</h1>

    <a href="../Pag altas de registros (ABC)/FormularioAlta.php"><button type="button">+ Nuevo Registro</button></a>
    <hr>
    
    <?php
        if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'borrado') echo "Eliminado correctamente";
        if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'actualizado') echo "Datos actualizados";
    ?>

    <form action="ListaMiembros.php" method="POST">
        <label>Buscar:</label>
        <input type="text" name="caja_busqueda" value="<?php echo $busqueda; ?>">
        <input type="submit" name="buscar" value="Buscar">
        <a href="ListaMiembros.php"><button type="button">Ver Todos</button></a>
    </form>
    <br>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Membresía</th>
                <th>Vence</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($fila = mysqli_fetch_array($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila['nombre'] . " " . $fila['apellidos'] . "</td>";
                echo "<td>" . $fila['telefono'] . "</td>";
                echo "<td>" . $fila['tipo_membresia'] . "</td>";
                echo "<td>" . $fila['fecha_pago'] . "</td>";
                echo "<td>";
                
                // EDITAR: Va al archivo FormularioEditar.php 
                echo "<a href='FormularioEditar.php?id=" . $fila['id'] . "'>Editar</a> | ";
                
                // BORRAR: Va al archivo OperacionesConsultas.php 
                echo "<a href='OperacionesConsultas.php?borrar=" . $fila['id'] . "' onclick='return confirm(\"¿Seguro que lo borras?\");'>Borrar</a>";
                
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>