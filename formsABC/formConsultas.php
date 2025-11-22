<?php
    session_start(); 
    if (!isset($_SESSION["usuario"])) {
        if (isset($_COOKIE["usuario_autenticado"])) {
            $_SESSION["usuario"] = $_COOKIE["usuario_autenticado"];
        } else {
            header("Location: Login/login.php"); 
            exit();
        }
    }
    $usuario = $_SESSION["usuario"];
    
    $conexion = mysqli_connect("localhost", "root", "", "proyectofinal");
    $where = "";
    $busqueda = "";

    if (isset($_POST['buscar'])) {
        $busqueda = mysqli_real_escape_string($conexion, $_POST['caja_busqueda']);
        $where = "WHERE nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%'";
    }
    $sql = "SELECT * FROM miembros $where";
    $resultado = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista Miembros - Gym Rat</title>
    <style>
    /* --- 1. BASE BELICOSA --- */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f3f4f6;
        color: #1f2937;
        margin: 0; /* Sin margen */
        padding: 0; /* Sin padding */
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    /* --- BARRA NEGRA --- */
    header.barra-superior {
        width: 100%;
        background-color: #111827;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    .logo-navbar {
        height: 45px;
        width: auto;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    h1 {
        font-weight: 800;
        color: #111827;
        margin-bottom: 20px;
        text-align: center;
    }

    /* --- 2. BARRA DE ACCIONES --- */
    .barra-acciones {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        justify-content: center;
        width: 90%;
        max-width: 1000px;
        margin-bottom: 24px;
    }
    input[type="text"] {
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        font-size: 0.95rem;
        width: 250px;
    }
    input[type="text"]:focus { border-color: #4f46e5; }

    .btn-chico {
        padding: 10px 16px;
        background-color: #111827;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-chico:hover { background-color: #000; transform: translateY(-1px); }
    
    .btn-secundario { background-color: #fff; color: #374151; border: 1px solid #d1d5db; }
    .btn-secundario:hover { background-color: #f9fafb; color: #111827; }
    
    .btn-rojo { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .btn-rojo:hover { background-color: #fecaca; }

    /* --- 3. TABLA --- */
    .tabla-contenedor {
        width: 95%;
        max-width: 1100px;
        overflow-x: auto;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-radius: 12px;
        margin-bottom: 40px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        min-width: 800px;
    }
    thead { background-color: #1f2937; color: #ffffff; }
    th { text-transform: uppercase; font-size: 0.75rem; font-weight: 700; padding: 18px; text-align: left; }
    td { padding: 16px 18px; border-bottom: 1px solid #f3f4f6; color: #4b5563; font-size: 0.95rem; vertical-align: middle; }
    tbody tr:nth-child(even) { background-color: #f9fafb; }
    tbody tr:hover { background-color: #f3f4f6; }

    /* --- 4. ETIQUETAS --- */
    .badge { display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; }
    .badge-azul { background-color: #e0e7ff; color: #3730a3; }
    .badge-rosa { background-color: #fce7f3; color: #9d174d; }
    .badge-verde { background-color: #d1fae5; color: #065f46; }
    .badge-oro { background-color: #fef3c7; color: #92400e; }

    .acciones { display: flex; gap: 8px; }
    .btn-accion { text-decoration: none; padding: 6px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 600; transition: 0.2s; }
    .editar { background-color: #eff6ff; color: #2563eb; }
    .editar:hover { background-color: #dbeafe; }
    .borrar { background-color: #fef2f2; color: #dc2626; }
    .borrar:hover { background-color: #fee2e2; }

    .alerta {
        padding: 12px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        background-color: #ecfdf5;
        color: #065f46;
        border-left: 4px solid #10b981;
        font-weight: 500;
        width: 90%;
        max-width: 600px;
        text-align: center;
    }
    </style>
</head>
<body>
    <header class="barra-superior">
        <img src="../img/logo.png" alt="Gym Rat" class="logo-navbar">
    </header>

    <h1>Administración y Consultas</h1>

    <?php
        if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'borrado') 
            echo "<div class='alerta'>Miembro eliminado correctamente</div>";
        if(isset($_GET['mensaje']) && $_GET['mensaje'] == 'actualizado') 
            echo "<div class='alerta'> Datos actualizados correctamente</div>";
    ?>

    <form action="formConsultas.php" method="POST" class="barra-acciones">
        <a href="formAltaMiembro.php" class="btn-chico">➕ Nuevo Miembro</a>
        <div style="flex-grow: 1; text-align: center;">
            <input type="text" name="caja_busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
            <input type="submit" name="buscar" value="Buscar" class="btn-chico btn-secundario">
            <?php if($busqueda != ""): ?>
                <a href="formConsultas.php" class="btn-chico btn-secundario">Limpiar</a>
            <?php endif; ?>
        </div>
        <a href="../Bienvenida.php" class="btn-chico btn-rojo">Pagina Principal</a>
    </form>

    <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Teléfono</th>
                    <th>Sexo</th>
                    <th>Edad</th>                
                    <th>Membresía</th>
                    <th>Miembro desde</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($fila = mysqli_fetch_array($resultado)) {
                    $badgeSexo = ($fila['sexo'] == 'Mujer') ? 'badge-rosa' : 'badge-azul';
                    $badgeMembresia = 'badge-verde';
                    if($fila['tipo_membresia'] == '1 Año' || $fila['tipo_membresia'] == '6 Meses') {
                        $badgeMembresia = 'badge-oro';
                    }
                    $nacimiento = new DateTime($fila['fecha_nacimiento']);
                    $hoy = new DateTime();
                    $edad = $hoy->diff($nacimiento)->y;

                    echo "<tr>";
                    echo "<td><span style='font-weight:600; color:#111827;'>" . htmlspecialchars($fila['nombre']) . " " . htmlspecialchars($fila['apellidos']) . "</span></td>";
                    echo "<td>" . htmlspecialchars($fila['telefono']) . "</td>";
                    echo "<td><span class='badge $badgeSexo'>" . htmlspecialchars($fila['sexo']) . "</span></td>";
                    echo "<td>" . $edad . " años</td>";
                    echo "<td><span class='badge $badgeMembresia'>" . htmlspecialchars($fila['tipo_membresia']) . "</span></td>";
                    echo "<td style='font-family:monospace; font-size:0.9rem;'>" . htmlspecialchars($fila['fecha_pago']) . "</td>";
                    echo "<td><div class='acciones'>";
                    echo "<a href='formEditarMiembro.php?id=" . $fila['id'] . "' class='btn-accion editar'> Editar</a>";
                    echo "<a href='OperacionesConsultas.php?borrar=" . $fila['id'] . "' onclick='return confirm(\"¿Seguro?\");' class='btn-accion borrar'>Borrar</a>";
                    echo "</div></td></tr>";
                }
                ?>
            </tbody>
        </table>
        <?php if(mysqli_num_rows($resultado) == 0): ?>
            <div style="padding: 40px; text-align: center; color: #6b7280;">No hay miembros.</div>
        <?php endif; ?>
    </div>
</body>
</html>