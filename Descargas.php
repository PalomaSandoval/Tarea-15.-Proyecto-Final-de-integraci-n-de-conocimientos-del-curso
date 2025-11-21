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

<div class="lista-descargas">
    <h3>Repositorio de Archivos</h3>
    <ul>
    <?php
        $rutaCarpeta = "descargas/";

        if (is_dir($rutaCarpeta)){
            $archivos = scandir($rutaCarpeta);

            foreach ($archivos as $archivo) {
                if ($archivo != '.' && $archivo != '..') {
                    echo "<li>";
                    echo "<a href='$rutaCarpeta$archivo' download>$archivo</a>"; 
                    echo "</li>";
                }
            }
        }


    ?>
     <a href="Bienvenida.php" class="btn btn-rojo">Ir a pagina principal</a>

    </ul>
</div>