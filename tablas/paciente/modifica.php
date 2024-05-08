<?php

// Importa la clase de conexión
require_once("../../conexion/conexion.php");

try {
    // Crea una instancia de la base de datos
    $conexionBD = BD::crearInstancia();

    // Verifica si el ID del paciente está presente en la solicitud
    if (isset($_GET['id'])) {
        $idPaciente = intval($_GET['id']);

        // Realiza una consulta para obtener los datos del paciente con el ID proporcionado
        $query = $conexionBD->prepare("SELECT pa.idpacientes AS id, p.dni AS DNI, p.nombres AS NOMBRE, 
                                       p.apellidos AS APELLIDO, p.edad AS EDAD, p.direccion AS DIRECCIÓN, 
                                       p.correo AS CORREO, pa.ruc AS RUC, pa.estadopaci AS ESTADO,
                                       p.fk_idgenero AS GENERO_ID
                                       FROM pacientes pa
                                       JOIN personas p ON pa.fk_idpersona = p.idpersonas
                                       WHERE pa.idpacientes = ?");
        $query->execute([$idPaciente]);

        // Verifica si se encontró el paciente
        if ($query->rowCount() > 0) {
            // Obtén los datos del paciente como un objeto asociativo
            $datosPaciente = $query->fetch(PDO::FETCH_ASSOC);

            // Devuelve los datos del paciente en formato JSON
            echo json_encode(['paciente' => $datosPaciente]);
        } else {
            // Si no se encontró el paciente, devuelve un mensaje de error
            echo json_encode(['error' => 'Paciente no encontrado.']);
        }
    } else {
        // Si no se proporciona un ID, devuelve un mensaje de error
        echo json_encode(['error' => 'ID del paciente no proporcionado.']);
    }
} catch (Exception $e) {
    // Manejo de excepciones
    echo json_encode(['error' => 'Hubo un error al procesar la solicitud: ' . $e->getMessage()]);
}

?>