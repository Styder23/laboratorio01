<?php
// Seguridad de sesiones
    session_start();
  include('../muestras/connection.php');
  $query = $con->query("SELECT idtipoexamen,nomexamen  FROM tipoexamen");
  $query1 = $con->query("SELECT idarea,nomarea  FROM area");
  $query2 = $con->query("SELECT idtipomuestra,nomtip  FROM tipomuestra");
  
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Asignar examen</title>
    <style>
    .btn-eliminar {
        background-color: #dc3545;
        /* Color de fondo rojo */
        color: #fff;
        /* Color de texto blanco */
    }

    .btn-eliminar:hover {
        background-color: #c82333;
        /* Color de fondo más oscuro al pasar el mouse */
        border-color: #bd2130;
        /* Color del borde más oscuro al pasar el mouse */
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Asignar Examen</h1>
        <form action="" class="col-6">
            <div class="row mb-3">
                <label for="dni" class="col-sm-2 col-form-label">DNI</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="dni" id="dni" onkeyup="buscar()">
                    <input type="hidden" id="idpaciente" name="idpaciente" disabled>
                    <button type="button" class="btn btn-primary mt-2" id="Nuevo">Add</button>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="paciente">PACIENTE</label>
                    <input type="text" class="form-control" name="paciente" id="paciente" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="area">Area Clinica</label>
                    <select name="area" id="area" class="form-control">
                        <option value="">--Seleccione</option>
                        <?php
                        // Recorre los resultados de la consulta
                        while ($row = $query1->fetch_assoc()) {
                            echo '<option value="' . $row['idarea'] . '">' . $row['nomarea'] . '</option>';
                        }            
                        ?>
                    </select>
                </div>
                <div class="col">
                    <label for="examen">Examen</label>
                    <select name="examen" id="examen" class="form-control">
                        <option value="">--Seleccione--</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="fecha">Fecha:</label>
                    <input type="text" class="form-control" name="fecha" id="fecha" value="" disabled>
                </div>
                <div class="col">
                    <label for="muestra">Muestra:</label>
                    <select name="muestra" id="muestra" class="form-control">
                        <option value="">--Seleccione--</option>
                        <?php
                        // Recorre los resultados de la consulta
                        while ($row = $query2->fetch_assoc()) {
                            echo '<option value="' . $row['idtipomuestra'] . '">' . $row['nomtip'] . '</option>';
                        }            
                        ?>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <button type="button" class="btn btn-success" id="agregar">Agregar</button>
                    <button type="button" class="btn btn-success" id="guardar">Guardar</button>
                </div>
            </div>
        </form>
        <div class="col-12 mt-3" id="exampaci">
            <table class="table table-striped" id="lista">
                <thead>
                    <tr>
                    
                        
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Paciente</th>
                        <th>Examen</th>
                        <th>Fecha</th>
                        <th>Muestra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se agregarán las filas dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-10 text-rigth" id="total"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="./app.js"></script>
        
    <!--EL BOTTON ADDD-->
    <script>
    $(document).ready(function(){
        $('#Nuevo').click(function(){
            window.location.href = '../../paciente/paciente.php'; // Reemplaza 'index.html' con la URL de tu página de destino
        });
    });
    </script>
    <!-- Script para obtener los exámenes de las áreas -->
    <script>
    // Scrip para obtener los exámenes de las áreas
    $(document).ready(function() {
        // Evento de cambio en el combo box de área
        $('#area').on('change', function() {
            var areaId = $(this).val();

            // Realizar una solicitud AJAX para obtener los exámenes del área seleccionada
            $.ajax({
                url: './obt_exam.php', // Verifica que la ruta sea correcta
                method: 'GET',
                data: {
                    Area_id: areaId
                },
                dataType: 'json',
                success: function(response) {
                    // Vaciar el combo box de exámenes
                    $('#examen').empty();

                    // Agregar la opción "Seleccione" al inicio del combo box de exámenes
                    $('#examen').append(
                        $('<option>', {
                            value: '',
                            text: '--Seleccione--'
                        })
                    );

                    // Agregar las opciones de exámenes al combo box
                    response.forEach(function(examen) {
                        $('#examen').append(
                            $('<option>', {
                                value: examen.idtipoexamen,
                                text: examen.nomexamen,
                            })
                        );
                    });

                    // Console.log para verificar la respuesta
                    console.log(response);
                },
                error: function() {
                    alert('Error al obtener los exámenes.');
                }
            });
        });
    });
    </script>

    <!-- Script para obtener la persona por su DNI -->
    <script>
    function buscar() {
        dni = $("#dni").val();
        var parametros = {
            "buscar": "1",
            "dni": dni
        };
        $.ajax({
            data: parametros,
            dataType: 'json',
            url: './obt_pacien.php',
            type: 'post',
            beforeSend: function() {
                console.log("enviado")
            },
            error: function(e) {
                console.log(e)
            },
            complete: function() {
                console.log("listo")
            },
            success: function(valor) {
                console.log(valor)
                $("#idpaciente").val(valor.idpacientes); // Debe ser idpersonas en lugar de idpacientes
                $("#paciente").val(valor.nombres + ' ' + valor.apellidos);
            }
        });
    }
    </script>

    <!-- Script para poner la fecha y hora -->
    <script>
    const fechaActual = new Date();
    const fechaFormateada =
        `${fechaActual.getDate()}/${fechaActual.getMonth() + 1}/${fechaActual.getFullYear()} ${fechaActual.getHours()}:${fechaActual.getMinutes()}`;
    document.getElementById('fecha').value = fechaFormateada;
    </script>
</body>

</html>