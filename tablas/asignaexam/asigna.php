<?php
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Asignar examen</title>
  </head>
  <body>
    

    <div class="container">
        <h1>Asigna examen</h1>
        <form action="" class="col-6">
        <div class="row">
    <div class="col">
        <label for="dni">DNI</label>
        <div class="input-group">
        <input type="text" class="form-control" name="dni" id="dni" onkeyup="buscar()">
            <button type="button" class="btn btn-primary" id="Nuevo">Add</button>
        </div>
    </div>
    <div class="col">
        <label for="cod">Código</label>
        <input type="text" class="form-control" name="cod" id="cod" disabled>
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
            <label for="exmen">Examen</label>
            <select name="exmen" id="exmen" class="form-control">
                <option value="">--Seleccione</option>
                
                <!-- sellena dimanicamente -->
                
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="fecha">Fecha:</label>
            <input type="text" class="form-control" name="fecha" id="fecha" value="10/05/24 17:20" disabled>
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
                <tr>
                    <td>ID</td>
                    <td>DNI</td>
                    <td>Paciente</td>
                    <td>Examen</td>
                    <td>Fecha</td>
                    <td>Muestra</td>
                    <td>Acciones</td>
                </tr>
            </table>

        </div>
    </div>
    <div class="col-10 text-rigth" id="total"></div>


   

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
    <script src="app.js"></script>

     <!-- Scrip para obtener los exames de las areas -->
     <script>
    $(document).ready(function() {
        // Evento de cambio en el combo box de área
        $('#area').on('change', function() {
            var areaId = $(this).val();
            
            // Realizar una solicitud AJAX para obtener los exámenes del área seleccionada
            $.ajax({
                url: './obt_exam.php', // Corrige la ruta de tu archivo obt_examen.php
                method: 'GET',
                data: { Area_id: areaId },
                dataType: 'json',
                success: function(response) {
                    // Vaciar el combo box de exámenes
                    $('#exmen').empty();

                    // Agregar la opción "Seleccione" al inicio del combo box de exámenes
                    $('#exmen').append(
                        $('<option>', {
                            value: '',
                            text: '--Seleccione--'
                        })
                    );

                    // Agregar las opciones de exámenes al combo box
                    response.forEach(function(examen) {
                        $('#exmen').append(
                            $('<option>', {
                                value: examen.idtipoexamen,
                                text: examen.nomexamen,
                            })
                        );
                    });
                },
                error: function() {
                    alert('Error al obtener los exámenes.');
                }
            });
        });
    });

</script>
<script>
  // Obtener la persona por su DNI
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
                $("#idperso").val(valor.idpacientes); // Debe ser idpersonas en lugar de idpacientes
                $("#paciente").val(valor.nombres + ' ' + valor.apellidos);
            }

        });
  }
</script>
<script>
  // para ponder la fecha y hora
    // Obtener la fecha y hora actual
    const fechaActual = new Date();
    const fechaFormateada = `${fechaActual.getDate()}/${fechaActual.getMonth() + 1}/${fechaActual.getFullYear()} ${fechaActual.getHours()}:${fechaActual.getMinutes()}`;

    // Establecer la fecha y hora actual en el campo de fecha
    document.getElementById('fecha').value = fechaFormateada;

</script>
  </body>
</html>