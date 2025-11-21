<?php
    session_start(); 

    // Validación de sesión (Igual que antes)
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
    <title>Descargas - Gym Rat</title>

    <style>
        /* --- 1. BASE Y TIPOGRAFÍA --- */
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

        /* --- 2. TÍTULOS --- */
        h1, h2, h3 {
            font-weight: 700;
            color: #111827;
            margin-bottom: 24px;
            text-align: center;
        }

        /* --- 3. CONTENEDOR TIPO TARJETA --- */
        .lista-descargas {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 480px;
            box-sizing: border-box;
            border: 1px solid #e5e7eb;
            text-align: center; /* Centrar contenido */
        }

        /* --- 4. LISTA DE ARCHIVOS --- */
        ul {
            list-style-type: none; /* Quitar puntitos feos */
            padding: 0;
            margin: 0 0 20px 0;
        }

        li {
            background-color: #f9fafb;
            margin: 10px 0;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        li:hover {
            border-color: #4f46e5; /* Azul al pasar el mouse */
            background-color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        li a {
            text-decoration: none;
            color: #111827;
            font-weight: 600;
            display: block; /* Para que todo el recuadro sea clicable */
            width: 100%;
        }

        /* --- 5. BOTONES --- */
        .btn-rojo { 
            background-color: #ffffff;
            color: #ef4444;
            border: 1px solid #e5e7eb;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            margin-top: 20px;
            transition: all 0.2s;
        }

        .btn-rojo:hover {
            background-color: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
        }
    </style>
</head>
<body>

    <div class="lista-descargas">
        <h3>📂 Repositorio de Archivos</h3>
        
        <ul>
        <?php
            // Asegúrate de crear la carpeta "descargas" junto a este archivo
            $rutaCarpeta = "descargas/";

            // Validamos si existe la carpeta para que no truene
            if (is_dir($rutaCarpeta)){
                $archivos = scandir($rutaCarpeta);

                // Bandera para saber si encontramos algo
                $encontroArchivos = false;

                foreach ($archivos as $archivo) {
                    if ($archivo != '.' && $archivo != '..') {
                        $encontroArchivos = true;
                        echo "<li>";
                        // Agregamos un emoji de archivo para que se vea coqueto
                        echo "<a href='$rutaCarpeta$archivo' download>📄 $archivo</a>"; 
                        echo "</li>";
                    }
                }

                if (!$encontroArchivos) {
                    echo "<p style='color: gray;'>No hay archivos disponibles por ahora.</p>";
                }
            } else {
                echo "<p style='color: red;'>Error: No encuentro la carpeta 'descargas'.</p>";
            }
        ?>
        </ul>

        <hr style="border: 0; height: 1px; background: #e5e7eb; margin: 20px 0;">

        <a href="Bienvenida.php" class="btn-rojo">← Volver al Inicio</a>
    </div>

</body>
</html>