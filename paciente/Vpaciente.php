<?php
include('../tablas/examen/conexion.php');



// Define las columnas disponibles
$columns = [
    'id', 
    'DNI', 
    'PACIENTE', 
    'EDAD', 
    'DIRECCIÓN',
    'GENERO', 
    'CORREO', 
    'ruc',
];

// Consulta base
$sql = "SELECT * FROM v_pacientes";

// Manejo de búsqueda
if (isset($_POST['search']['value'])) {
    $search_value = mysqli_real_escape_string($con, $_POST['search']['value']);
    $sql .= " WHERE DNI LIKE '%" . $search_value . "%' OR PACIENTE LIKE '%" . $search_value . "%' OR DIRECCIÓN LIKE '%" . $search_value . "%' OR CORREO LIKE '%" . $search_value . "%'";
}

// Manejo de orden
if (isset($_POST['order'])) {
    $column_index = intval($_POST['order'][0]['column']);
    $column_order = mysqli_real_escape_string($con, $_POST['order'][0]['dir']);
    $sql .= " ORDER BY " . $columns[$column_index] . " " . $column_order;
} else {
    $sql .= " ORDER BY idpacientes DESC";
}

// Manejo de paginación
if (isset($_POST['length']) && $_POST['length'] != -1) {
    $start = intval($_POST['start']);
    $length = intval($_POST['length']);
    $sql .= " LIMIT " . $start . ", " . $length;
}

// Ejecuta la consulta
$result = mysqli_query($con, $sql);
if (!$result) {
    echo json_encode(['error' => 'Error en la consulta']);
    exit;
}

// Construye el array de datos
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        $row['id'],
        $row['DNI'],
        $row['PACIENTE'],
        $row['EDAD'],
        $row['DIRECCIÓN'],
        $row['GENERO'],
        $row['CORREO'],
        $row['ruc'],
        '<button class="btn btn-info btn-sm editbtn" data-idpacientes="' . $row['id'] . '">Editar</button> ' .
        '<button class="btn btn-danger btn-sm deleteBtn" data-idpacientes="' . $row['id'] . '">Eliminar</button>'
    ];
}

// Prepara la respuesta
$output = [
    'draw' => intval($_POST['draw']),
    'recordsTotal' => mysqli_num_rows(mysqli_query($con, "SELECT * FROM v_pacientes")),
    'recordsFiltered' => mysqli_num_rows($result),
    'data' => $data
];

// Devuelve la respuesta como JSON
echo json_encode($output);
?>


