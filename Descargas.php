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
    <title>Descargas - Gym Rat</title>
    <style>
        /* --- 1. BASE Y TIPOGRAFÍA --- */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            color: #1f2937;
            margin: 0;
            padding: 0;
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
            margin-bottom: 40px;
        }
        .logo-navbar {
            height: 45px;
            width: auto;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        /* --- CONTENEDOR PRINCIPAL --- */
        /* Le aumenté el ancho máximo para que quepan las fotos chido */
        .contenedor-principal {
            width: 100%;
            max-width: 800px; 
            padding: 20px;
            box-sizing: border-box;
        }

        /* --- NUEVA GALERÍA DE FOTOS (GRID) --- */
        .galeria-fotos {
            display: grid;
            /* Aquí está el truco: 3 columnas del mismo tamaño */
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px;
            margin-bottom: 40px; /* Espacio antes de la lista de descargas */
        }

        .tarjeta-foto {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }

        .tarjeta-foto:hover {
            transform: translateY(-5px);
        }

        .tarjeta-foto img {
            width: 100%;
            height: 150px; /* Altura fija para que no se vea chueco */
            object-fit: cover; /* Recorta la imagen para que llene el hueco */
            display: block;
        }

        .tarjeta-foto p {
            padding: 10px;
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
        }

        /* --- LISTA DE DESCARGAS (Estilo anterior) --- */
        .lista-descargas {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            width: 100%;
            /* max-width: 480px;  <-- Lo quité para que se estire con el contenedor padre */
            box-sizing: border-box;
            border: 1px solid #e5e7eb;
            text-align: center;
            margin: 0 auto; /* Centrado */
        }

        h3 {
            font-weight: 700;
            color: #111827;
            margin-bottom: 24px;
            text-align: center;
        }

        ul { list-style-type: none; padding: 0; margin: 0 0 20px 0; }
        li {
            background-color: #f9fafb;
            margin: 10px 0;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        li:hover {
            border-color: #4f46e5;
            background-color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        li a {
            text-decoration: none;
            color: #111827;
            font-weight: 600;
            display: block;
            width: 100%;
        }

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

        /* Para que en celular se pongan una abajo de otra y no se vea todo apretado */
        @media (max-width: 600px) {
            .galeria-fotos {
                grid-template-columns: 1fr; /* 1 sola columna en cel */
            }
        }
    </style>
</head>
<body>

    <header class="barra-superior">
        <img src="img/logo.png" alt="Gym Rat" class="logo-navbar">
    </header>

    <div class="contenedor-principal">
        
        <div class="galeria-fotos">
            <div class="tarjeta-foto">
                <img src="img/1.jpg" alt="Foto 1">
                <p>Spinning </p>
            </div>
            <div class="tarjeta-foto">
                <img src="img/2.jpg" alt="Foto 2">
                <p>Pesas</p>
            </div>
            <div class="tarjeta-foto">
                <img src="img/3.jpg" alt="Foto 3">
                <p>Calistenia</p>
            </div>
            
            <div class="tarjeta-foto">
                <img src="img/4.jpg" alt="Foto 4">
                <p>Salto de Cuerda</p>
            </div>
            <div class="tarjeta-foto">
                <img src="img/5.jpg" alt="Foto 5">
                <p>Caminadora</p>
            </div>
            <div class="tarjeta-foto">
                <img src="img/6.jpg" alt="Foto 6">
                <p>Pilates</p>
            </div>
        </div>

        <div class="lista-descargas">
            <h3>📂 Nuestros miembros aparte de gymrats tambien son ingenieros y le saben al cloud computing, puedes ver algunos de sus trabajos aqui:</h3>
            
            <ul>
            <?php
                $rutaCarpeta = "descargas/";
                if (is_dir($rutaCarpeta)){
                    $archivos = scandir($rutaCarpeta);
                    $encontroArchivos = false;
                    foreach ($archivos as $archivo) {
                        if ($archivo != '.' && $archivo != '..') {
                            $encontroArchivos = true;
                            echo "<li><a href='$rutaCarpeta$archivo' download>📄 $archivo</a></li>";
                        }
                    }
                    if (!$encontroArchivos) echo "<p style='color: gray;'>No hay archivos, carnal.</p>";
                } else {
                    echo "<p style='color: red;'>Error: No topo la carpeta 'descargas'.</p>";
                }
            ?>
            </ul>

            <hr style="border: 0; height: 1px; background: #e5e7eb; margin: 20px 0;">
            <a href="Bienvenida.php" class="btn-rojo">← Volver al Inicio</a>
        </div>
    </div>

</body>
</html>