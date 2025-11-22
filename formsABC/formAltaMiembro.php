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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta Gym</title>
    <style>
    /* 1. BASE Y TIPOGRAFÍA */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f3f4f6;
        color: #1f2937;
        margin: 0; /* Cero margen */
        padding: 0; /* Cero padding */
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

    /* 2. TÍTULOS */
    h1 { font-weight: 800; color: #111827; margin-bottom: 24px; text-align: center; font-size: 2.2rem; }

    /* 3. TARJETAS */
    form {
        background-color: #ffffff;
        padding: 48px;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        width: 90%;
        max-width: 480px;
        box-sizing: border-box;
        margin-bottom: 40px;
        border: 1px solid #f3f4f6;
    }

    /* 4. INPUTS */
    label { display: block; font-size: 0.9rem; font-weight: 600; color: #4b5563; margin-bottom: 8px; margin-top: 20px; }
    input[type="text"], input[type="number"], input[type="date"], input[type="tel"], select {
        width: 100%; padding: 14px 16px; font-size: 1rem; color: #111827;
        background-color: #f9fafb; border: 1px solid #e5e7eb; border-radius: 10px;
        box-sizing: border-box; transition: all 0.2s ease; outline: none;
    }
    input:focus, select:focus { border-color: #6366f1; background-color: #ffffff; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15); }

    /* 5. BOTONES */
    input[type="submit"] {
        width: 100%; display: inline-flex; justify-content: center; align-items: center;
        padding: 16px 24px; margin-top: 32px; font-size: 1rem; font-weight: 700;
        color: #ffffff; background-color: #1f2937; border: none; border-radius: 10px;
        cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    input[type="submit"]:hover { background-color: #000000; transform: translateY(-2px); }

    button[type="button"] { 
        background-color: #ffffff; color: #ef4444; border: 2px solid #f3f4f6; 
        padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; margin-bottom: 10px;
        width: 100%;
    }
    button[type="button"]:hover { background-color: #fef2f2; border-color: #fee2e2; color: #b91c1c; }

    .alerta { padding: 16px; margin-bottom: 24px; border-radius: 8px; font-size: 0.95rem; font-weight: 500; border-left: 4px solid transparent; }
    .exito { background-color: #ecfdf5; color: #065f46; border-left-color: #10b981; }
    .error { background-color: #fef2f2; color: #991b1b; border-left-color: #ef4444; }
    hr { border: 0; height: 1px; background: #e5e7eb; margin: 30px 0; }
    </style>
</head>
<body>
    <header class="barra-superior">
        <img src="../img/logo.png" alt="Gym Rat" class="logo-navbar">
    </header>

    <form action="OperacionesRegistro.php" method="post">
        <h1>Nuevo Cliente</h1>
        
        <a href="../Bienvenida.php"><button type="button">Ir a pagina principal</button></a>
        <a href="formConsultas.php"><button type="button" style="color:#1f2937;">Ver Lista de Miembros</button></a>
        <hr>

        <?php 
            if(isset($_GET['estatus']) && $_GET['estatus'] == 'ok') echo "<div class='alerta exito'>✅ Miembro registrado.</div>";
            if(isset($_GET['error']) && $_GET['error'] == 'menor') echo "<div class='alerta error'>🚫 No menores de 16 años.</div>";
        ?>

        <label>Nombre(s):</label>
        <input type="text" name="nombre" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label>Numero de telefono:</label>
        <input type="tel" name="telefono" pattern="[0-9]{10}" maxlength="10" placeholder="Ej: 6141234567" required>

        <label>Fecha de Nacimiento:</label>
        <?php $limite_edad = date('Y-m-d', strtotime('-16 years')); ?>
        <input type="date" name="fecha_nacimiento" max="<?php echo $limite_edad; ?>" required>

        <label>Sexo:</label>
        <select name="sexo" required>
            <option value="Hombre">Hombre</option>
            <option value="Mujer">Mujer</option>
            <option value="Otro">Otro</option>
        </select>

        <label>Tipo de Membresía:</label>
        <select name="tipo_membresia" required>
            <option value="Mensual">Mensual ($500)</option>
            <option value="3 Meses">3 Meses ($1,250)</option>
            <option value="6 Meses">6 Meses ($2,500)</option>
            <option value="1 Año">1 Año ($4,500)</option>
        </select>

        <label>Miembro Desde (Fecha Pago): </label>
        <?php date_default_timezone_set('America/Mexico_City'); ?>
        <input type="date" name="fecha_pago" value="<?php echo date('Y-m-d'); ?>" readonly>

        <input type="submit" value="Registrar Cliente">
    </form>
</body>
</html>