<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_cedula = $_POST['numero_cedula'] ?? '';

    if (!$numero_cedula) {
        echo json_encode(["status" => "error", "message" => "Debe ingresar un número de cédula"]);
        exit;
    }

    try {
        $sql = "SELECT id_usuario, nombre_completo, correo 
                FROM usuarios 
                WHERE numero_documento = :numero_documento LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':numero_documento', $numero_cedula, PDO::PARAM_STR);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode(["status" => "success", "data" => $row]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se encontró ningún usuario con esa cédula"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>
