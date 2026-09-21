<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// include __DIR__ . '/../config/conexion.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // 1. Recepción y normalización de variables
//     $raw_id_usuario = trim($_POST['id_usuario'] ?? '');
//     // Evalúa a INTEGER solo si trae un ID válido mayor a 0
//     $id_usuario     = (!empty($raw_id_usuario) && strtolower($raw_id_usuario) !== 'null' && (int)$raw_id_usuario > 0) ? (int)$raw_id_usuario : null;

//     $id_vivienda    = !empty($_POST['id_vivienda']) ? (int)$_POST['id_vivienda'] : null;
    
//     // Si viene vacío o espacio blanco, DEBE ser null para no romper las búsquedas
//     $nombre_persona = !empty(trim($_POST['nombre_persona'] ?? '')) ? trim($_POST['nombre_persona']) : null;
//     $numero_cedula  = !empty(trim($_POST['numero_cedula'] ?? '')) ? trim($_POST['numero_cedula']) : null;
//     $correo_persona = !empty(trim($_POST['correo_persona'] ?? '')) ? trim($_POST['correo_persona']) : null;
//     $celular        = !empty(trim($_POST['celular'] ?? '')) ? trim($_POST['celular']) : null;
    
//     // Valores con valor por defecto
//     $perfil         = !empty(trim($_POST['perfil'] ?? '')) ? trim($_POST['perfil']) : '';
//     $residente      = !empty(trim($_POST['residente'] ?? '')) ? trim($_POST['residente']) : '';
    
//     $edad           = (isset($_POST['edad']) && $_POST['edad'] !== '') ? (int)$_POST['edad'] : null;
//     $genero         = !empty(trim($_POST['genero'] ?? '')) ? trim($_POST['genero']) : null;

//     try {
//         $existente = null;

//         // 2. BÚSQUEDA DEL REGISTRO EXISTENTE

//         // Criterio 1: Buscar por id_usuario si viene presente
//         if ($id_usuario !== null) {
//             $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE id_usuario = ? LIMIT 1");
//             $stmtSearch->execute([$id_usuario]);
//             $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
//         }

//         // Criterio 2: Buscar por nombre solo si NO se encontró por id_usuario y SÍ enviaron un nombre no nulo
//         if (!$existente && $nombre_persona !== null) {
//             $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE LOWER(TRIM(nombre_persona)) = LOWER(TRIM(?)) LIMIT 1");
//             $stmtSearch->execute([$nombre_persona]);
//             $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
//         }

//         // 3. PROCESAMIENTO (ACTUALIZAR O INSERTAR)

//         if ($existente) {
//             // Función auxiliar: si la BD tiene NULL, vacío, '0' o 0, asigna el nuevo dato ingresado
//             $resolveValue = function ($currentDbValue, $newValue) {
//                 $isEmptyDb = ($currentDbValue === null || $currentDbValue === '' || $currentDbValue === 0 || $currentDbValue === '0');
//                 if ($isEmptyDb) {
//                     return $newValue;
//                 }
//                 return ($newValue !== null && $newValue !== '') ? $newValue : $currentDbValue;
//             };

//             $final_nombre    = $resolveValue($existente['nombre_persona'], $nombre_persona);
//             $final_cedula    = $resolveValue($existente['numero_cedula'], $numero_cedula);
//             $final_correo    = $resolveValue($existente['correo_persona'], $correo_persona);
//             $final_celular   = $resolveValue($existente['celular'], $celular);
//             $final_perfil    = $resolveValue($existente['perfil'], $perfil);
//             $final_residente = $resolveValue($existente['residente'], $residente);
//             $final_edad      = $resolveValue($existente['edad'], $edad);
//             $final_genero    = $resolveValue($existente['genero'], $genero);
//             $final_usuario   = $resolveValue($existente['id_usuario'], $id_usuario);
//             $final_vivienda  = $resolveValue($existente['id_vivienda'], $id_vivienda);

