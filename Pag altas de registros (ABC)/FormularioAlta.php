<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta Gym</title>
</head>
<body>
    <h1>Nuevo Cliente</h1>
    
    <a href="../Pag Consultas (ABC)/ListaMiembros.php"><button type="button">Ir a Ver Lista</button></a>
    <hr>

    <?php 
        // registro
        if(isset($_GET['estatus']) && $_GET['estatus'] == 'ok') {
            echo "Cliente registrado";
        }
    ?>

    <form action="OperacionesRegistro.php" method="post">
        
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Apellidos:</label>
        <input type="text" name="apellidos" required>
        <br><br>

        <label>Teléfono:</label>
        <input type="number" name="telefono" required>

        <label>F. Nacimiento:</label>
        <input type="date" name="fecha_nacimiento" required>
        <br><br>

        <label>Sexo:</label>
        <select name="sexo" required>
            <option value="Hombre">Hombre</option>
            <option value="Mujer">Mujer</option>
            <option value="Otro">Otro</option>
        </select>

        <label>Membresía:</label>
        <select name="tipo_membresia" required>
            <option value="Mensual">Mensual ($500)</option>
            <option value="3 Meses">3 Meses ($1,250)</option>
            <option value="6 Meses">6 Meses ($2,500)</option>
            <option value="1 Año">1 Año ($4,500)</option>
        </select>
        <br><br>

        <label>Fecha Pago:</label>
        <input type="date" name="fecha_pago" value="<?php echo date('Y-m-d'); ?>" readonly>
        <br><br>

        <input type="submit" value="Registrar Cliente">

        <a href="../Bienvenida.php" class="btn btn-rojo">Ir a pagina principal</a>

    </form>
</body>
</html>