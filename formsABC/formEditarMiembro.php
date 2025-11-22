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
    if (!isset($_GET['id'])) { header("Location: formConsultas.php"); exit(); }
    $id = mysqli_real_escape_string($conexion, $_GET['id']);
    $sql = "SELECT * FROM miembros WHERE id = '$id'";
    $resultado = mysqli_query($conexion, $sql);
    $fila = mysqli_fetch_array($resultado);
    if (!$fila) { header("Location: formConsultas.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Miembro</title>
    <style>
    /* 1. BASE */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f3f4f6;
        color: #1f2937;
        margin: 0; /* 0 margen */
        padding: 0; /* 0 padding */
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    /* BARRA NEGRA */
    header.barra-superior {
        width: 100%;
        background-color: #111827;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 40px;
    }
    .logo-navbar {
        height: 45px;
        width: auto;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    h2 { font-weight: 800; color: #111827; margin-bottom: 24px; text-align: center; }

    /* CONTENEDOR FORM */
    form {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        width: 90%;
        max-width: 500px;
        box-sizing: border-box;
        margin-bottom: 40px;
        border: 1px solid #f3f4f6;
    }

    /* INPUTS */
    label { display: block; font-size: 0.9rem; font-weight: 600; color: #374151; margin-bottom: 8px; margin-top: 20px; }
    input[type="text"], input[type="tel"], input[type="date"], select {
        width: 100%; padding: 12px 16px; font-size: 1rem; color: #111827;
        background-color: #f9fafb; border: 1px solid #d1d5db; border-radius: 10px;
        box-sizing: border-box; outline: none;
    }
    input:focus, select:focus { border-color: #4f46e5; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); }

    /* BOTONES */
    input[type="submit"] {
        width: 100%; padding: 14px 24px; margin-top: 28px; font-size: 1rem; font-weight: 600;
        color: #ffffff; background-color: #111827; border: none; border-radius: 10px;
        cursor: pointer; transition: all 0.2s;
    }
    input[type="submit"]:hover { background-color: #000000; transform: translateY(-2px); }

    .btn-rojo, button[type="button"] { 
        background-color: #ffffff; color: #dc2626; border: 2px solid #f3f4f6; 
        margin-top: 12px; width: 100%; padding: 10px; border-radius: 8px; cursor: pointer; font-weight: 600;
    }
    .btn-rojo:hover, button[type="button"]:hover { background-color: #fef2f2; border-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <header class="barra-superior">
        <img src="../img/logo.png" alt="Gym Rat" class="logo-navbar">
    </header>

    <form action="OperacionesConsultas.php" method="post">
        
        <a href="formConsultas.php"><button type="button" style="color:#374151;">← Cancelar y Regresar</button></a>
        <h2>Editando a: <?php echo htmlspecialchars($fila['nombre']); ?></h2>
        
        <input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($fila['nombre']); ?>" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo htmlspecialchars($fila['apellidos']); ?>" required>

        <label>Numero de telefono:</label>
        <input type="tel" name="telefono" pattern="[0-9]{10}" maxlength="10" value="<?php echo htmlspecialchars($fila['telefono']); ?>" required>

        <label>Fecha de Nacimiento:</label>
        <?php $limite_edad = date('Y-m-d', strtotime('-16 years')); ?>
        <input type="date" name="fecha_nacimiento" max="<?php echo $limite_edad; ?>" value="<?php echo htmlspecialchars($fila['fecha_nacimiento']); ?>" required>

        <label>Sexo:</label>
        <select name="sexo" required>
            <option value="Hombre" <?php if($fila['sexo']=='Hombre') echo 'selected'; ?>>Hombre</option>
            <option value="Mujer" <?php if($fila['sexo']=='Mujer') echo 'selected'; ?>>Mujer</option>
            <option value="Otro" <?php if($fila['sexo']=='Otro') echo 'selected'; ?>>Otro</option>
        </select>

        <label>Tipo de Membresía:</label>
        <select name="tipo_membresia" required>
            <option value="Mensual" <?php if($fila['tipo_membresia']=='Mensual') echo 'selected'; ?>>Mensual ($500)</option>
            <option value="3 Meses" <?php if($fila['tipo_membresia']=='3 Meses') echo 'selected'; ?>>3 Meses ($1,250)</option>
            <option value="6 Meses" <?php if($fila['tipo_membresia']=='6 Meses') echo 'selected'; ?>>6 Meses ($2,500)</option>
            <option value="1 Año" <?php if($fila['tipo_membresia']=='1 Año') echo 'selected'; ?>>1 Año ($4,500)</option>
        </select>

        <input type="submit" value="Guardar Cambios">
        <a href="../Bienvenida.php" class="btn btn-rojo" style="display:block; text-align:center; text-decoration:none; margin-top:10px; box-sizing:border-box;">Ir a pagina principal</a>
    </form>
</body>
</html>