<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Manejo de peticiones preflight CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include __DIR__ . '/../config/conexion.php';

$id_persona = $_GET['id_persona'] ?? null;

if (!$id_persona) {
    http_response_code(400);
    echo json_encode(["error" => "ID no proporcionado"]);
    exit;
}

try {
    $sql = "DELETE FROM personas WHERE id_persona = :id_persona";
    $stmt = $conn->prepare($sql);
    
    // Usar bindValue para evitar problemas de paso por referencia
    $stmt->bindValue(':id_persona', $id_persona, PDO::PARAM_INT);
    $stmt->execute();

    // Comprobar si realmente se borró alguna fila
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => "Persona eliminada correctamente"]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "No se encontró la persona con ese ID"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
}
?>