//             $sql = "UPDATE personas 
//                     SET nombre_persona = ?, numero_cedula = ?, correo_persona = ?, celular = ?, 
//                         perfil = ?, residente = ?, edad = ?, genero = ?, id_usuario = ?, id_vivienda = ?
//                     WHERE id_persona = ?";
//             $stmt = $conn->prepare($sql);
//             $stmt->execute([
//                 $final_nombre, $final_cedula, $final_correo, $final_celular,
//                 $final_perfil, $final_residente, $final_edad, $final_genero,
//                 $final_usuario, $final_vivienda, $existente['id_persona']
//             ]);

//             echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente"]);

//         } else {
//             // Si no existía, inserta el nuevo registro
//             $sql = "INSERT INTO personas 
//                     (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
//                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
//             $stmt = $conn->prepare($sql);
//             $stmt->execute([
//                 $nombre_persona, $numero_cedula, $correo_persona, $celular,
//                 $perfil, $residente, $edad, $genero, $id_usuario, $id_vivienda
//             ]);

//             echo json_encode(["status" => "success", "message" => "Nuevo residente registrado"]);
//         }

//     } catch (PDOException $e) {
//         echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
//     }
// }

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// include __DIR__ . '/../config/conexion.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // 1. Recepción y normalización de variables
//     $raw_id_usuario = trim($_POST['id_usuario'] ?? '');
//     $id_usuario     = (!empty($raw_id_usuario) && strtolower($raw_id_usuario) !== 'null' && (int)$raw_id_usuario > 0) ? (int)$raw_id_usuario : null;

//     $id_vivienda    = !empty($_POST['id_vivienda']) ? (int)$_POST['id_vivienda'] : null;
//     $edad           = (isset($_POST['edad']) && $_POST['edad'] !== '') ? (int)$_POST['edad'] : null;
//     $genero         = !empty(trim($_POST['genero'] ?? '')) ? trim($_POST['genero']) : null;

//     // Campos personales opcionales (Solo se usarán si NO es un usuario del sistema)
//     $nombre_persona = !empty(trim($_POST['nombre_persona'] ?? '')) ? trim($_POST['nombre_persona']) : null;
//     $numero_cedula  = !empty(trim($_POST['numero_cedula'] ?? '')) ? trim($_POST['numero_cedula']) : null;
//     $correo_persona = !empty(trim($_POST['correo_persona'] ?? '')) ? trim($_POST['correo_persona']) : null;
//     $celular        = !empty(trim($_POST['celular'] ?? '')) ? trim($_POST['celular']) : '';
//     $perfil         = !empty(trim($_POST['perfil'] ?? '')) ? trim($_POST['perfil']) : 'Residente';
//     $residente      = !empty(trim($_POST['residente'] ?? '')) ? trim($_POST['residente']) : 'Si';

//     try {
//         $existente = null;

//         // 2. BÚSQUEDA DEL REGISTRO EXISTENTE
//         if ($id_usuario !== null) {
//             // Criterio A: Buscar por id_usuario
//             $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE id_usuario = ? LIMIT 1");
//             $stmtSearch->execute([$id_usuario]);
//             $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
//         } elseif ($nombre_persona !== null) {
//             // Criterio B: Si no hay id_usuario, buscar por nombre para independientes/familiares
//             $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE LOWER(TRIM(nombre_persona)) = LOWER(TRIM(?)) LIMIT 1");
//             $stmtSearch->execute([$nombre_persona]);
//             $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
//         }

//         // 3. PROCESAMIENTO SEGÚN EL TIPO DE REGISTRO

