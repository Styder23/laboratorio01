<?php 
    $con=mysqli_connect("localhost","root","","bdlaboratorio");
    if(mysqli_connect_errno()){
        echo "Error de conexión";
        exit();
    }
?>