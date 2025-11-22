<?php
    session_start(); 

    // Lógica original: Si ya tiene sesión o cookie, va pa' dentro
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
    <title>Gym Rat - Iniciar Sesión</title>

    <style>
        /* --- ESTILO LOGIN "SPLIT SCREEN" (PANTALLA DIVIDIDA) --- */

        /* 1. ESTRUCTURA GLOBAL */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh; /* Ocupa toda la pantalla */
            display: flex; /* Magia del Flexbox */
            overflow: hidden; /* Para evitar scrolls raros en escritorio */
        }

        /* 2. MITAD IZQUIERDA: LA IMAGEN (BRANDING) */
        .lado-visual {
            flex: 1; /* Ocupa el 50% (o lo que sobre) */
            background-color: #111827; /* Fondo oscuro elegante */
            /* Opcional: Un degradado sutil sobre el negro */
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            padding: 40px;
        }

        /* El Logo en grande */
        .logo-hero {
            width: 100%;
            max-width: 380px; /* Bien grandote */
            height: auto;
            object-fit: contain;
            margin-bottom: 20px;
            /* Sombrita para que se despegue del fondo */
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.3));
            
            /* Animación de entrada coqueta */
            animation: flotar 3s ease-in-out infinite;
        }

        @keyframes flotar {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .texto-hero {
            text-align: center;
            opacity: 0.8;
            max-width: 400px;
            line-height: 1.6;
            font-size: 1.1rem;
        }

        /* 3. MITAD DERECHA: EL FORMULARIO */
        .lado-form {
            flex: 1; /* El otro 50% */
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            flex-direction: column;
            overflow-y: auto; /* Si la pantalla es muy chica, permite scroll solo aquí */
        }

        /* Contenedor del form para limitar el ancho */
        .form-wrapper {
            width: 100%;
            max-width: 420px; /* Que no se estire hasta el infinito */
        }

        /* 4. ESTILOS DEL FORMULARIO (Heredados del diseño Platinum) */
        h2 {
            font-weight: 900;
            color: #111827;
            margin-bottom: 10px;
            font-size: 2rem;
            text-align: left; /* En este diseño se ve mejor a la izquierda */
        }

        p.subtitulo {
            color: #6b7280;
            margin-top: 0;
            margin-bottom: 40px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
            margin-top: 20px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 16px; /* Inputs más altos */
            font-size: 1rem;
            color: #111827;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-sizing: border-box;
            transition: all 0.2s ease;
            outline: none;
        }

        input:focus {
            border-color: #4f46e5;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        input[type="submit"] {
            width: 100%;
            padding: 16px;
            margin-top: 30px;
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            background-color: #04031dff; /* Azul fuerte */
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        input[type="submit"]:hover {
            background-color: #0d0a3b91;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(87, 79, 231, 0.4);
        }

        /* Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 25px;
        }
        .checkbox-container input {
            width: 20px; 
            height: 20px; 
            accent-color: #4f46e5;
            cursor: pointer;
        }
        .checkbox-container label {
            margin: 0;
            cursor: pointer;
            font-weight: 500;
            color: #4b5563;
        }

        /* Alertas */
        .alerta {
            padding: 14px;
            margin-top: 25px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-align: center;
        }
        .error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fee2e2;
        }

        /* 5. RESPONSIVE (Para celular) */
        @media (max-width: 900px) {
            body {
                flex-direction: column; /* Uno arriba del otro */
                height: auto;
                min-height: 100vh;
            }
            .lado-visual {
                padding: 40px 20px;
                min-height: 300px; /* Que no desaparezca */
            }
            .logo-hero {
                max-width: 200px; /* Más chico en cel */
            }
            .lado-form {
                padding: 40px 25px;
                background-color: white;
                border-radius: 30px 30px 0 0; /* Efecto tarjeta redondeada arriba */
                margin-top: -30px; /* Para que se monte un poco sobre la imagen */
                z-index: 10;
            }
            h2, p.subtitulo { text-align: center; }
        }

    </style>
</head>
<body>

    <div class="lado-visual">
        <img src="../img/logo.png" alt="Logo Gym Rat" class="logo-hero">
        
        <div class="texto-hero">
            <h1>Gym Rat</h1>
        </div>
    </div>

    <div class="lado-form">
        <div class="form-wrapper">
            
            <h2>Iniciar Sesión</h2>

            <form action="autenticar.php" method="post">

                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" placeholder="admin@gymrat.com"
                    value="<?php if(isset($_COOKIE['correo_recordado'])) echo htmlspecialchars($_COOKIE['correo_recordado']); ?>" required>
            
                <label for="Contrasena">Contraseña</label>
                <input type="password" id="Contrasena" name="Contrasena" placeholder="••••••••" required>

                <div class="checkbox-container">
                    <input type="checkbox" id="recordarme" name="recordarme" <?php if(isset($_COOKIE['correo_recordado'])) echo "checked"; ?>>    
                    <label for="recordarme">Recordar mi usuario</label>
                </div>

                <input type="submit" value="Entrar al Sistema">

                <?php
                if(isset($_GET['error']) && $_GET['error'] == 1) { 
                    echo "<div class='alerta error'>⚠️ Correo o contraseña incorrectos</div>"; 
                }
                ?>

            </form>
        </div>
    </div>

</body>
</html>