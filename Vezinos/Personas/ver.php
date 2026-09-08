<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

try {
    $sql = "SELECT id_persona, nombre_completo, numero_cedula, celular, correo, 
                   CONCAT(torre_manzana, ' ', apartamento) AS casa, rol,
                   residente 
            FROM personas";
    $stmt = $conn->query($sql);
    $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($personas);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
