<?php 
include('conexion.php');
//los datos de los inputs
$examen = $_POST['examen'];
$area = $_POST['area'];

//realizamos la consulta para insertar

$sql = "INSERT INTO `examen` (`nomexam`,`fk_idarea`) values ('$examen', '$area')";
$query= mysqli_query($con,$sql);
$lastId = mysqli_insert_id($con);
if($query ==true)
{
   
    $data = array(
        'status'=>'true',
       
    );

    echo json_encode($data);
}
else
{
     $data = array(
        'status'=>'false',
      
    );

    echo json_encode($data);
} 

?>