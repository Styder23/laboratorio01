<?php 
    include("connection.php");

    $apellido=$_POST["apellido"];
    $correo=$_POST["correo"];
    $dir=$_POST["dir"];
    $dni=$_POST["dni"];
    $edad=$_POST["edad"];
    $genero=$_POST["genero"];
    $nombre=$_POST["nombre"];
    $ruc=$_POST["ruc"];
    $muestra=$_POST["muestra"];
    $tipo=$_POST["tipo"];

    $sql="CALL p_in_muestra('$apellido','$correo','$dir','$dni','$edad','$genero','$nombre','$ruc','$muestra','$tipo')";
    $query=mysqli_query($con,$sql);
    if($query==true){
        $data=array(
            "status"=>"success",
        );
        echo json_encode($data);
    }else{
        $data=array(
            "status"=>"failed",
        );
        echo json_encode($data);
    }
?>