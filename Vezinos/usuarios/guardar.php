<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario       = $_POST['id_usuario'] ?? null; // campo oculto
    $nombre_usuario   = $_POST['nombre_usuario'] ?? '';
    $nombre_completo  = $_POST['nombre_completo'] ?? '';
    $numero_documento = $_POST['numero_documento'] ?? '';
    $correo           = $_POST['correo'] ?? '';
    $rol              = $_POST['rol'] ?? '';
    $estado           = $_POST['estado'] ?? '';
    $codigo_activacion= $_POST['codigo_activacion'] ?? '';
    $contrasena       = $_POST['contrasena'] ?? '';
    $confirmacion     = $_POST['confirmacion'] ?? '';
    $id_conjunto      = $_POST['id_conjunto'] ?? '';

    try {
        // Validar duplicados uno por uno
        $sqlUsuario = "SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = :nombre_usuario";
        $stmtUsuario = $conn->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmtUsuario->execute();
        if ($stmtUsuario->fetchColumn() > 0) {
            echo json_encode(["status" => "error", "message" => "El nombre de usuario ya está registrado"]);
            exit;
        }

        $sqlNombre = "SELECT COUNT(*) FROM usuarios WHERE nombre_completo = :nombre_completo";
        $stmtNombre = $conn->prepare($sqlNombre);
        $stmtNombre->bindParam(':nombre_completo', $nombre_completo, PDO::PARAM_STR);
        $stmtNombre->execute();
        if ($stmtNombre->fetchColumn() > 0) {
            echo json_encode(["status" => "error", "message" => "El nombre completo ya está registrado"]);
            exit;
        }

        $sqlDocumento = "SELECT COUNT(*) FROM usuarios WHERE numero_documento = :numero_documento";
        $stmtDocumento = $conn->prepare($sqlDocumento);
        $stmtDocumento->bindParam(':numero_documento', $numero_documento, PDO::PARAM_STR);
        $stmtDocumento->execute();
        if ($stmtDocumento->fetchColumn() > 0) {
            echo json_encode(["status" => "error", "message" => "El número de documento ya está registrado"]);
            exit;
        }
        //Estado del rol
        $estado = ($rol === 'administrador') ? 'activo' : 'pendiente';

        // Insertar si no hay duplicados
        $sql = "INSERT INTO usuarios 
                (nombre_usuario, nombre_completo, numero_documento, correo, rol, estado, codigo_activacion, 
                contrasena, confirmacion, id_conjunto) 
                VALUES 
                (:nombre_usuario, :nombre_completo, :numero_documento, :correo, :rol, :estado, :codigo_activacion, 
                :contrasena, :confirmacion, :id_conjunto)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
        $stmt->bindParam(':nombre_completo', $nombre_completo, PDO::PARAM_STR);
        $stmt->bindParam(':numero_documento', $numero_documento, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':codigo_activacion', $codigo_activacion, PDO::PARAM_STR);
        $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
        $stmt->bindParam(':confirmacion', $confirmacion, PDO::PARAM_STR);
        $stmt->bindParam(':id_conjunto', $id_conjunto, PDO::PARAM_INT);


        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Registro guardado correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo registrar el usuario"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>

