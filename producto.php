<?php
session_start();
require 'database.php'; // Conexión a la base de datos

$username = $_POST['username'];
$password = $_POST['password'];

// Consulta para verificar credenciales
$stmt = $pdo->prepare("SELECT * FROM artisans WHERE username = ? AND password = ?");
$stmt->execute([$username, md5($password)]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: artisan-dashboard.html');
} else {
    echo 'Credenciales incorrectas';
}
?>
<?php
session_start();
require 'database.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $image = $_FILES['product_image']['name'];
    $target = 'uploads/' . basename($image);

    // Subir imagen
    if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target)) {
        // Insertar producto
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, artisan_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image, $_SESSION['user_id']]);
        header('Location: artisan-dashboard.html');
    } else {
        echo 'Error al subir la imagen';
    }
}
?>
<?php
session_start();
require 'database.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $description = $_POST['product_description'];
    $price = $_POST['product_price'];
    $image = $_FILES['product_image']['name'];

    if ($image) {
        $target = 'uploads/' . basename($image);
        move_uploaded_file($_FILES['product_image']['tmp_name'], $target);
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $image, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $id]);
    }

    header('Location: artisan-dashboard.html');
}
?>
<?php
session_start();
require 'database.php'; // Conexión a la base de datos

$id = $_GET['id'];

// Consulta para eliminar producto
$stmt = $pdo->prepare("DELETE FROM products WHERE id = ? AND artisan_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

header('Location: artisan-dashboard.html');
?>
<?php
$host = 'localhost';
$db   = 'fomento_artesanal';
$user = 'root';
$pass = '';

// Configuración de la base de datos
$pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
