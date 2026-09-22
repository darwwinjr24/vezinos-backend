<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

try {
    $stmt = $conn->query("SELECT id_usuario, nombre_completo, numero_documento, correo, rol 
                           FROM usuarios 
                           WHERE estado = 'activo' 
                           ORDER BY nombre_completo ASC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($usuarios);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Error al listar usuarios: " . $e->getMessage()]);
}
?>
