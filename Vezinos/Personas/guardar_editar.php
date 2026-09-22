<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_persona     = !empty($_POST['id_persona']) ? $_POST['id_persona'] : null;
    $raw_id_usuario = trim($_POST['id_usuario'] ?? '');

    // Nueva variable para asociar la casa (id_vivienda)
    $id_vivienda    = !empty($_POST['id_vivienda']) ? (int)$_POST['id_vivienda'] : null;

    // Evaluar si id_usuario es válido (admite NULL)
    $id_usuario = (!empty($raw_id_usuario) && strtolower($raw_id_usuario) !== 'null') ? (int)$raw_id_usuario : null;

    // CAMPOS NO NULOS
    $celular   = isset($_POST['celular']) ? trim($_POST['celular']) : '';
    $perfil    = isset($_POST['perfil']) ? trim($_POST['perfil']) : 'Residente';
    $residente = isset($_POST['residente']) ? trim($_POST['residente']) : 'Si';
    $edad      = !empty($_POST['edad']) ? (int)$_POST['edad'] : 0;
    $genero    = isset($_POST['genero']) ? trim($_POST['genero']) : '';

    // NORMALIZACIÓN DE DATOS PERSONALES
    if ($id_usuario !== null) {
        $nombre_persona = null;
        $numero_cedula  = null;
        $correo_persona = null;
    } else {
        $nombre_persona = !empty($_POST['nombre_persona']) ? trim($_POST['nombre_persona']) : null;
        $numero_cedula  = !empty($_POST['numero_cedula']) ? trim($_POST['numero_cedula']) : null;
        $correo_persona = !empty($_POST['correo_persona']) ? trim($_POST['correo_persona']) : null;
    }

    try {
        // Lógica de autodetección (Si no viene id_persona pero el nombre ya existe, obtenemos su ID para actualizarlo)
        if (!$id_persona && $nombre_persona !== null) {
            $stmtSearch = $conn->prepare("SELECT id_persona FROM personas WHERE LOWER(nombre_persona) = LOWER(?)");
            $stmtSearch->execute([$nombre_persona]);
            $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
            if ($existente) {
                $id_persona = $existente['id_persona'];
            }
        }

        if ($id_persona) {
            // Traer el registro actual para no perder datos que este formulario no maneja
            $stmtActual = $conn->prepare("SELECT * FROM personas WHERE id_persona = ?");
            $stmtActual->execute([$id_persona]);
            $actual = $stmtActual->fetch(PDO::FETCH_ASSOC);

            if ($actual) {
                // Si no llegó id_usuario por POST pero el registro ya tenía uno, lo preservamos
                if ($id_usuario === null && $actual['id_usuario'] !== null) {
                    $id_usuario = (int)$actual['id_usuario'];
                    $nombre_persona = null;
                    $numero_cedula  = null;
                    $correo_persona = null;
                }

                // Preservar edad/genero/id_vivienda si este formulario no los envió
                if (!array_key_exists('edad', $_POST) || $_POST['edad'] === '') {
                    $edad = $actual['edad'];
                }
                if (!array_key_exists('genero', $_POST) || trim($_POST['genero'] ?? '') === '') {
                    $genero = $actual['genero'];
                }
                if (!array_key_exists('id_vivienda', $_POST) || empty($_POST['id_vivienda'])) {
                    $id_vivienda = $actual['id_vivienda'];
                }
            }

            // Modo edición → UPDATE (Incluye id_vivienda)
            $sql = "UPDATE personas 
                    SET nombre_persona = ?, numero_cedula = ?, correo_persona = ?, celular = ?, 
                        perfil = ?, residente = ?, edad = ?, genero = ?, id_usuario = ?, id_vivienda = ?
                    WHERE id_persona = ?";
            $stmt = $conn->prepare($sql);

            $stmt->execute([
                $nombre_persona,
                $numero_cedula,
                $correo_persona,
                $celular,
                $perfil,
                $residente,
                $edad,
                $genero,
                $id_usuario,
                $id_vivienda,
                $id_persona
            ]);

            echo json_encode(["status" => "success", "message" => "Datos de residente actualizados correctamente"]);
        } else {
            // Modo creación → INSERT (Incluye id_vivienda)
            $sql = "INSERT INTO personas 
                    (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            $stmt->execute([
                $nombre_persona,
                $numero_cedula,
                $correo_persona,
                $celular,
                $perfil,
                $residente,
                $edad,
                $genero,
                $id_usuario,
                $id_vivienda
            ]);

            echo json_encode(["status" => "success", "message" => "Residente registrado correctamente"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>