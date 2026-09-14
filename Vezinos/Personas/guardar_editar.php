<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_persona     = !empty($_POST['id_persona']) ? $_POST['id_persona'] : null;
    $raw_id_usuario = trim($_POST['id_usuario'] ?? '');

    // Evaluar si id_usuario es válido (admite NULL)
    $id_usuario = (!empty($raw_id_usuario) && strtolower($raw_id_usuario) !== 'null') ? (int)$raw_id_usuario : null;

    // CAMPOS NO NULOS: Aseguramos que siempre tengan un valor (cadena vacía '' o valor enviado)
    $celular   = isset($_POST['celular']) ? trim($_POST['celular']) : '';
    $perfil    = isset($_POST['perfil']) ? trim($_POST['perfil']) : '';
    $residente = isset($_POST['residente']) ? trim($_POST['residente']) : 'No';
    $edad      = !empty($_POST['edad']) ? (int)$_POST['edad'] : 0; // Si es un int NOT NULL en BD, asigna 0 por defecto
    $genero    = isset($_POST['genero']) ? trim($_POST['genero']) : '';

    // NORMALIZACIÓN PARA DATOS PERSONALES (Admiten NULL en BD):
    // Si ES usuario -> Se dejan en NULL (viven en la tabla usuarios)
    // Si NO es usuario -> Se guardan los textos digitados
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
        if ($id_persona) {
            // Modo edición → UPDATE
            $sql = "UPDATE personas 
                    SET nombre_persona = ?, numero_cedula = ?, correo_persona = ?, celular = ?, 
                        perfil = ?, residente = ?, edad = ?, genero = ?, id_usuario = ?
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
                $id_persona
            ]);

            echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente"]);
        } else {
            // Modo creación → INSERT
            $sql = "INSERT INTO personas 
                    (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
                $id_usuario
            ]);

            echo json_encode(["status" => "success", "message" => "Persona registrada correctamente"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>