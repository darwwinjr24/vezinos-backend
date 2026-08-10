<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/config/conexion.php';

try {
    $sql = "SELECT id, nombre, numero_cedula, celular, correo, 
                   CONCAT(torre_manzana, ' ', apartamento) AS casa,
                   residente 
            FROM propietarios";
    $stmt = $conn->query($sql);
    $propietarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($propietarios);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
