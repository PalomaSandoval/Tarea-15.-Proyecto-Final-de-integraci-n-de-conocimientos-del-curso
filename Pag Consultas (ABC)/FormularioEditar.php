<?php
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");
    if (!isset($_GET['id'])) {
        header("Location: ListaMiembros.php");
        exit();
    }

    $id = $_GET['id'];

    // Buscamos los datos en la base
    $sql = "SELECT * FROM miembros WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_array($resultado);

    if (!$fila) {
        // lista
        header("Location: ListaMiembros.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Miembro</title>
</head>
<body>
    <h2>Editando a: <?php echo $fila['nombre']; ?></h2>

    <a href="ListaMiembros.php"><button type="button">Cancelar y Regresar</button></a>
    <br><br>

    <form action="OperacionesConsultas.php" method="post">
        
        <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $fila['nombre']; ?>" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $fila['apellidos']; ?>" required>
        <br><br>

        <label>Teléfono:</label>
        <input type="number" name="telefono" value="<?php echo $fila['telefono']; ?>" required>

        <label>F. Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo $fila['fecha_nacimiento']; ?>" required>
        <br><br>

        <label>Sexo:</label>
        <select name="sexo" required>
            <option value="Hombre" <?php if($fila['sexo']=='Hombre') echo 'selected'; ?>>Hombre</option>
            <option value="Mujer" <?php if($fila['sexo']=='Mujer') echo 'selected'; ?>>Mujer</option>
            <option value="Otro" <?php if($fila['sexo']=='Otro') echo 'selected'; ?>>Otro</option>
        </select>

        <label>Membresía:</label>
        <select name="tipo_membresia" required>
            <option value="Mensual" <?php if($fila['tipo_membresia']=='Mensual') echo 'selected'; ?>>Mensual</option>
            <option value="3 Meses" <?php if($fila['tipo_membresia']=='3 Meses') echo 'selected'; ?>>3 Meses</option>
            <option value="6 Meses" <?php if($fila['tipo_membresia']=='6 Meses') echo 'selected'; ?>>6 Meses</option>
            <option value="1 Año" <?php if($fila['tipo_membresia']=='1 Año') echo 'selected'; ?>>1 Año</option>
        </select>
        <br><br>

        <input type="submit" value="Guardar Cambios">

        <a href="../Bienvenida.php" class="btn btn-rojo">Ir a pagina principal</a>

    </form>
</body>
</html>