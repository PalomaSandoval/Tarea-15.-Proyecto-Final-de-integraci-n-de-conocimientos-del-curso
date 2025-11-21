<?php
// --- DATOS DE CONEXIÓN (AQUÍ MERA VA LA INFO) ---
$servidor = "localhost";  // Casi siempre es este en XAMPP/WAMP
$usuario = "root";        // El usuario default de phpMyAdmin
$password = "";           // En XAMPP suele estar vacío. Si usas MAMP, ponle "root"
$basededatos = "proyectofinal"; // ¡El nombre que tú le pusiste!

// 1. Intentamos conectar (Crear la instancia)
$conn = new mysqli($servidor, $usuario, $password, $basededatos);

// 2. Checamos si no tronó el asunto
if ($conn->connect_error) {
    // Si falla, matamos el proceso y mostramos el error (qué oso)
    die("¡No se pudo conectar, carnal! Checa esto: " . $conn->connect_error);
}

// 3. Forzamos caracteres latinos (para que la 'ñ' y acentos se vean bien)
$conn->set_charset("utf8");

// Si llegamos aquí, es que todo está al cien.
// No pongas "echo 'Conectado';" porque luego te sale ese texto en el formulario y se ve gacho.
?>