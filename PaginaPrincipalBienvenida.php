<html>

<?php

//hasta ahorita este archivo esta incompelto solo esta tomando las cookies, falta poner 
//lo demas q va a mostrar la pagina y asi
if(isset($_COOKIE["nombreUsuario"])){
    echo "bienvenido ".$_COOKIE["nombreUsuario"];
}   
?>
</html>
