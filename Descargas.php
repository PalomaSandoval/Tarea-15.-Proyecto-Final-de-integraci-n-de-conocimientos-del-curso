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
        .contenedor-principal {
            width: 100%;
            max-width: 800px; 
            padding: 20px;
            box-sizing: border-box;
        }

        /* --- GALERÍA DE FOTOS --- */
        .galeria-fotos {
            display: grid;
            grid-template-columns: repeat(3, 1fr); 
            gap: 20px;
            margin-bottom: 40px;
        }

        .tarjeta-foto {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }

        .tarjeta-foto:hover { transform: translateY(-5px); }

        .tarjeta-foto img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }

        .tarjeta-foto p {
            padding: 10px;
            margin: 0;
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
        }

        /* --- LISTA DE DESCARGAS --- */
        .lista-descargas {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #e5e7eb;
            text-align: center;
            margin: 0 auto;
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
            text-align: left; /* Para que el icono y texto se alineen */
            display: flex;
            align-items: center;
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

        @media (max-width: 600px) {
            .galeria-fotos { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <header class="barra-superior">
        <img src="img/logo.png" alt="Gym Rat" class="logo-navbar">
    </header>

    <div class="contenedor-principal">
        
        <div class="galeria-fotos">
            <div class="tarjeta-foto"><img src="img/1.jpg" alt="Foto 1"><p>Spinning</p></div>
            <div class="tarjeta-foto"><img src="img/2.jpg" alt="Foto 2"><p>Pesas</p></div>
            <div class="tarjeta-foto"><img src="img/3.jpg" alt="Foto 3"><p>Calistenia</p></div>
            <div class="tarjeta-foto"><img src="img/4.jpg" alt="Foto 4"><p>Salto de Cuerda</p></div>
            <div class="tarjeta-foto"><img src="img/5.jpg" alt="Foto 5"><p>Caminadora</p></div>
            <div class="tarjeta-foto"><img src="img/6.jpg" alt="Foto 6"><p>Pilates</p></div>
        </div>

        <div class="lista-descargas">
            <h3>📂 Proyectos y Manuales (Ingeniería Cloud)</h3>
            <p style="color: #6b7280; margin-bottom: 20px;">Descarga los códigos fuente y recursos en formato ZIP.</p>
            
            <ul>
            <?php
                $rutaCarpeta = "descargas/";
                if (is_dir($rutaCarpeta)){
                    $archivos = scandir($rutaCarpeta);
                    $encontroArchivos = false;
                    foreach ($archivos as $archivo) {
                        if ($archivo != '.' && $archivo != '..') {
                            $encontroArchivos = true;
                            $esZip = (substr(strtolower($archivo), -4) == '.zip');                         
                            $icono = $esZip ? '📦' : '📄'; 
                            echo "<li>";
                            echo "<a href='$rutaCarpeta$archivo' download>$icono $archivo</a>"; 
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
    </div>

</body>
</html>