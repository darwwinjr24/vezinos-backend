<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id            = $_POST['id'] ?? null; // campo oculto
    $nombre        = $_POST['nombre'] ?? '';
    $numero_cedula = $_POST['numero_cedula'] ?? '';
    $correo        = $_POST['correo'] ?? '';
    $celular       = $_POST['celular'] ?? '';
    $torre_manzana = $_POST['torre_manzana'] ?? '';
    $apartamento   = $_POST['apartamento'] ?? '';
    $residente     = $_POST['residente'] ?? '';

    try {
        if ($id) {
            // Modo edición → UPDATE
            $sql = "UPDATE propietarios 
                    SET nombre = ?, numero_cedula = ?, correo = ?, celular = ?, 
                        torre_manzana = ?, apartamento = ?, residente = ?
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre, $numero_cedula, $correo, $celular, $torre_manzana, $apartamento, $residente, $id]);
            echo json_encode(["status" => "success", "message" => "Propietario actualizado correctamente"]);
        } else {
            // Modo creación → INSERT
            $sql = "INSERT INTO propietarios 
                    (nombre, numero_cedula, correo, celular, torre_manzana, apartamento, residente) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre, $numero_cedula, $correo, $celular, $torre_manzana, $apartamento, $residente]);
            echo json_encode(["status" => "success", "message" => "Propietario registrado correctamente"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>