//         if ($existente) {
//             // CASO 1: YA EXISTE EN LA TABLA PERSONAS -> ACTUALIZAR
//             if ($existente['id_usuario'] !== null || $id_usuario !== null) {
//                 // Si es un usuario del sistema, SOLO actualizamos edad, genero e id_vivienda.
//                 // Los datos personales (nombre, cedula, correo, celular) se dejan NULL en personas para no duplicar la tabla usuarios.
//                 $sql = "UPDATE personas 
//                         SET edad = ?, genero = ?, id_vivienda = ?
//                         WHERE id_persona = ?";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([$edad, $genero, $id_vivienda, $existente['id_persona']]);
//             } else {
//                 // Si es una persona independiente (sin usuario), se actualizan sus datos normalmente
//                 $sql = "UPDATE personas 
//                         SET nombre_persona = ?, numero_cedula = ?, correo_persona = ?, celular = ?, 
//                             perfil = ?, residente = ?, edad = ?, genero = ?, id_vivienda = ?
//                         WHERE id_persona = ?";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([
//                     $nombre_persona, $numero_cedula, $correo_persona, $celular,
//                     $perfil, $residente, $edad, $genero, $id_vivienda, $existente['id_persona']
//                 ]);
//             }

//             echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente"]);

//         } else {
//             // CASO 2: NO EXISTE EN LA TABLA PERSONAS -> INSERTAR
//             if ($id_usuario !== null) {
//                 // Insertar vinculado a id_usuario: nombre, cédula, correo y celular se insertan explícitamente como NULL
//                 $sql = "INSERT INTO personas 
//                         (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
//                         VALUES (NULL, NULL, NULL, NULL, ?, ?, ?, ?, ?, ?)";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([$perfil, $residente, $edad, $genero, $id_usuario, $id_vivienda]);
//             } else {
//                 // Insertar persona independiente sin usuario (familiar / dependiente)
//                 $sql = "INSERT INTO personas 
//                         (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
//                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL, ?)";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([
//                     $nombre_persona, $numero_cedula, $correo_persona, $celular,
//                     $perfil, $residente, $edad, $genero, $id_vivienda
//                 ]);
//             }

//             echo json_encode(["status" => "success", "message" => "Residente registrado exitosamente"]);
//         }

//     } catch (PDOException $e) {
//         echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
//     }
// }


// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// include __DIR__ . '/../config/conexion.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // 1. Recepción y normalización de variables
//     $raw_id_usuario = trim($_POST['id_usuario'] ?? '');
//     $id_usuario     = (!empty($raw_id_usuario) && strtolower($raw_id_usuario) !== 'null' && (int)$raw_id_usuario > 0) ? (int)$raw_id_usuario : null;

//     $id_vivienda    = !empty($_POST['id_vivienda']) ? (int)$_POST['id_vivienda'] : null;
//     $edad           = (isset($_POST['edad']) && $_POST['edad'] !== '') ? (int)$_POST['edad'] : null;
//     $genero         = !empty(trim($_POST['genero'] ?? '')) ? trim($_POST['genero']) : null;
//     $celular        = !empty(trim($_POST['celular'] ?? '')) ? trim($_POST['celular']) : null;

//     // Campos personales que se mantienen NULL si es un id_usuario registrado
//     $nombre_persona = !empty(trim($_POST['nombre_persona'] ?? '')) ? trim($_POST['nombre_persona']) : null;
//     $numero_cedula  = !empty(trim($_POST['numero_cedula'] ?? '')) ? trim($_POST['numero_cedula']) : null;
//     $correo_persona = !empty(trim($_POST['correo_persona'] ?? '')) ? trim($_POST['correo_persona']) : null;
//     $perfil         = !empty(trim($_POST['perfil'] ?? '')) ? trim($_POST['perfil']) : 'Residente';
//     $residente      = !empty(trim($_POST['residente'] ?? '')) ? trim($_POST['residente']) : 'Si';

//     try {
//         $existente = null;

//         // 2. BÚSQUEDA DEL REGISTRO EXISTENTE
//         if ($id_usuario !== null) {
//             // Criterio A: Buscar por id_usuario
//             $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE id_usuario = ? LIMIT 1");
//             $stmtSearch->execute([$id_usuario]);
//             $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
//         } elseif ($nombre_persona !== null) {
//             // Criterio B: Si no hay id_usuario, buscar por nombre
//             $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE LOWER(TRIM(nombre_persona)) = LOWER(TRIM(?)) LIMIT 1");
//             $stmtSearch->execute([$nombre_persona]);
//             $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
//         }

