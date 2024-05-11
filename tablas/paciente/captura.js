let editamodal = document.getElementById('editModal')
editamodal.addEventListener('shown.bs.modal',event =>{
    let button = event.relatedTrget
    let id = button.getAtribute('data-id')
    let inputId = editamodal.querySelector('.modal-body #id')
    console.log(inputId);
    let inputDNI = editamodal.querySelector('.modal-body #_dni')
    let inputNombre = editamodal.querySelector('.modal-body #_nombres')
    let inputApellido = editamodal.querySelector('.modal-body #_apellidos')
    let inputEdad = editamodal.querySelector('.modal-body #_edad')
    let inputDireccion = editamodal.querySelector('.modal-body #_direccion')
    let inputGenero = editamodal.querySelector('.modal-body #_genero')
    let inputCorreo = editamodal.querySelector('.modal-body #_correo')
    let inputRuc = editamodal.querySelector('.modal-body #_ruc')

    let url ='modifica.php'
    let formdata= new FormData()
    formdata.append('id',id)
    fetch(url,{
        method:"POST",
        body:formdata
    }).then(response => response.json())
    .then(data =>{
        inputId.value=data.id
        inputId.value=data.DNI
        inputId.value=data.NOMBRE
        inputId.value=data.APELLIDO
        inputId.value=data.EDAD
        inputId.value=data.DIRECCIÓN        
        inputId.value=data.CORREO
        inputId.value=data.RUC
        inputId.value=data.GENERO_ID

    }).carch(err => console.log(err))
})

