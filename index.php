<?php
// Redirigir inmediatamente a la página de Bienvenida
header("Location: Bienvenida.php");
exit();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url=Bienvenida.php">
    <title>Redirigiendo...</title>
</head>
<body>
    <p>Si no eres redirigido automáticamente, <a href="Bienvenida.php">haz clic aquí</a>.</p>
</body>
</html>