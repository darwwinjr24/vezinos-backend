<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_persona             = $_POST['id_persona'] ?? null; // campo oculto
    $nombre_completo        = $_POST['nombre_completo'] ?? '';
    $numero_cedula          = $_POST['numero_cedula'] ?? '';
    $correo                 = $_POST['correo'] ?? '';
    $celular                = $_POST['celular'] ?? '';
    $torre_manzana          = $_POST['torre_manzana'] ?? '';
    $apartamento            = $_POST['apartamento'] ?? '';
    $rol                    = $_POST['rol'] ?? '';
    $residente              = $_POST['residente'] ?? '';

    try {
        if ($id_persona) {
            // Modo edición → UPDATE
            $sql = "UPDATE personas 
                    SET nombre_completo = ?, numero_cedula = ?, correo = ?, celular = ?, 
                        torre_manzana = ?, apartamento = ?, rol = ?, residente = ?
                    WHERE id_persona = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre_completo, $numero_cedula, $correo, $celular, $torre_manzana, $apartamento, $rol, $residente, $id_persona]);
            echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente"]);
        } else {
            // Modo creación → INSERT
            $sql = "INSERT INTO personas 
                    (nombre_completo, numero_cedula, correo, celular, torre_manzana, apartamento, rol, residente) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nombre_completo, $numero_cedula, $correo, $celular, $torre_manzana, $apartamento, $rol, $residente]);
            echo json_encode(["status" => "success", "message" => "Persona registrada correctamente"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>