//         // 3. PROCESAMIENTO

//         if ($existente) {
//             // CASO 1: YA EXISTE -> ACTUALIZAR
//             if ($existente['id_usuario'] !== null || $id_usuario !== null) {
//                 // Si está vinculado a id_usuario: Actualiza edad, género, id_vivienda Y celular.
//                 // Los demás campos (nombre, cédula, correo) se mantienen NULL para evitar duplicar usuarios.
//                 $sql = "UPDATE personas 
//                         SET edad = ?, genero = ?, id_vivienda = ?, celular = ?
//                         WHERE id_persona = ?";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([$edad, $genero, $id_vivienda, $celular, $existente['id_persona']]);
//             } else {
//                 // Si es persona sin cuenta de usuario, actualiza todos sus campos
//                 $sql = "UPDATE personas 
//                         SET nombre_persona = ?, numero_cedula = ?, correo_persona = ?, celular = ?, 
//                             perfil = ?, residente = ?, edad = ?, genero = ?, id_vivienda = ?
//                         WHERE id_persona = ?";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([
//                     $nombre_persona, $numero_cedula, $correo_persona, $celular,
//                     $perfil, $residente, $edad, $genero, $id_vivienda, $existente['id_persona']
//                 ]);
//             }

//             echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente"]);

//         } else {
//             // CASO 2: NO EXISTE -> INSERTAR
//             if ($id_usuario !== null) {
//                 // Insertar para usuario del sistema (guarda celular, perfil, residente, edad, genero, id_vivienda)
//                 $sql = "INSERT INTO personas 
//                         (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
//                         VALUES (NULL, NULL, NULL, ?, ?, ?, ?, ?, ?, ?)";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([$celular, $perfil, $residente, $edad, $genero, $id_usuario, $id_vivienda]);
//             } else {
//                 // Insertar persona independiente sin cuenta de usuario
//                 $sql = "INSERT INTO personas 
//                         (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
//                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL, ?)";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([
//                     $nombre_persona, $numero_cedula, $correo_persona, $celular,
//                     $perfil, $residente, $edad, $genero, $id_vivienda
//                 ]);
//             }

//             echo json_encode(["status" => "success", "message" => "Residente registrado exitosamente"]);
//         }

//     } catch (PDOException $e) {
//         echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
//     }
// }

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// include __DIR__ . '/../config/conexion.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // 1. Recepción y limpieza estricta del id_usuario
//     $raw_id_usuario = isset($_POST['id_usuario']) ? trim((string)$_POST['id_usuario']) : '';
//     $id_usuario     = ($raw_id_usuario !== '' && strtolower($raw_id_usuario) !== 'null' && (int)$raw_id_usuario > 0) ? (int)$raw_id_usuario : null;

//     $id_vivienda    = !empty($_POST['id_vivienda']) ? (int)$_POST['id_vivienda'] : null;
//     $edad           = (isset($_POST['edad']) && $_POST['edad'] !== '') ? (int)$_POST['edad'] : null;
//     $genero         = !empty(trim($_POST['genero'] ?? '')) ? trim($_POST['genero']) : null;
//     $celular_input  = !empty(trim($_POST['celular'] ?? '')) ? trim($_POST['celular']) : null;

//     // Campos de personas independientes (sin usuario registrado)
//     $nombre_persona = !empty(trim($_POST['nombre_persona'] ?? '')) ? trim($_POST['nombre_persona']) : null;
//     $numero_cedula  = !empty(trim($_POST['numero_cedula'] ?? '')) ? trim($_POST['numero_cedula']) : null;
//     $correo_persona = !empty(trim($_POST['correo_persona'] ?? '')) ? trim($_POST['correo_persona']) : null;
//     $perfil         = !empty(trim($_POST['perfil'] ?? '')) ? trim($_POST['perfil']) : 'Residente';
//     $residente      = !empty(trim($_POST['residente'] ?? '')) ? trim($_POST['residente']) : 'Si';

