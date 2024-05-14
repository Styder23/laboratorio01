
<?php
include '../../conexion/conec.php';
$obj = new ConexionDB("localhost", "root", "", "bdlab");
$db = $obj->conectar();
if (isset($_POST['buscar'])) {
  $dni = $_POST['dni'];
  $valor = array();
  $valor['existe'] = "0";
  $result = mysqli_query($db, "SELECT * FROM pacientes d inner join personas p on d.fk_idpersona=p.idpersonas
  WHERE p.dni LIKE '%$dni%'");
  while ($consulta = mysqli_fetch_array($result)) {
    $valor['existe'] = "1";
    $valor['idpacientes'] = $consulta['idpacientes'];
    $valor['nombres'] = $consulta['nombres'];
    $valor['apellidos'] = $consulta['apellidos'];
    //$valor['ape']=$consulta['ape'];el primero el segundo []es la bd
    //$valor['direc']=$consulta['dir'];
  }

  // Codificar el array a JSON después del bucle
  $valor = json_encode($valor);
  echo $valor;
}
?>