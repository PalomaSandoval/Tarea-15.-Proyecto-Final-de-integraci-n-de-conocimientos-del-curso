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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta Gym</title>

    <style>
    /* --- estilos.css --- */

    /* 1. BASE Y TIPOGRAFÍA */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f3f4f6;
        color: #1f2937;
        margin: 0;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    /* 2. TÍTULOS CON MÁS FLOW */
    h1, h2, h3 {
        font-weight: 800; /* Más gordito */
        color: #111827;
        margin-bottom: 24px;
        letter-spacing: -0.03em;
        text-align: center;
    }

    h1 { font-size: 2.2rem; }
    h2 { font-size: 1.8rem; }

    /* 3. TARJETAS (CONTENEDORES) */
    .contenedor, form, .lista-descargas {
        background-color: #ffffff;
        padding: 48px; /* Un poco más de aire */
        border-radius: 16px; /* Más redondeado */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); /* Sombra más profunda */
        width: 100%;
        max-width: 480px;
        box-sizing: border-box;
        margin-bottom: 20px;
        border: 1px solid #f3f4f6;
    }

    /* 4. INPUTS Y LABELS */
    label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 8px;
        margin-top: 20px;
    }

    input[type="text"], input[type="number"], input[type="date"], 
    input[type="tel"], input[type="email"], input[type="password"], select {
        width: 100%;
        padding: 14px 16px; /* Más espacio para escribir */
        font-size: 1rem;
        color: #111827;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-sizing: border-box;
        transition: all 0.2s ease;
        outline: none;
    }

    input:focus, select:focus {
        border-color: #6366f1; /* Indigo vibrante */
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15); /* Anillo de enfoque */
    }

    /* 5. BOTONES PODEROSOS */
    button, input[type="submit"], .btn {
        width: 100%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 16px 24px;
        margin-top: 32px;
        font-size: 1rem;
        font-weight: 700;
        color: #ffffff;
        background-color: #1f2937; 
        border: none;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    button:hover, input[type="submit"]:hover, .btn:hover {
        background-color: #000000;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Botones Secundarios (Rojos/Cancelar) */
    .btn-rojo, button[type="button"] { 
        background-color: #ffffff;
        color: #ef4444;
        border: 2px solid #f3f4f6;
        margin-top: 12px;
        box-shadow: none;
    }

    .btn-rojo:hover, button[type="button"]:hover {
        background-color: #fef2f2;
        border-color: #fee2e2;
        color: #b91c1c;
        transform: translateY(-1px);
    }

    /* 6. ALERTAS (Aquí está la magia para que no se vea plano) */
    .alerta {
        padding: 16px;
        margin-bottom: 24px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        text-align: left;
        border-left: 4px solid transparent;
    }

    .alerta-exito {
        background-color: #ecfdf5; /* Verde menta muy suave */
        color: #065f46;
        border-left-color: #10b981;
    }

    .alerta-error {
        background-color: #fef2f2; /* Rojo muy suave */
        color: #991b1b;
        border-left-color: #ef4444;
    }

    .alerta-info {
        background-color: #eff6ff;
        color: #1e40af;
        border-left-color: #3b82f6;
    }

    /* 7. CHECKBOX ELEGANTE (Login) */
    .checkbox-container {
        display: flex;
        align-items: center;
        margin-top: 20px;
        gap: 10px;
    }

    .checkbox-container input[type="checkbox"] {
        width: 20px;
        height: 20px;
        accent-color: #1f2937; /* Color del check */
        cursor: pointer;
    }

    .checkbox-container label {
        margin: 0;
        cursor: pointer;
        font-weight: 500;
    }

    /* 8. TABLAS LIMPIAS */
    table {
        width: 100%;
        max-width: 1100px;
        border-collapse: separate; 
        border-spacing: 0;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        margin-top: 30px;
    }

    thead {
        background-color: #f8fafc;
    }

    th {
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.08em;
        color: #64748b;
        font-weight: 700;
        padding: 20px 16px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    td {
        padding: 20px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 0.95rem;
    }

    tr:last-child td { border-bottom: none; }
    tr:hover { background-color: #f8fafc; }

    /* Links en tablas */
    td a {
        color: #4f46e5;
        font-weight: 600;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 6px;
        transition: background 0.2s;
    }

    td a:hover { background-color: #eef2ff; }

    /* Detalles extra */
    hr {
        border: 0;
        height: 1px;
        background: #e5e7eb;
        margin: 30px 0;
}</style>
</head>
<body>
    <h1>Nuevo Cliente</h1>
    
    <a href="../formsABC/formConsultas.php"><button type="button">Ir a ver lista de todos los miembros</button></a>
    <hr>

    <?php 
        // Mensaje de éxito 
        if(isset($_GET['estatus']) && $_GET['estatus'] == 'ok') {
            echo "<div class='alerta exito'>✅ Miembro nuevo registrado correctamente.</div>";
        }

        // Mensaje de error 
        if(isset($_GET['error']) && $_GET['error'] == 'menor') {
            echo "<div class='alerta error'>🚫 No se permiten menores de 16 años.</div>";
        }
    ?>

    <form action="OperacionesRegistro.php" method="post">
        
        <label>Nombre(s):</label>
        <input type="text" name="nombre" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required>
        <br><br>

        <label>Numero de telefono:</label>
        <input type="tel" name="telefono" 
            pattern="[0-9]{10}" 
            maxlength="10" 
            placeholder="Ej: 6141234567" 
            required>
        <br><br>

        <label>Fecha de Nacimiento:</label>
        <?php $limite_edad = date('Y-m-d', strtotime('-16 years')); ?>
        <input type="date" name="fecha_nacimiento" max="<?php echo $limite_edad; ?>" required>
        <br><br>

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
        <br><br>

        <label>Miembro Desde (Fecha Pago): </label>
        <?php date_default_timezone_set('America/Mexico_City'); ?>
        <input type="date" name="fecha_pago" value="<?php echo date('Y-m-d'); ?>" readonly>
        <br><br>

        <input type="submit" value="Registrar Cliente">

        <a href="../Bienvenida.php" class="btn btn-rojo">Ir a pagina principal</a>

    </form>
</body>
</html>