//     try {
//         $existente = null;

//         // 2. BÚSQUEDA PRIORITARIA
//         // Prioridad 1: Buscar por id_usuario en la tabla personas
//         if ($id_usuario !== null) {
//             $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE id_usuario = ? LIMIT 1");
//             $stmtSearch->execute([$id_usuario]);
//             $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
//         }

//         // Prioridad 2: Solo si NO se encontró por id_usuario Y enviaron un nombre
//         if (!$existente && $nombre_persona !== null) {
//             $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE LOWER(TRIM(nombre_persona)) = LOWER(TRIM(?)) LIMIT 1");
//             $stmtSearch->execute([$nombre_persona]);
//             $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
//         }

//         // 3. EJECUCIÓN (UPDATE / INSERT)

//         if ($existente) {
//             // CASO: REGISTRO EXISTE -> ACTUALIZAR
            
//             // Preservar el celular previo si no se envía uno nuevo
//             $final_celular = $celular_input ?? $existente['celular'] ?? '';

//             if ($existente['id_usuario'] !== null || $id_usuario !== null) {
//                 // SI TIENE USER_ID: SOLO actualiza genero, edad e id_vivienda (y celular si no es nulo)
//                 $sql = "UPDATE personas 
//                         SET genero = ?, edad = ?, id_vivienda = ?, celular = ?
//                         WHERE id_persona = ?";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([$genero, $edad, $id_vivienda, $final_celular, $existente['id_persona']]);
//             } else {
//                 // SI ES PERSONA SIN USUARIO: actualiza todos los campos
//                 $final_nombre = $nombre_persona ?? $existente['nombre_persona'] ?? '';
//                 $final_cedula = $numero_cedula ?? $existente['numero_cedula'] ?? '';
//                 $final_correo = $correo_persona ?? $existente['correo_persona'] ?? '';

//                 $sql = "UPDATE personas 
//                         SET nombre_persona = ?, numero_cedula = ?, correo_persona = ?, celular = ?, 
//                             perfil = ?, residente = ?, edad = ?, genero = ?, id_vivienda = ?
//                         WHERE id_persona = ?";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([
//                     $final_nombre, $final_cedula, $final_correo, $final_celular,
//                     $perfil, $residente, $edad, $genero, $id_vivienda, $existente['id_persona']
//                 ]);
//             }

//             echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente"]);

//         } else {
//             // CASO: NO EXISTE REGISTRO PREVIO -> INSERTAR
            
//             $celular_insert = $celular_input ?? '';

//             if ($id_usuario !== null) {
//                 // Insertar asociando al usuario registrado
//                 $sql = "INSERT INTO personas 
//                         (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
//                         VALUES (NULL, NULL, NULL, ?, ?, ?, ?, ?, ?, ?)";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([$celular_insert, $perfil, $residente, $edad, $genero, $id_usuario, $id_vivienda]);
//             } else {
//                 // Insertar persona independiente (familiar sin cuenta)
//                 $sql = "INSERT INTO personas 
//                         (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
//                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL, ?)";
//                 $stmt = $conn->prepare($sql);
//                 $stmt->execute([
//                     $nombre_persona, $numero_cedula, $correo_persona, $celular_insert,
//                     $perfil, $residente, $edad, $genero, $id_vivienda
//                 ]);
//             }

//             echo json_encode(["status" => "success", "message" => "Registro guardado exitosamente"]);
//         }

