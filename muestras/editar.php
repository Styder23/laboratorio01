<?php 
    include('connection.php');
    $id=$_POST["id"];
    $sql="select * from muestra where idmuestra='$id'";
    $query=mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($query);
    echo json_encode($row);
?>