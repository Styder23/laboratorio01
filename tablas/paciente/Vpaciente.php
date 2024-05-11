<?php
require '../../conexion/config.php';

// Especifica las columnas que quieres seleccionar de la base de datos
$columnas = ["id", "DNI", "PACIENTE", "EDAD", "DIRECCIÓN" ,"GENERO", "CORREO", "ruc"];

// Especifica la tabla que quieres consultar
$tabla = "v_pacientes";

// Obtiene el valor del campo 'campo' enviado por el cliente (si existe)
$campo = isset($_POST["campo"]) ? $conectar->real_escape_string($_POST["campo"]) : null;
$limit = isset($_POST["n_registro"]) ? intval($_POST["n_registro"]) : 10;
$pagina = isset($_POST["pagina"]) ? intval($_POST["pagina"]) : 1;

// Inicializa la cláusula WHERE si se proporciona un campo de búsqueda
$where = "";
if ($campo !== null) {
    $where = "WHERE ";
    foreach ($columnas as $columna) {
        $where .= "$columna LIKE '%$campo%' OR ";
    }
    // Elimina el último "OR" de la cláusula WHERE
    $where = substr($where, 0, -4);
}

// Calcular el punto de partida para la paginación
$inicio = ($pagina - 1) * $limit;

// Obtener el total de registros para calcular las páginas
$total_sql = "SELECT COUNT(*) AS total FROM $tabla $where";
$total_result = $conectar->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_registros = $total_row["total"];

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $limit);

// Consulta SQL con paginación
$sql = "SELECT " . implode(", ", $columnas) . " FROM $tabla $where LIMIT $inicio, $limit";
$resultado = $conectar->query($sql);

// Almacena los resultados en un array
$resultados = [];
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $resultados[] = $row;
    }
} else {
    // Si no hay resultados, devuelve un mensaje especial
    $resultados[] = ['mensaje' => 'Sin resultados'];
}

// Envía los resultados como JSON, incluyendo la información de paginación
header('Content-Type: application/json');
echo json_encode([
    'resultados' => $resultados,
    'total_paginas' => $total_paginas,
    'pagina_actual' => $pagina,
    'total_registros' => $total_registros,
], JSON_UNESCAPED_UNICODE);
?>
