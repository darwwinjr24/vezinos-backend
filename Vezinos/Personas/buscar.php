<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

$id_persona = $_GET['id_persona'] ?? null;

if ($id_persona) {
    try {
        $sql = "SELECT 
                    p.id_persona,
                    p.id_usuario,
                    COALESCE(p.nombre_persona, u.nombre_completo)   AS nombre_persona,
                    COALESCE(p.numero_cedula, u.numero_documento)   AS numero_cedula,
                    COALESCE(p.correo_persona, u.correo)            AS correo_persona,
                    p.celular,
                    p.perfil,
                    p.residente,
                    p.edad,
                    p.genero,
                    p.id_vivienda
                FROM personas p
                LEFT JOIN usuarios u ON p.id_usuario = u.id_usuario
                WHERE p.id_persona = :id_persona
                LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();
        $persona = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($persona) {
            echo json_encode($persona);
        } else {
            echo json_encode(["error" => "Persona no encontrada"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["error" => "Error en la base de datos: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "ID no proporcionado"]);
}
?>