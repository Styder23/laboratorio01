<?php 
    include('connection.php');
    $muestra=$_POST["muestra"];
    $tipo=$_POST["tipo"];
    $id=$_POST["id"];

    $sql="update muestra set codigo='$muestra',fk_idtipomuestra='$tipo' where idmuestra='$id'";
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