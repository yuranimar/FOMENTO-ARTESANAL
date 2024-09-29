<?php
$servername = "DESKTOP-KEENBRV"; // o la dirección IP del servidor
$username = "usuario_sin_contraseña";
$password = ""; // Sin contraseña
$dbname = "fomento_artesanal"; // nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
// No es necesario cerrar la conexión aquí, ya que será utilizado en otros archivos
?>
