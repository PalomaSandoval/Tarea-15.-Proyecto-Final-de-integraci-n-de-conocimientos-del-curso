<?php
include 'conexion.php';

// --- TRUCO: Sacamos la fecha de hoy de una vez ---
$hoy = date('Y-m-d');

// Variables iniciales
$id_editar = '';
$nombre_editar = '';
$apellidos_editar = '';
$telefono_editar = '';
$fecha_nacimiento_editar = '';
$sexo_editar = '';
// Para la fecha de pago, si es nuevo, usamos HOY por defecto.
$fecha_pago_editar = $hoy; 
$tipo_membresia_editar = '';
$accion = 'guardar';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $sexo = $_POST['sexo'];
    $fecha_pago = $_POST['fecha_pago'];
    $tipo_membresia = $_POST['tipo_membresia'];

    // Switch para el costo
    $costo = 0; 
    switch ($tipo_membresia) {
        case 'Mensual': $costo = 500; break;
        case '3 Meses': $costo = 1250; break;
        case '6 Meses': $costo = 2500; break;
        case '1 Año':   $costo = 4500; break;
        default:        $costo = 0; break;
    }

    if ($_POST['accion'] === 'guardar') {
        // --- ALTA ---
        $stmt = $conn->prepare("INSERT INTO miembros (nombre, apellidos, telefono, fecha_nacimiento, sexo, fecha_pago, tipo_membresia, costo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssd", $nombre, $apellidos, $telefono, $fecha_nacimiento, $sexo, $fecha_pago, $tipo_membresia, $costo);

        if ($stmt->execute()) {
            echo "<p>¡Alta lista! Se cobraron $$costo varos.</p>";
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } elseif ($_POST['accion'] === 'actualizar') {
        // --- CAMBIO ---
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE miembros SET nombre = ?, apellidos = ?, telefono = ?, fecha_nacimiento = ?, sexo = ?, fecha_pago = ?, tipo_membresia = ?, costo = ? WHERE id = ?");
        $stmt->bind_param("sssssssdi", $nombre, $apellidos, $telefono, $fecha_nacimiento, $sexo, $fecha_pago, $tipo_membresia, $costo, $id);

        if ($stmt->execute()) {
            echo "<p>¡Datos actualizados!</p>";
        }
        $stmt->close();
    }
}

// Bajas
if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    $conn->query("DELETE FROM miembros WHERE id = $id");
    echo "<p>Borrado.</p>";
}

// Cargar Edición
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $result = $conn->query("SELECT * FROM miembros WHERE id = $id");
    if ($result->num_rows > 0) {
        $fila = $result->fetch_assoc();
        $id_editar = $fila['id'];
        $nombre_editar = $fila['nombre'];
        $apellidos_editar = $fila['apellidos'];
        $telefono_editar = $fila['telefono'];
        $fecha_nacimiento_editar = $fila['fecha_nacimiento'];
        $sexo_editar = $fila['sexo'];
        $fecha_pago_editar = $fila['fecha_pago']; // Aquí cargamos la fecha original del cliente
        $tipo_membresia_editar = $fila['tipo_membresia'];
        $accion = 'actualizar';
    }
}

// Tabla
$resultado = $conn->query("SELECT * FROM miembros");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gym Cloud</title>
</head>
<body>

    <h1> Gym Uach Fing</h1>
    
    <h2><?php echo ($accion === 'guardar' ? 'Nuevo Cliente' : 'Editando Cliente'); ?></h2>
    <form action="index.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id_editar; ?>">
        <input type="hidden" name="accion" value="<?php echo $accion; ?>">

        <label>Nombre:</label> <input type="text" name="nombre" value="<?php echo htmlspecialchars($nombre_editar); ?>" required>
        <label>Apellidos:</label> <input type="text" name="apellidos" value="<?php echo htmlspecialchars($apellidos_editar); ?>" required><br><br>

        <label>Teléfono:</label> <input type="tel" name="telefono" value="<?php echo htmlspecialchars($telefono_editar); ?>">
        
        <label>F. Nacimiento:</label> 
        <input type="date" name="fecha_nacimiento" value="<?php echo htmlspecialchars($fecha_nacimiento_editar); ?>" max="<?php echo $hoy; ?>"><br><br>

        <label>Sexo:</label>
        <select name="sexo" required>
            <option value="">-- Selecciona --</option>
            <option value="Hombre" <?php echo ($sexo_editar == 'Hombre' ? 'selected' : ''); ?>>Hombre</option>
            <option value="Mujer" <?php echo ($sexo_editar == 'Mujer' ? 'selected' : ''); ?>>Mujer</option>
            <option value="Otro" <?php echo ($sexo_editar == 'Otro' ? 'selected' : ''); ?>>Otro</option> 
        </select>
        <br><br>
        
        <label>Fecha de Pago:</label> 
        <input type="date" name="fecha_pago" value="<?php echo htmlspecialchars($fecha_pago_editar); ?>" readonly required>
        <br><br>

        <label>Tipo de Membresía:</label>
        <select name="tipo_membresia" required>
            <option value="">-- Elige --</option>
            <option value="Mensual" <?php echo ($tipo_membresia_editar == 'Mensual' ? 'selected' : ''); ?>>Mensual ($500)</option>
            <option value="3 Meses" <?php echo ($tipo_membresia_editar == '3 Meses' ? 'selected' : ''); ?>>3 Meses ($1,250)</option>
            <option value="6 Meses" <?php echo ($tipo_membresia_editar == '6 Meses' ? 'selected' : ''); ?>>6 Meses ($2,500)</option>
            <option value="1 Año" <?php echo ($tipo_membresia_editar == '1 Año' ? 'selected' : ''); ?>>1 Año ($4,500)</option>
        </select>
        
        <br><br>
        <button type="submit">Guardar</button>
        
        <?php if ($accion === 'actualizar'): ?>
            <a href="index.php"><button type="button">Cancelar</button></a>
        <?php endif; ?>
    </form>

    <h2> Clientes Registrados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
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
                    echo "<td>" . $fila["nombre"] . " " . $fila["apellidos"] . "</td>";
                    echo "<td>" . $fila["fecha_pago"] . "</td>";
                    echo "<td>" . $fila["tipo_membresia"] . "</td>";
                    echo "<td>$" . number_format($fila["costo"], 2) . "</td>"; 
                    echo "<td>";
                    echo "<a href='index.php?editar=" . $fila["id"] . "'>Editar</a> | ";
                    echo "<a href='index.php?borrar=" . $fila["id"] . "'>Borrar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

</body>
</html>