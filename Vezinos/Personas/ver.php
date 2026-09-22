<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

try {
    // Usamos LEFT JOIN y COALESCE para consolidar los datos de usuarios y personas
$sql = "SELECT 
            p.id_persona,
            COALESCE(u.nombre_completo, p.nombre_persona) AS nombre_persona,
            COALESCE(u.numero_documento, p.numero_cedula) AS numero_cedula,
            COALESCE(u.correo, p.correo_persona) AS correo_persona,
            p.celular,
            p.perfil,
            p.residente,
            p.edad,
            p.genero,
            p.id_usuario,
            v.numero_casa
        FROM personas p
        LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario
        LEFT JOIN viviendas v ON p.id_vivienda = v.id_vivienda";
            

    $stmt = $conn->query($sql);
    $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($personas);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>