<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol        = $_POST['rol'] ?? '';
    $nombre_usuario    = $_POST['nombre_usuario'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    
    try {
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :usuario AND contrasena = :contrasena AND rol = :rol";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "success", "message" => "Login correcto"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Datos incorrectos"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>
