<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recepción y normalización de variables
    $raw_id_usuario = trim($_POST['id_usuario'] ?? '');
    $id_usuario     = (!empty($raw_id_usuario) && strtolower($raw_id_usuario) !== 'null' && (int)$raw_id_usuario > 0) ? (int)$raw_id_usuario : null;

    $id_vivienda    = !empty($_POST['id_vivienda']) ? (int)$_POST['id_vivienda'] : null;
    $nombre_persona = !empty(trim($_POST['nombre_persona'] ?? '')) ? trim($_POST['nombre_persona']) : null;
    $numero_cedula  = !empty(trim($_POST['numero_cedula'] ?? '')) ? trim($_POST['numero_cedula']) : null;
    $correo_persona = !empty(trim($_POST['correo_persona'] ?? '')) ? trim($_POST['correo_persona']) : null;
    $celular        = !empty(trim($_POST['celular'] ?? '')) ? trim($_POST['celular']) : null;

    $perfil         = !empty(trim($_POST['perfil'] ?? '')) ? trim($_POST['perfil']) : '';
    $residente      = !empty(trim($_POST['residente'] ?? '')) ? trim($_POST['residente']) : '';

    $edad           = (isset($_POST['edad']) && $_POST['edad'] !== '') ? (int)$_POST['edad'] : null;
    $genero         = !empty(trim($_POST['genero'] ?? '')) ? trim($_POST['genero']) : null;

    try {
        $existente = null;

        // 2. BÚSQUEDA DEL REGISTRO EXISTENTE
        if ($id_usuario !== null) {
            $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE id_usuario = ? LIMIT 1");
            $stmtSearch->execute([$id_usuario]);
            $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
        }

        if (!$existente && $nombre_persona !== null) {
            $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE LOWER(TRIM(nombre_persona)) = LOWER(TRIM(?)) LIMIT 1");
            $stmtSearch->execute([$nombre_persona]);
            $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
        }

        // 3. PROCESAMIENTO (ACTUALIZAR O INSERTAR)
        if ($existente) {
            if ($id_usuario !== null) {
                $sql = "UPDATE personas 
                        SET id_vivienda = ?, genero = ?, edad = ?
                        WHERE id_persona = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$id_vivienda, $genero, $edad, $existente['id_persona']]);

                echo json_encode(["status" => "success", "message" => "Datos de vivienda, género, y edad actualizados"]);
            } else {
                echo json_encode(["status" => "info", "message" => "No se actualizó porque no tiene id_usuario asignado"]);
            }
        } else {
            // Si el registro va ligado a un usuario existente, nombre/cédula/correo ya viven en 'usuarios'
            // -> se fuerzan a null en 'personas' para no duplicarlos.
            // 'celular' NO se toca: es un dato exclusivo de 'personas', no existe en 'usuarios'.
            if ($id_usuario !== null) {
                $nombre_persona = null;
                $numero_cedula  = null;
                $correo_persona = null;
            }

            $sql = "INSERT INTO personas 
                    (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $nombre_persona, $numero_cedula, $correo_persona, $celular,
                $perfil, $residente, $edad, $genero, $id_usuario, $id_vivienda
            ]);

            echo json_encode(["status" => "success", "message" => "Nuevo residente registrado"]);
        }

    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>
