<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

try {
    $sql = "SELECT id_conjunto, nombre_conjunto FROM conjuntos";
    $stmt = $conn->query($sql);

    // Obtener todos los resultados como array asociativo
    $conjuntos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($conjuntos);
} catch(PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

// Cerrar conexión
$conn = null;
?>
