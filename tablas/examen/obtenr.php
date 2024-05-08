<?php
include('conexion.php');

// Define las columnas disponibles
$columns = [
    'idexamen',
    'nomexam',
    'fk_idarea',
];

// Consulta base
$sql = "SELECT * FROM examen";

// Manejo de búsqueda
if (isset($_POST['search']['value'])) {
    $search_value = mysqli_real_escape_string($con, $_POST['search']['value']);
    $sql .= " WHERE nomexam LIKE '%" . $search_value . "%' OR fk_idarea LIKE '%" . $search_value . "%'";
}

// Manejo de orden
if (isset($_POST['order'])) {
    $column_index = intval($_POST['order'][0]['column']);
    $column_order = mysqli_real_escape_string($con, $_POST['order'][0]['dir']);
    $sql .= " ORDER BY " . $columns[$column_index] . " " . $column_order;
} else {
    $sql .= " ORDER BY idexamen DESC";
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
        $row['idexamen'],
        $row['nomexam'],
        $row['fk_idarea'],
        '<button class="btn btn-info btn-sm editbtn" data-idexamen="' . $row['idexamen'] . '">Editar</button> ' .
        '<button class="btn btn-danger btn-sm deleteBtn" data-idexamen="' . $row['idexamen'] . '">Eliminar</button>'
    ];
}

// Prepara la respuesta
$output = [
    'draw' => intval($_POST['draw']),
    'recordsTotal' => mysqli_num_rows(mysqli_query($con, "SELECT * FROM examen")),
    'recordsFiltered' => mysqli_num_rows($result),
    'data' => $data
];

// Devuelve la respuesta como JSON
echo json_encode($output);
?>