//     } catch (PDOException $e) {
//         echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
//     }
// }

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include __DIR__ . '/../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recepción y normalización de variables
    $raw_id_usuario = isset($_POST['id_usuario']) ? trim((string)$_POST['id_usuario']) : '';
    $id_usuario     = ($raw_id_usuario !== '' && strtolower($raw_id_usuario) !== 'null' && (int)$raw_id_usuario > 0) ? (int)$raw_id_usuario : null;

    // Solo capturamos edad, genero e id_vivienda
    $id_vivienda    = !empty($_POST['id_vivienda']) ? (int)$_POST['id_vivienda'] : null;
    $edad           = (isset($_POST['edad']) && $_POST['edad'] !== '') ? (int)$_POST['edad'] : null;
    $genero         = !empty(trim($_POST['genero'] ?? '')) ? trim($_POST['genero']) : null;

    // Campos de personas independientes (sin usuario)
    $nombre_persona = !empty(trim($_POST['nombre_persona'] ?? '')) ? trim($_POST['nombre_persona']) : null;
    $numero_cedula  = !empty(trim($_POST['numero_cedula'] ?? '')) ? trim($_POST['numero_cedula']) : null;
    $correo_persona = !empty(trim($_POST['correo_persona'] ?? '')) ? trim($_POST['correo_persona']) : null;
    $celular        = !empty(trim($_POST['celular'] ?? '')) ? trim($_POST['celular']) : '';
    $perfil         = !empty(trim($_POST['perfil'] ?? '')) ? trim($_POST['perfil']) : 'propietario';
    $residente      = !empty(trim($_POST['residente'] ?? '')) ? trim($_POST['residente']) : 'Si';

    try {
        $existente = null;

        // 2. BÚSQUEDA DEL REGISTRO EXISTENTE
        if ($id_usuario !== null) {
            // Buscar por id_usuario (Ej: encontrar id_persona = 66)
            $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE id_usuario = ? LIMIT 1");
            $stmtSearch->execute([$id_usuario]);
            $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
        }

        if (!$existente && $nombre_persona !== null) {
            $stmtSearch = $conn->prepare("SELECT * FROM personas WHERE LOWER(TRIM(nombre_persona)) = LOWER(TRIM(?)) LIMIT 1");
            $stmtSearch->execute([$nombre_persona]);
            $existente = $stmtSearch->fetch(PDO::FETCH_ASSOC);
        }

        // 3. ACTUALIZACIÓN O INSERCIÓN

        if ($existente) {
            // CASO: REGISTRO EXISTE -> ACTUALIZAR
            if ($existente['id_usuario'] !== null || $id_usuario !== null) {
                // ESTRUCTURA EXCLUSIVA PARA USUARIOS: 
                // ÚNICAMENTE actualiza edad, genero e id_vivienda. No modifica el celular ni los datos en NULL.
                $sql = "UPDATE personas 
                        SET edad = ?, genero = ?, id_vivienda = ?
                        WHERE id_persona = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$edad, $genero, $id_vivienda, $existente['id_persona']]);
            } else {
                // Caso para familiares / personas sin usuario registrado
                $sql = "UPDATE personas 
                        SET nombre_persona = ?, numero_cedula = ?, correo_persona = ?, celular = ?, 
                            perfil = ?, residente = ?, edad = ?, genero = ?, id_vivienda = ?
                        WHERE id_persona = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    $nombre_persona, $numero_cedula, $correo_persona, $celular,
                    $perfil, $residente, $edad, $genero, $id_vivienda, $existente['id_persona']
                ]);
            }

            echo json_encode(["status" => "success", "message" => "Datos actualizados correctamente"]);

        } else {
            // CASO: REGISTRO NUEVO -> INSERTAR
            if ($id_usuario !== null) {
                $sql = "INSERT INTO personas 
                        (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
                        VALUES (NULL, NULL, NULL, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$celular, $perfil, $residente, $edad, $genero, $id_usuario, $id_vivienda]);
            } else {
                $sql = "INSERT INTO personas 
                        (nombre_persona, numero_cedula, correo_persona, celular, perfil, residente, edad, genero, id_usuario, id_vivienda) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    $nombre_persona, $numero_cedula, $correo_persona, $celular,
                    $perfil, $residente, $edad, $genero, $id_vivienda
                ]);
            }

            echo json_encode(["status" => "success", "message" => "Registro guardado exitosamente"]);
        }

    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Error en la base de datos: " . $e->getMessage()]);
    }
}
?>
