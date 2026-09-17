<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rol            = $_POST['rol'] ?? '';
    $nombre_usuario = $_POST['nombre_usuario'] ?? '';
    $contrasena     = $_POST['contrasena'] ?? '';
    
    try {
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario = :usuario AND contrasena = :contrasena AND rol = :rol";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $stmt->execute();

        // Extraer los datos de la fila del usuario
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo json_encode([
                "status"  => "success", 
                "message" => "Login correcto",
                "usuario" => [
                    "id_usuario"  => $usuario['id_usuario'],
                    "id_conjunto" => $usuario['id_conjunto'], // 👈 Se devuelve al frontend
                    "rol"         => $usuario['rol']
                ]
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Datos incorrectos"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>