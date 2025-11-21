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

    <style>
    /* --- 1. BASE Y TIPOGRAFÍA --- */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f3f4f6; /* Gris muy suave, casi blanco */
        color: #1f2937; /* Gris oscuro elegante (no negro puro) */
        margin: 0;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    /* --- 2. TÍTULOS --- */
    h1, h2, h3 {
        font-weight: 700;
        color: #111827;
        margin-bottom: 24px;
        letter-spacing: -0.025em; /* Un toque moderno */
        text-align: center;
    }

    /* --- 3. TARJETAS Y CONTENEDORES --- */
    .contenedor, form, .lista-descargas {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 12px; /* Bordes redondeados suaves */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025); /* Sombra difuminada pro */
        width: 100%;
        max-width: 480px; /* Ancho controlado */
        box-sizing: border-box;
        margin-bottom: 20px;
        border: 1px solid #e5e7eb; /* Borde sutil */
    }

    /* --- 4. CAMPOS DE TEXTO (INPUTS) --- */
    label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        margin-top: 16px;
    }

    input[type="text"], input[type="number"], input[type="date"], 
    input[type="tel"], input[type="email"], input[type="password"], select {
        width: 100%;
        padding: 12px 16px;
        font-size: 1rem;
        line-height: 1.5;
        color: #111827;
        background-color: #f9fafb;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        box-sizing: border-box;
        transition: all 0.2s ease;
        outline: none;
    }

    /* Efecto al seleccionar un campo */
    input:focus, select:focus {
        border-color: #4f46e5; /* Azul Indigo */
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    /* --- 5. BOTONES PRO --- */
    button, input[type="submit"], .btn {
        width: 100%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 14px 24px;
        margin-top: 24px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #ffffff;
        background-color: #111827; /* Negro casi puro (Estilo Apple/Vercel) */
        border: 1px solid transparent;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.2s, transform 0.1s;
        box-sizing: border-box;
    }

    button:hover, input[type="submit"]:hover, .btn:hover {
        background-color: #000000;
        transform: translateY(-1px); /* Se levanta un poquito */
    }

    /* Botones Secundarios / Peligro */
    .btn-rojo, button[type="button"] { 
        background-color: #ffffff;
        color: #ef4444; /* Rojo moderno */
        border: 1px solid #e5e7eb;
        margin-top: 12px;
    }

    .btn-rojo:hover, button[type="button"]:hover {
        background-color: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    /* --- 6. TABLAS (Minimalistas) --- */
    table {
        width: 100%;
        max-width: 1000px;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden; /* Para que las esquinas redondas se vean */
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
    }

    thead {
        background-color: #f9fafb;
        border-bottom: 2px solid #e5e7eb;
    }

    th {
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #6b7280;
        font-weight: 700;
        padding: 16px;
        text-align: left;
    }

    td {
        padding: 16px;
        border-bottom: 1px solid #f3f4f6;
        color: #374151;
        font-size: 0.9rem;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background-color: #f9fafb; /* Highlight suave al pasar el mouse */
    }

    /* Enlaces en la tabla */
    td a {
        color: #4f46e5;
        font-weight: 600;
        text-decoration: none;
        margin-right: 12px;
        font-size: 0.85rem;
    }
    
    td a:hover {
        text-decoration: underline;
    }

    /* --- 7. DETALLES --- */
    hr {
        border: 0;
        height: 1px;
        background: #e5e7eb;
        margin: 30px 0;
    }
    
    /* Mensajes de error o éxito */
    p {
        line-height: 1.6;
        color: #4b5563;
    }
</style>
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