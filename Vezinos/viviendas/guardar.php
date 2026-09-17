<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_casa    = trim($_POST['numero_casa'] ?? '');
    $total_personas = trim($_POST['total_personas'] ?? '');
    $id_conjunto    = !empty($_POST['id_conjunto']) ? (int)$_POST['id_conjunto'] : null;

    if (empty($numero_casa) || empty($total_personas) || !$id_conjunto) {
        echo json_encode([
            "status"  => "error", 
            "message" => "Todos los campos son obligatorios y debe existir un id_conjunto válido."
        ]);
        exit();
    }

    try {
        $sql = "INSERT INTO viviendas (numero_casa, total_personas, id_conjunto) 
                VALUES (:numero_casa, :total_personas, :id_conjunto)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':numero_casa', $numero_casa, PDO::PARAM_STR);
        $stmt->bindParam(':total_personas', $total_personas, PDO::PARAM_INT);
        $stmt->bindParam(':id_conjunto', $id_conjunto, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode([
                "status"  => "success", 
                "message" => "Vivienda registrada exitosamente"
            ]);
        } else {
            echo json_encode([
                "status"  => "error", 
                "message" => "No se pudo registrar la vivienda"
            ]);
        }

    } catch (PDOException $e) {
        echo json_encode([
            "status"  => "error", 
            "message" => "Error en la base de datos: " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "status"  => "error", 
        "message" => "Método no permitido"
    ]);
}
?>