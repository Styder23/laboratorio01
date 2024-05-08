<?php

// Seguridad de sesiones
session_start();
// Incluye la conexión a la base de datos
include('conexion.php');

// Realiza la consulta a la base de datos
$query = $con->query("SELECT idarea, nomarea FROM area");

// Verifica que la consulta sea exitosa
if (!$query) {
    die('Error en la consulta a la base de datos');
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/datatables.min.css" rel="stylesheet">

    <title>Exámenes</title>
</head>

<body>
    <h1 class="text-center">Exámenes</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <button type="button" style="margin-bottom: 40px;" class="btn btn-primary"
                            data-bs-toggle="modal" data-bs-target="#agregarexamen">
                            Nuevo examen
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <table id="datatable" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Examen</th>
                                    <th>Área</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Datos de la tabla se cargarán desde el servidor -->
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // Inicializar DataTable
            var table = $('#datatable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: 'obtenr.php',
                    type: 'POST',
                },
                columnDefs: [
                    {
                        targets: [0, 3],
                        orderable: false,
                    }
                ]
            });

            // Agregar examen
            $(document).on('submit', '#frmexam', function (event) {
                event.preventDefault();

                var examen = $('#examen').val();
                var area = $('#area').val();

                if (examen && area) {
                    $.ajax({
                        url: 'addexam.php',
                        method: 'POST',
                        data: {
                            examen: examen,
                            area: area
                        },
                        success: function (data) {
                            try {
                                var json = JSON.parse(data);
                                if (json.status === 'success') {
                                    table.draw();
                                    alert('Examen agregado correctamente');
                                    $('#examen').val('');
                                    $('#area').val('');
                                    $('#agregarexamen').modal('hide');
                                } else {
                                    alert('Error al agregar el examen');
                                }
                            } catch (e) {
                                console.error('Error al analizar JSON:', e);
                                alert('Error al procesar respuesta del servidor');
                            }
                        },
                        error: function () {
                            alert('Error en la solicitud AJAX');
                        }
                    });
                } else {
                    alert('Complete todos los campos');
                }
            });

            // Cargar datos para editar examen
            $(document).on('click', '.editbtn', function () {
                var id = $(this).data('idexamen');
                $.ajax({
                    url: 'carga.php',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function (data) {
                        try {
                            var json = JSON.parse(data);
                            if (json) {
                                $('#idexamen').val(json.idexamen);
                                $('#_examen').val(json.nomexam);
                                $('#_area').val(json.fk_idarea);
                                $('#editexmmodal').modal('show');
                            } else {
                                alert('No se encontraron datos para este examen');
                            }
                        } catch (e) {
                            console.error('Error al analizar JSON:', e);
                            alert('Error al procesar respuesta del servidor');
                        }
                    },
                    error: function () {
                        alert('Error al cargar datos para edición');
                    }
                });
            });

            // Editar examen
            $(document).on('submit', '#editExamenForm', function (event) {
                event.preventDefault();

                // Verificar que todas las variables estén definidas
                var idexamen = $('#idexamen').val();
                var examen = $('#_examen').val();
                var area = $('#_area').val();

                if (!idexamen || !examen || !area) {
                    alert('Complete todos los campos');
                    return;
                }

                $.ajax({
                    url: 'updaexam.php',
                    method: 'POST',
                    data: {
                        idexamen: idexamen,
                        examen: examen,
                        area: area
                    },
                    success: function (data) {
                        try {
                            var json = JSON.parse(data);
                            if (json.status === 'success') {
                                table.draw();
                                alert('Examen editado correctamente');
                                $('#editexmmodal').modal('hide');
                            } else {
                                alert('Error al editar el examen');
                            }
                        } catch (e) {
                            console.error('Error al analizar JSON:', e);
                            alert('Error al procesar respuesta del servidor');
                        }
                    },
                    error: function () {
                        alert('Error en la solicitud AJAX');
                    }
                });
            });
        });
    </script>

    <!-- Modal agregar examen -->
    <div class="modal fade" id="agregarexamen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="agregarexamenLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarexamenLabel">Agregar Examen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form id="frmexam" action="javascript:void(0);" method="POST">
                    <div class="modal-body">
                        <!-- Formulario -->
                        <div class="mb-3 row">
                            <label for="examen" class="col-sm-2 col-form-label">Examen</label>
                            <div class="col-sm-10">
                                <input type="text" name="examen" class="form-control" id="examen"
                                    placeholder="Ingrese examen" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="area" class="col-sm-2 col-form-label">Área clínica</label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="area" id="area"
                                    required>
                                    <option value="" selected>--Seleccione--</option>
                                    <?php
                                    // Recorre los resultados de la consulta
                                    while ($row = $query->fetch_assoc()) {
                                        echo '<option value="' . $row['idarea'] . '">' . $row['nomarea'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal editar examen -->
    <div class="modal fade" id="editexmmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editExamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExamModalLabel">Modificar Examen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form id="editExamenForm" action="javascript:void(0);" method="POST">
                    <div class="modal-body">
                        <input type="hidden" id="idexamen" name="idexamen">

                        <div class="mb-3 row">
                            <label for="_examen" class="col-sm-2 col-form-label">Examen</label>
                            <div class="col-sm-10">
                                <input type="text" name="_examen" class="form-control" id="_examen"
                                    placeholder="Ingrese examen" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="_area" class="col-sm-2 col-form-label">Área clínica</label>
                            <div class="col-sm-10">
                                <select class="form-select" aria-label="Default select example" name="_area" id="_area"
                                    required>
                                    <option value="" selected>--Seleccione--</option>
                                    <?php
                                    // Vuelve a cargar los datos de la consulta
                                    mysqli_data_seek($query, 0); // Reiniciar el puntero de resultados
                                    while ($row = $query->fetch_assoc()) {
                                        echo '<option value="' . $row['idarea'] . '">' . $row['nomarea'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
