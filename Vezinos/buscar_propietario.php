<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/config/conexion.php';

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $sql = "SELECT * FROM propietarios WHERE id = :id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $propietario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($propietario) {
            echo json_encode($propietario);
        } else {
            echo json_encode(["error" => "Propietario no encontrado"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "ID no proporcionado"]);
}
?>
