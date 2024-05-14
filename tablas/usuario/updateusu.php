<?php

include('../examen/conexion.php');
// Verifica si se recibieron los datos requeridos en la solicitud POST
if (isset($_POST['_id'], $_POST['_dni'], $_POST['_nombres'], $_POST['_apellidos'], $_POST['_edad'], $_POST['_direccion'], $_POST['_genero'], $_POST['_correo'], $_POST['_ruc'], $_POST['_telefono'], $_POST['_eess'], $_POST['_cargo'], $_POST['_usuario'], $_POST['_contraseña'])) {
    echo json_encode(['status' => 'false', 'message' => 'Faltan datos en la solicitud']);
    exit;
}
            // Extraer los datos del formulario
            $id = intval($_POST['idPaciente']);
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $genero = intval($_POST['genero']);
            $edad = intval($_POST['edad']);
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $correo = $_POST['correo'];
            $eess = intval($_POST['eess']);
            $cargo = intval($_POST['cargo']);
            $usuario = $_POST['usuario'];
            $contraseña = $_POST['contraseña'];
// Manejo de excepciones para la consulta
try {
    // Prepara la declaración
    $sql = "CALL pro_UpUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    if (!$stmt) {
        throw new Exception('Error preparando la consulta SQL');
    }
    // Vincula los parámetros
    $stmt->bind_param('isssiisssiiss', $id, $dni, $nombres, $apellidos, $genero, $edad, $telefono, $direccion, $correo,$eess,$cargo,$usuario,$contraseña);
    // Ejecuta la consulta
    if ($stmt->execute()) {
        echo json_encode(['status' => 'true', 'message' => 'Paciente actualizado correctamente']);
    } else {
        throw new Exception('Error al actualizar el paciente');
    }

    // Cierra la declaración
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'false', 'message' => $e->getMessage()]);
}

// Cierra la conexión a la base de datos
$con->close();           



?>
