<?php
    //recibir json
    //para corregir
    $examen = json_decode($_POST['json'],true);
    require 'conexion.php';

    foreach($examen as $exame){
        //para recorrer los datos
        $dni=$exame['dni']
        $dni=$exame['paciente']
        $dni=$exame['examen']
        //guardar los datos
        $guardar=mysqly_query($con,"insert into tabla(dni,paciente,)values('$dni','$lala')");
    }

?>