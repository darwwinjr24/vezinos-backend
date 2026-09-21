<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

try {
    $sql = "SELECT id_vivienda, numero_casa FROM viviendas";
    $stmt = $conn->query($sql);

    // Obtener todos los resultados como array asociativo
    $viviendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($viviendas);
} catch(PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}

// Cerrar conexión
$conn = null;
?>
