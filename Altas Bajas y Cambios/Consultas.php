<?php
include 'conexion.php';

// --- LOGICA DE BORRAR (BAJA) ---
if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    $conn->query("DELETE FROM miembros WHERE id = $id");
    echo "<p style='color:red;'>¡Miembro eliminado!</p>";
}

// --- LOGICA DE BUSQUEDA ---
$busqueda = "";
$where = "";

if (isset($_POST['buscar'])) {
    $busqueda = $_POST['caja_busqueda'];
    $where = "WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'";
}

$sql = "SELECT * FROM miembros $where";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultas Gym</title>
</head>
<body>

    <h1>Consultas y Administración</h1>

    <p>
        <a href="FormularioABC.php"><button type="button">Registrar Nuevo Miembro</button></a>
    </p>
    <hr>

    <form action="Consultas.php" method="POST">
        <label>Buscar por Nombre o Apellido:</label>
        <input type="text" name="caja_busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
        <button type="submit" name="buscar">Buscar</button>
        <a href="Consultas.php"><button type="button">Ver Todos</button></a>
    </form>
    <br>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th> 
                <th>Nombre Completo</th>
                <th>Teléfono</th>
                <th>F. Nacimiento</th>
                <th>Sexo</th>
                <th>Fecha Pago</th>
                <th>Membresía</th>
                <th>Costo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado->num_rows > 0) {
                while($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    // 1. Mostramos el ID
                    echo "<td>" . $fila["id"] . "</td>";
                    
                    echo "<td>" . $fila["nombre"] . " " . $fila["apellidos"] . "</td>";
                    echo "<td>" . $fila["telefono"] . "</td>";
                    
                    // 2. Mostramos Fecha de Nacimiento y Sexo
                    echo "<td>" . $fila["fecha_nacimiento"] . "</td>";
                    echo "<td>" . $fila["sexo"] . "</td>";
                    
                    echo "<td>" . $fila["fecha_pago"] . "</td>";
                    echo "<td>" . $fila["tipo_membresia"] . "</td>";
                    echo "<td>$" . number_format($fila["costo"], 2) . "</td>"; 
                    echo "<td>";
                    echo "<a href='FormularioABC.php?editar=" . $fila["id"] . "'>Editar</a> | ";
                    echo "<a href='Consultas.php?borrar=" . $fila["id"] . "' onclick=\"return confirm('¿Seguro que lo borras?');\">Borrar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No se encontraron miembros con esos datos.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>