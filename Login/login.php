<?php
    session_start(); 

    // Si tien SESIÓN O tienes COOKIE
    if(isset($_SESSION["usuario"]) || isset($_COOKIE["usuario_autenticado"])){ 
        header("Location: ../Bienvenida.php"); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>

    <style>
    /* --- PEGAR ESTO DENTRO DE LAS ETIQUETAS <style> DE CADA ARCHIVO --- */

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

    /* 2. TÍTULOS */
    h1, h2, h3 {
        font-weight: 800;
        color: #111827;
        margin-bottom: 24px;
        letter-spacing: -0.03em;
        text-align: center;
    }

    /* 3. CONTENEDORES (TARJETAS) */
    .contenedor, form, .lista-descargas {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 16px; /* Bordes más redonditos */
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        width: 100%;
        max-width: 500px;
        box-sizing: border-box;
        margin-bottom: 20px;
        border: 1px solid #f3f4f6;
    }

    /* 4. INPUTS */
    label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        margin-top: 20px;
    }

    input[type="text"], input[type="number"], input[type="date"], 
    input[type="tel"], input[type="email"], input[type="password"], select {
        width: 100%;
        padding: 12px 16px;
        font-size: 1rem;
        color: #111827;
        background-color: #f9fafb;
        border: 1px solid #d1d5db;
        border-radius: 10px;
        box-sizing: border-box;
        transition: all 0.2s ease;
        outline: none;
    }

    input:focus, select:focus {
        border-color: #4f46e5;
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1); /* Brillo azulito */
    }

    /* 5. BOTONES BELICOSOS */
    button, input[type="submit"], .btn {
        width: 100%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        padding: 14px 24px;
        margin-top: 28px;
        font-size: 1rem;
        font-weight: 600;
        color: #ffffff;
        background-color: #111827;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.1s, background-color 0.2s;
        box-sizing: border-box;
    }

    button:hover, input[type="submit"]:hover, .btn:hover {
        background-color: #000000;
        transform: translateY(-2px); /* Se levanta */
    }

    /* Botones Rojos/Secundarios */
    .btn-rojo, button[type="button"] { 
        background-color: #ffffff;
        color: #dc2626;
        border: 2px solid #f3f4f6;
        margin-top: 12px;
    }

    .btn-rojo:hover, button[type="button"]:hover {
        background-color: #fef2f2;
        border-color: #fee2e2;
        color: #991b1b;
    }

    /* 6. ALERTAS / MENSAJES (Esto es lo nuevo pa' que no se vea plano) */
    .alerta {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        border-left: 5px solid transparent;
    }

    .exito {
        background-color: #ecfdf5; /* Verde menta */
        color: #065f46;
        border-left-color: #10b981;
    }

    .error {
        background-color: #fef2f2; /* Rojito suave */
        color: #991b1b;
        border-left-color: #ef4444;
    }

    /* 7. TABLAS */
    table {
        width: 100%;
        max-width: 1000px;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
    }

    thead { background-color: #f8fafc; }

    th {
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        font-weight: 700;
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    td {
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    tr:last-child td { border-bottom: none; }
    tr:hover { background-color: #f8fafc; }

    td a {
        color: #4f46e5;
        font-weight: 600;
        text-decoration: none;
        margin-right: 10px;
    }
    td a:hover { text-decoration: underline; }

    /* Checkbox container */
    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 20px;
    }
    .checkbox-container label { margin: 0; cursor: pointer;}

    hr { border: 0; height: 1px; background: #e5e7eb; margin: 30px 0; }
</style>
</head>
<body>
    
<h2>Inicio de Sesión</h2>
<form action="autenticar.php" method="post">

    <label for="correo">Correo Electrónico: </label>
    <input type="email" id="correo" name="correo" 
       value="<?php if(isset($_COOKIE['correo_recordado'])) echo htmlspecialchars($_COOKIE['correo_recordado']); ?>" required>
   
    <label for="Contrasena">Contraseña: </label>
    <input type="password" id="Contrasena" name="Contrasena" required>

    <input type="submit" value="Iniciar sesión">

    <div class="checkbox-container">
        <input type="checkbox" ... <?php if(isset($_COOKIE['correo_recordado'])) echo "checked"; ?>>    
            <label for="recordarme">Recordar usuario</label>
    </div>



    <div class="error-message">
        <?php
        if(isset($_GET['error']) && $_GET['error'] == 1) { 
            echo "<div class='alerta error'>Correo o contraseña incorrectos</div>"; 
        }
        ?>
    </div>
</form>

</body>
</html>