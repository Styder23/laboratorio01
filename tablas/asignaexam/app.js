const boton=document.getElementById('agregar');
const guardar=document.getElementById('guardar');
const lista = document.getElementById('lista');
const data=[];
const cant=0;
boton.addEventListener("click",agregar);
guardar.addEventListener("click",save);

function agregar(){
    const id=document.getElementById('idpaciente').value;
    const dni=document.getElementById('dni').value; 
    const paciente=document.getElementById('paciente').value;    
    const examen=document.getElementById('examen').value; 
    const fecha=document.getElementById('fecha').value; 
    const muestra=document.getElementById('muestra').value; 
    //agregar el elemento al arreglo
    data.push({
        "No":cant,
        "id":id,
        "dni":dni,
        "paciente":paciente,
        "examen":examen,
        "fecha":fecha,
        "muestra":muestra
    }
    );
    var id_row='row'+cant;
    var fila = '<tr id="' + id_row + '"><td>' + id + '</td><td>' + dni + '</td><td>' + paciente + '</td><td>' + examen + '</td><td>' + fecha + '</td><td>' + muestra + '</td><td><a href="#" class="btn btn-danger" onclick="eliminar(' + cant + ');">Eliminar</a></td></tr>';
    //agregar a la tabla
    $("#lista").append(fila);
    cant++;
    suma();   
}


function save(){
    const json=JSON.stringify(data);
    console.log(data);
    $.ajax({
        type: "POST",
        url: "api.php",
        data: "json="+json,
        success:function(resp){
            console.log(resp);
            window.location.href = './exam.php';
        }
    });
}

function suma(){
    var tot=0;
    for(x of data){
        tot= tot+x.cant;
    }
    document.getElementById('total').innerHTML="Total "+tot;
}

function eliminar(row) {
    // Remover la fila
    $("#row" + row).remove();
    let pos = -1;
    for (let i = 0; i < data.length; i++) {
        if (data[i].No === row) {
            pos = i;
            break;
        }
    }
    if (pos !== -1) {
        data.splice(pos, 1);
        suma();
    }
}