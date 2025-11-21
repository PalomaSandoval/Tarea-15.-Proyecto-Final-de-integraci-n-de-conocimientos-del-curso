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
    </ul>
</div>