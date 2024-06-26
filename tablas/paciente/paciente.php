<?php

// Seguridad de sesiones
session_start();
// Incluye la conexión a la base de datos
include('../examen/conexion.php');

// Realiza la consulta a la base de datos
$query = $con->query("SELECT idgenero, nom_gen FROM genero");
$query1 = $con->query("SELECT idgenero, nom_gen FROM genero");

// Verifica que la consulta sea exitosa
if (!$query) {
    die('Error en la consulta a la base de datos');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pacientes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/datatables.min.css" rel="stylesheet">
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
                            data-bs-toggle="modal" data-bs-target="#registroModal">
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
                                    <th>ID</th>
                                    <th>DNI</th>
                                    <th>PACIENTE</th>
                                    <th>EDAD</th>
                                    <th>DIRECCIÓN</th>
                                    <th>GENERO</th>
                                    <th>CORREO</th>
                                    <th>RUC</th>
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
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/datatables.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        // Inicializar DataTable
        var table = $('#datatable').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: 'Vpaciente.php',
                type: 'POST',
            },
            columnDefs: [{
                targets: [0, 3],
                orderable: false,
            }]
        });

        // Agregar paciente
        $(document).on('submit', '#registroForm', function(event) {
            event.preventDefault();

            var dni = $('#dni').val();
            var nombre = $('#nombres').val();
            var apellido = $('#apellidos').val();
            var edad = $('#edad').val();
            var direccion = $('#direccion').val();
            var genero = $('#genero').val();
            var correo = $('#correo').val();
            var ruc = $('#ruc').val();

            if (dni && nombre && apellido && edad && direccion && genero && correo && ruc) {
                $.ajax({
                    url: 'crudpaciente.php',
                    method: 'POST',
                    data: {
                        dni: dni,
                        nombre: nombre,
                        apellido: apellido,
                        edad: edad,
                        direccion: direccion,
                        genero: genero,
                        correo: correo,
                        ruc: ruc
                    },
                    success: function(data) {
                        try {
                            var json = JSON.parse(data);
                            if (json.status == 'success') {
                                table.draw();
                                alert('Paciente agregado correctamente');
                                $('#dni').val('');
                                $('#nombres').val('');
                                $('#apellidos').val('');
                                $('#edad').val('');
                                $('#direccion').val('');
                                $('#genero').val('');
                                $('#correo').val('');
                                $('#ruc').val('');
                                $('#registroModal').modal('hide');
                            } else {
                                alert('Error al agregar el paciente');
                            }
                        } catch (e) {
                            console.error('Error al analizar JSON:', e);
                            alert('Error al procesar respuesta del servidor');
                        }
                    },
                    error: function() {
                        alert('Error en la solicitud AJAX');
                    }
                });
            } else {
                alert('Complete todos los campos');
            }
        });

        // Cargar datos para editar paciente
        $(document).on('click', '.editbtn', function() {
            var id = $(this).data('idpacientes');
            $.ajax({
                url: 'modifica.php',
                method: 'POST',
                data: {
                    id: id
                },
                success: function(data) {
                    try {
                        var json = JSON.parse(data);
                        if (json) {
                            console.log(json); // Verifica los datos recibidos en la consola
                            $('#idexamen').val(json.id);                 
                            $('#_dni').val(json.DNI);
                            $('#_nombres').val(json.NOMBRE);
                            $('#_apellidos').val(json.APELLIDO);
                            $('#_edad').val(json.EDAD);
                            $('#_direccion').val(json.DIRECCIÓN);
                            $('#_genero').val(json.GENERO);
                            $('#_correo').val(json.CORREO);
                            $('#_ruc').val(json.ruc);
                            $('#_id').val(json.id);
                            $('#editModal').modal('show'); // Muestra el modal con los datos
                        } else {
                            alert('No se encontraron datos para este paciente');
                        }
                    } catch (e) {
                        console.error('Error al analizar JSON:', e);
                        alert('Error al procesar respuesta del servidor');
                    }
                },
                error: function() {
                    alert('Error al cargar datos para edición');
                }
            });
        });

        // Editar paciente
        $(document).on('submit', '#editForm', function(event) {
            event.preventDefault();
            // Obtén los valores de los campos del formulario
            var idPaciente = $('#_id').val();
            var dn = $('#_dni').val();
            var nom = $('#_nombres').val();
            var ape = $('#_apellidos').val();
            var ed = $('#_edad').val();
            var direc = $('#_direccion').val();
            var gen = $('#_genero').val();
            var cor = $('#_correo').val();
            var ru = $('#_ruc').val();
            // Realiza la solicitud AJAX para modificar el paciente
            $.ajax({
                url: './modpac.php',
                method: 'POST',
                data: {
                    idPaciente: idPaciente,
                    dni: dn,
                    nombres: nom,
                    apellidos: ape,
                    edad: ed,
                    direccion: direc,
                    genero: gen,
                    correo: cor,
                    ruc: ru
                },
                success: function(data) {
                    try {
                        console.log(data);
                        var json = JSON.parse(data);
                        console.log(json);
                        if (json.status === 'true') {
                            table.draw();
                            alert('Paciente editado correctamente');
                            $('#editModal').modal('hide');
                        } else {
                            alert('Error al editar el paciente');
                        }
                    } catch (e) {
                        console.error('Error al analizar JSON:', e);
                        alert('Error al procesar respuesta del servidor');
                    }
                },
                error: function() {
                    alert('Error en la solicitud AJAX');
                }
            });
        });

        // Función para eliminar un paciente
        $(document).on('click', '.deleteBtn', function() {
            // Obtener el ID del paciente a eliminar
            var idPaciente = $(this).data('idpacientes');

            // Confirmar la eliminación
            if (confirm("¿Estás seguro de que deseas eliminar este paciente?")) {
                // Realizar la solicitud AJAX para eliminar el paciente
                $.ajax({
                    url: './eliminapa.php', // Cambia esto por la URL de tu script PHP para eliminar pacientes
                    method: 'POST',
                    data: {
                        //elprimero es la variable de eliminapa.php, el segundo es la variable del inicio
                        id: idPaciente
                    },
                    success: function(data) {
                        try {
                            var json = JSON.parse(data);
                            if (json.status === 'true') {
                                // Eliminación exitosa, volver a cargar los datos de la tabla
                                table.ajax.reload(null, false);
                                alert('Paciente eliminado correctamente');
                            } else {
                                alert('Error al eliminar el paciente');
                            }
                        } catch (e) {
                            console.error('Error al analizar JSON:', e);
                            alert('Error al procesar respuesta del servidor');
                        }
                    },
                    error: function() {
                        alert('Error en la solicitud AJAX');
                    }
                });
            }
        });

    });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">Nuevo Registro</h5>

                </div>
                <div class="modal-body">
                    <!-- Formulario dentro del modal -->
                    <form id="registroForm" action="javascript:void(0);" method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputDNI">DNI</label>
                                <input type="text" class="form-control" id="dni" name="dni" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputNombres">Nombres:</label>
                                <input type="text" class="form-control" id="nombres" name="nombres" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputNombres">Apellidos:</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edad">Edad</label>
                                <input type="number" class="form-control" id="edad" name="edad" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="direccion">direccion</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="genero">Género</label>
                                <select class="form-control" id="genero" name="genero" required>
                                    <option value="">Seleccionar Género</option>
                                    <?php
                                    // Recorre los resultados de la consulta
                                    while ($row = $query->fetch_assoc()) {
                                        echo '<option value="' . $row['idgenero'] . '">' . $row['nom_gen'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Reorganización de los combos -->
                        <div class="row">


                            <div class="form-group col-md-6">
                                <label for="correo">Correo (OPCIONAL)</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ruc">RUC (Opcional)</label>
                                <input type="text" class="form-control" id="ruc" name="ruc" required>
                            </div>
                        </div><br>

                        <div class="form-row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary" name="registro">Registrar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal editar-->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registroModalLabel">Editar Registro</h5>

                </div>
                <div class="modal-body">
                    <!-- Formulario dentro del modal -->
                    <form id="editForm" action="javascript:void(0);" method="POST">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inputDNI">DNI</label>
                                <input type="text" class="form-control" id="_dni" name="_dni" onkeyup="buscar()"
                                    required>
                                <input type="hidden" id="_id" name="_id" value="<?php echo $id; ?>">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputNombres">Nombres:</label>
                                <input type="text" class="form-control" id="_nombres" name="_nombres" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputNombres">Apellidos:</label>
                                <input type="text" class="form-control" id="_apellidos" name="_apellidos" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edad">Edad</label>
                                <input type="number" class="form-control" id="_edad" name="_edad" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="direccion">direccion</label>
                                <input type="text" class="form-control" id="_direccion" name="_direccion" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="genero">Género</label>
                                <select class="form-control" id="_genero" name="_genero" required>
                                    <option value="">Seleccionar Género</option>
                                    <?php
                                    // Recorre los resultados de la consulta
                                    while ($row = $query1->fetch_assoc()) {
                                        echo '<option value="' . $row['idgenero'] . '">' . $row['nom_gen'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- Reorganización de los combos -->
                        <div class="row">


                            <div class="form-group col-md-6">
                                <label for="correo">Correo (OPCIONAL)</label>
                                <input type="email" class="form-control" id="_correo" name="_correo" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ruc">RUC (Opcional)</label>
                                <input type="text" class="form-control" id="_ruc" name="_ruc" required>
                            </div>
                        </div><br>

                        <div class="form-row">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>