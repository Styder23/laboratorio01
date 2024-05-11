<?php

// Importa la clase de conexión
require_once("../../conexion/conexion.php");

try {
    // Crea una instancia de la base de datos
    $conexionBD = BD::crearInstancia();

    // Verifica si se recibió una solicitud POST y un parámetro GET con el ID del paciente
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
        // Obtener el ID del paciente de la URL
        $idPaciente = intval($_GET['id']);

        // Verifica que se han enviado los campos del formulario necesarios
        if (isset($_POST['dni']) && isset($_POST['nombres']) && isset($_POST['apellidos']) &&
            isset($_POST['edad']) && isset($_POST['direccion']) && isset($_POST['genero']) &&
            isset($_POST['correo']) && isset($_POST['ruc'])) {
            
            // Extraer los datos del formulario
            $dni = $_POST['dni'];
            $nombres = $_POST['nombres'];
            $apellidos = $_POST['apellidos'];
            $edad = intval($_POST['edad']);
            $direccion = $_POST['direccion'];
            $genero = intval($_POST['genero']);
            $correo = $_POST['correo'];
            $ruc = $_POST['ruc'];

            // Prepara y ejecuta la llamada al procedimiento almacenado
            $stmt = $conexionBD->prepare("CALL pro_Uppaciente(?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $idPaciente, PDO::PARAM_INT);
            $stmt->bindParam(2, $dni, PDO::PARAM_STR);
            $stmt->bindParam(3, $nombres, PDO::PARAM_STR);
            $stmt->bindParam(4, $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(5, $edad, PDO::PARAM_INT);
            $stmt->bindParam(6, $direccion, PDO::PARAM_STR);
            $stmt->bindParam(7, $genero, PDO::PARAM_INT);
            $stmt->bindParam(8, $correo, PDO::PARAM_STR);
            $stmt->bindParam(9, $ruc, PDO::PARAM_STR);

            // Ejecutar el procedimiento almacenado
            $stmt->execute();

            // Recoge el mensaje del procedimiento almacenado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cierra el cursor
            $stmt->closeCursor();

            // Devuelve la respuesta en formato JSON
            // Asegúrate de que el objeto JSON contiene siempre una clave 'mensaje'
            if (isset($resultado['mensaje'])) {
                echo json_encode(['mensaje' => $resultado['mensaje']]);
            } else {
                echo json_encode(['error' => 'No se recibió un mensaje de éxito del procedimiento almacenado']);
            }
        } else {
            // Si falta algún campo del formulario, devuelve un mensaje de error
            echo json_encode(['error' => 'Faltan datos en la solicitud POST.']);
        }
    } else {
        // Si no se recibió una solicitud POST o no se recibió el ID del paciente, devuelve un mensaje de error
        echo json_encode(['error' => 'Método de solicitud no válido o ID del paciente no proporcionado.']);
    }
} catch (Exception $e) {
    // Manejar excepciones y devolver el error en formato JSON
    echo json_encode(['error' => 'Hubo un error al procesar la solicitud: ' . $e->getMessage()]);
}

?>
