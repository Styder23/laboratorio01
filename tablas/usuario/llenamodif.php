<?php

// Importa la clase de conexión
require_once("../../conexion/conexion.php");

try {
    // Crea una instancia de la base de datos
    $conexionBD = BD::crearInstancia();

    // Verifica si el ID del usuario está presente en la solicitud
    if (isset($_GET['idusuario'])) {
        $idUsuario = intval($_GET['idusuario']);

        // Realiza una consulta para obtener los datos del usuario con el ID proporcionado
        $query = $conexionBD->prepare("
        SELECT u.idusuarios as idusuario,p.dni as DNI ,p.nombres as NOMBRE, p.apellidos AS APELLIDO, 
        p.fk_idgenero as GENERO,p.edad AS EDAD, u.tel_ref AS TELEFONO, p.direccion AS DIRECCION,
        p.correo AS CORREO, u.fk_idestablecimiento AS EESS, r.nom_red AS RED , u.fk_cargos AS CARGO,u.usuario AS USUARIO, u.contraseña as CONTRASEÑA
        FROM
        usuarios u JOIN personas p ON u.fk_personas = p.idpersonas
        INNER JOIN genero g ON g.idgenero=p.fk_idgenero
        INNER JOIN cargos c ON u.fk_cargos = c.idcargos
        INNER JOIN establecimiento e ON e.idestablecimiento=u.fk_idestablecimiento
        INNER JOIN redes r ON r.idredes=e.fk_redes
        WHERE u.idusuarios = ?
        ");

        $query->execute([$idUsuario]);

        // Verifica si se encontró el usuario
        if ($query->rowCount() > 0) {
            // Obtén los datos del usuario como un objeto asociativo
            $datosUsuario = $query->fetch(PDO::FETCH_ASSOC);
            
            // Devuelve los datos del usuario en formato JSON
            echo json_encode(['usuario' => $datosUsuario]);
        } else {
            // Si no se encontró el usuario, devuelve un mensaje de error
            echo json_encode(['error' => 'Usuario no encontrado.']);
        }
    } else {
        // Si no se proporciona un ID, devuelve un mensaje de error
        echo json_encode(['error' => 'ID del usuario no proporcionado.']);
    }
} catch (Exception $e) {
    // Manejo de excepciones
    echo json_encode(['error' => 'Hubo un error al procesar la solicitud: ' . $e->getMessage()]);
}

?>
