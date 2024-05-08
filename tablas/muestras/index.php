<?php include('connection.php');



$query = $con->query("SELECT idtipomuestra,nomtip  FROM tipomuestra");
$query2 = $con->query("SELECT idtipomuestra,nomtip  FROM tipomuestra");
$query1=$con->query("SELECT idgenero,nom_gen  FROM genero");



?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/datatables.min.css" rel="stylesheet">


</head>

<body>
    <div class="container my-4">
        <h2>MUESTRAS PENDIENTES</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroModal">Nuevo registro</button>
        <table id="datatable" class="table table-sm table-bordered table-striped">
            <thead>
                <th class="sort asc">ID</th>
                <th class="sort asc">Muestra</th>
                <th class="sort asc">Tipo de muestra</th>
                <th class="sort asc">Fecha recibida</th>
                <th class="sort asc">Nombres</th>
                <th class="sort asc">Apellidos</th>
                <th class="sort asc">DNI del paciente</th>
                <th class="sort asc">RUC</th>
                <th class="sort asc">Genero</th>
                <th class="sort asc">acciones</th>
            </thead>
            <tbody>
            </tbody>
        </table>



    </div>









    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.7/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $("#datatable").DataTable({
            "serverSide": true,
            "processing": true,
            "paging": true,
            "order": [],
            "ajax": {
                "url": "fetch_data.php",
                "type": "post",
            },
            "fnCreateRow": function(nRow, aData, iDataIndex) {
                $(nRow).attr("id", aData[0]);
            },
            "columnDefs": [{
                "target": [0, 5],
                "orderable": false, //o false
            }]
        });
    </script>

    <script type="text/javascript">
        $(document).on("submit","#guardarForm",function(event){
            event.preventDefault();
            var muestra=$("#muestra").val();
            var tipo=$("#tipo").val();
            var dni=$("#dni").val();
            var nombre=$("#nombre").val();
            var apellido=$("#apellido").val();
            var edad=$("#edad").val();
            var genero=$("#genero").val();
            var dir=$("#dir").val();
            var correo=$("#correo").val();
            var ruc=$("#ruc").val();
            
            if(muestra!="" && tipo!="" && dni!="" && nombre!="" && apellido!="" && edad!="" && genero!="" && dir!="" && correo!="" && ruc!=""){
                $.ajax({
                    url:"registro.php",
                    data:{muestra:muestra,tipo:tipo,dni:dni,nombre:nombre,apellido:apellido,edad:edad,genero:genero,dir:dir,correo:correo,ruc:ruc},
                    type:"post",
                    success:function(data){
                        var json=JSON.parse(data);
                        status= json.status;
                        if(status=="success"){
                            table=$("#datatable").DataTable();
                            table.draw();
                            alert("Muestra registrada");
                            $("#muestra").val("");
                            $("#tipo").val("");
                            $("#dni").val("");
                            $("#nombre").val("");
                            $("#apellido").val("");
                            $("#edad").val("");
                            $("#genero").val("");
                            $("#dir").val("");
                            $("#correo").val("");
                            $("#ruc").val("");
                            $("#registroModal").modal("hide");
                        }
                    }
                });
            }else{
                 alert("Rellene campos");
            }
        });
        $(document).on('click','.editBtn',function(event){
            var id=$(this).data('id');
            var trid=$(this).closest("tr").attr("id");
            $.ajax({
                url:"editar.php",
                data:{id:id},
                type:"post",
                success:function(data){
                    var json=JSON.parse(data);
                    $("#id").val(json.id);
                    $("#trid").val(trid);
                    $("#editmuestra").val(json.codigo);
                    $("#edittipo").val(json.fk_idtipomuestra);
                    $("#editarModal").modal("show");
                }
            });
        });
        $(document).on("submit","#editarForm",function(){
            var id=$("#id").val();
            var trid=$("#trid").val();
            var muestra=$("#editmuestra").val();
            var tipo=$("#edittipo").val();
            $.ajax({
                url:"update_muestra.php",
                data:{id:id,muestra:muestra,tipo:tipo},
                type:"post",
                success:function(data){
                    var json=JSON.parse(data);
                    status=json.status;
                    if(status=="success"){
                        table=$("#datatable").DataTable();
                        var button='<a href="javascript:void();" class="btn btn-sm btn-info" data-id="'+id+'">Editar</a> <a href="javascript:void();" class="btn btn-sm btn-danger" data-id="'+id+'">Eliminar</a>';
                        var row=table.row("[id='"+trid+"']");
                        row.row("[id='"+trid+"']").data([id,muestra,tipo,button]);
                        $("editarModal").modal("hide");
                    }else{
                        alert("No se guardaron cambios");
                    }        
                }
            });
        });
    </script>

    <!-- Modal de registro de muestras -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="registroModalLabel">Nueva muestra</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="javascript:void();" id="guardarForm" method="post">
                    <div class="modal-body">
                        <div class="mb-3 row">
                            <label for="muestra" class="col-sm-2 col-form-label">Código</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="muestra" name="muestra" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="tipo" class="col-sm-2 col-form-label">Tipo muestra</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="tipo" id="tipo">                           
                                    <?php
                                    // Recorre los resultados de la consulta
                                    while ($row = $query2->fetch_assoc()) {
                                        echo '<option value="' . $row['idtipomuestra'] . '">' . $row['nomtip'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <h5>Paciente</h5>
                            <label for="">DNI</label>
                            <input type="text" name="dni" id="dni" value=""><br>
                            <label for="">Nombres</label>
                            <input type="text" name="nombre" id="nombre" value=""><br>
                            <label for="">Apellidos</label>
                            <input type="text" name="apellido" id="apellido" value=""><br>
                            <label for="">Edad</label>
                            <input type="number" name="edad" id="edad" value="">
                            <label for="">Género:</label>
                            <select name="genero" id="genero">
                                    <?php
                                    // Recorre los resultados de la consulta
                                    while ($row = $query1->fetch_assoc()) {
                                        echo '<option value="' . $row['idgenero'] . '">' . $row['nom_gen'] . '</option>';
                                    }
                                    ?>
                            </select><br>
                            <label for="">Dirección(opcional)</label>
                            <input type="text" name="dir" id="dir" value=""><br>
                            <label for="">Correo(opcional)</label>
                            <input type="text" name="correo" id="correo" value=""><br>
                            <label for="">RUC(opcional)</label>
                            <input type="text" name="ruc" id="ruc" value=""><br><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>



            </div>
        </div>
    </div>



    <!-- Modal de editar muestras -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarModalLabel">Editar muestra</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <form action="javascript:void();" id="editarForm" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="trid" name="trid" value="">
                        <div class="mb-3 row">
                            <label for="editmuestra" class="col-sm-2 col-form-label">Codigo</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="editmuestra" name="editmuestra" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="edittipo" class="col-sm-2 col-form-label">Tipo muestra</label>
                            <div class="col-sm-10">
                                <select class="form-select" name="edittipo" id="edittipo">
                                <?php
                                    // Recorre los resultados de la consulta
                                    while ($row = $query->fetch_assoc()) {
                                        echo '<option value="' . $row['idtipomuestra'] . '">' . $row['nomtip'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>



            </div>
        </div>
    </div>

</body>

</html>