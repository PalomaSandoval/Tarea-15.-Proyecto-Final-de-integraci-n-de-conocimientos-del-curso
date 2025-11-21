<div class="lista-descargas">
    <h3>Repositorio de Archivos</h3>
    <ul>
    <?php
        // 1. Apuntamos a la carpeta (El Repositorio físico)
        $rutaCarpeta = "descargas/";

        // 2. Leemos qué hay dentro
        if (is_dir($rutaCarpeta)){
            $archivos = scandir($rutaCarpeta);

            // 3. Hacemos un ciclo para crear los ENLACES uno por uno
            foreach ($archivos as $archivo) {
                if ($archivo != '.' && $archivo != '..') {
                    echo "<li>";
                    // AQUÍ ESTÁ EL ENLACE QUE PIDE EL PROFE 👇
                    echo "<a href='$rutaCarpeta$archivo' download>$archivo</a>"; 
                    echo "</li>";
                }
            }
        }
    ?>
    </ul>
</div>