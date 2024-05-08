<?php 
    include("connection.php");

    $sql="SELECT * from v_muestras";
    $query=mysqli_query($con,$sql);
    $count_all_rows=mysqli_num_rows($query);

    if(isset($_POST["search"]["value"])){
        $search_value=$_POST["search"]["value"];
        $sql.=" where muestra like '%".$search_value."%' ";
        $sql.="or tipo like '%".$search_value."%' ";
        $sql.="or llego like '%".$search_value."%' ";
        $sql.="or nombres like '%".$search_value."%' ";
        $sql.="or apellidos like '%".$search_value."%' ";
        $sql.="or dni like '%".$search_value."%' ";
        $sql.="or ruc like '%".$search_value."%' ";
        $sql.="or genero like '%".$search_value."%' ";
    }
    if(isset($_POST["order"])){
        $column=$_POST["order"][0]["column"];
        $order=$_POST["order"][0]["dir"];
        $sql.=" order by ".$column." ".$order;
    }else{
        $sql.= "order by id DESC";
    }

    if($_POST["length"]!=-1){
        $start=$_POST["start"];
        $length=$_POST["length"];
        $sql.=" limit ".$start.", ".$length;
    }
    $data=array();
    $run_query=mysqli_query($con,$sql);
    $filtered_rows=mysqli_num_rows($run_query);
    while($row=mysqli_fetch_assoc($run_query)){
        $subarray=array();
        $subarray[]=$row["id"];
        $subarray[]=$row["muestra"];
        $subarray[]=$row["tipo"];
        $subarray[]=$row["llego"];
        $subarray[]=$row["nombres"];
        $subarray[]=$row["apellidos"];
        $subarray[]=$row["dni"];
        $subarray[]=$row["ruc"];
        $subarray[]=$row["genero"];
        $subarray[] = '<a href="javascript:void();" data-id="'.$row['id'].'" class="btn btn-sm btn-info editBtn">Editar</a> <a href="javascript:void();" data-id="'.$row['id'].'" class="btn btn-sm btn-danger">Eliminar</a>';      
        $data[]=$subarray; 
    }
    $output=array(
        "data"=>$data,
        "draw"=>intval($_POST["draw"]),
        "recordsTotal"=>$count_all_rows,
        "recordsFiltered"=>$filtered_rows,
    );
    echo json_encode($output);


?>