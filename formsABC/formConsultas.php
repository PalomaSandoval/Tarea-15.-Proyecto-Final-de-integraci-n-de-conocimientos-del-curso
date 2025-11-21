<?php
    session_start(); 

    // sesión activa? 
    if (!isset($_SESSION["usuario"])) {
        
        // no tiene sesión. pero si quiza una cookie
        if (isset($_COOKIE["usuario_autenticado"])) {
            
            // si existe la cookie se inicia sesion
            $_SESSION["usuario"] = $_COOKIE["usuario_autenticado"];
            
        } else {

            header("Location: Login/login.php"); 
            exit();
        }
    }
    
    $usuario = $_SESSION["usuario"];
    
    // Conexión 
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");

    $where = "";
    $busqueda = "";

    // Lógica del buscador 
    if (isset($_POST['buscar'])) {
 
        $busqueda = mysqli_real_escape_string($conexion, $_POST['caja_busqueda']);
        
        // 
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

    <a href="../formsABC/formAltaMiembro.php"><button type="button">+ Nuevo Registro</button></a>
    <hr>
    
    <?php
        if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'borrado') echo "Eliminado correctamente";
        if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'actualizado') echo "Datos actualizados";
    ?>

    <form action="formConsultas.php" method="POST">
        <label>Buscar:</label>
        <input type="text" name="caja_busqueda" value="<?php echo htmlspecialchars($busqueda); ?>">
        <input type="submit" name="buscar" value="Buscar">
        <a href="formConsultas.php"><button type="button">Ver Todos</button></a>

        <a href="../Bienvenida.php" class="btn btn-rojo">Ir a pagina principal</a>

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
                echo "<td>" . htmlspecialchars($fila['nombre']) . " " . htmlspecialchars($fila['apellidos']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['telefono']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['tipo_membresia']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['fecha_pago']) . "</td>";
                echo "<td>";
                
                echo "<a href='formEditarMiembro.php?id=" . $fila['id'] . "'>Editar</a> | ";
                
                echo "<a href='OperacionesConsultas.php?borrar=" . $fila['id'] . "' onclick='return confirm(\"¿Seguro que lo borras?\");'>Borrar</a>";
                
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>