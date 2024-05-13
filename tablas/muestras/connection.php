<?php 
    $con=mysqli_connect("localhost","root","","bdlab");
    if(mysqli_connect_errno()){
        echo "Error de conexión";
        exit();
    }
?>