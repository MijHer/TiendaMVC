let tableClientes;
let divLoading = document.querySelector("#divLoading");

document.addEventListener('DOMContentLoaded', function() {
	tableClientes = $('#tableClientes').dataTable({
        "aProcessing":true,
        "aServeSide":true,
        "language":{
            "url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Clientes/getClientes",

            "dataSrc":""
        },
        "columns":[
            {"data":"idpersona"},
            {"data":"identificacion"},
            {"data":"nombres"},
            {"data":"apellidos"},
            {"data":"email_user"},
            {"data":"telefono"},           
            {"data":"options"}
            ],
        'dom': 'lBfrtip',
        'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary"
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Esportar a Excel",
            "className": "btn btn-success"
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Esportar a PDF",
            "className": "btn btn-danger"
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Esportar a CSV",
            "className": "btn btn-info"
        }
        ],
        "resonsieve":"true",
        "bDestroy":true,
        "iDisplayLength":10,
        "order": [[0, "desc"]]
    });

if (document.querySelector('#formCliente')) 
{
	let formCliente = document.querySelector('#formCliente');
	formCliente.onsubmit = function(e) {
		e.preventDefault();

		let strIdentificacion = document.querySelector('#txtIdentificacion').value;
		let strNombre = document.querySelector('#txtNombre').value;
		let strApellido = document.querySelector('#txtApellido').value;
		let intTelefono = document.querySelector('#txtTelefono').value;
		let strEmail = document.querySelector('#txtEmail').value;
		let strPassword = document.querySelector('#txtPassword').value;
		let strNit = document.querySelector('#txtNit').value;
		let strNomFiscal = document.querySelector('#txtNombreFiscal').value;
		let strDirFiscal = document.querySelector('#txtDirFiscal').value;

		if(strIdentificacion == '' || strNombre == '' || strApellido == '' || intTelefono == '' || strEmail == '' || strNit == '' || strNomFiscal == '' || strDirFiscal == '')
        {
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }

        let elementsValid = document.getElementsByClassName("valid");
        for (let i = 0; i < elementsValid.length; i++) { 
            if(elementsValid[i].classList.contains('is-invalid')) { 
                swal("Atención", "Por favor verifique los campos en rojo." , "error");
                return false;
            } 
        }

        divLoading.style.display = "flex";
    	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsotf.XMLHTTP');
		let ajaxUrl = base_url+'/Clientes/setCliente';
		let formData = new FormData(formCliente);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function() {
			if (request.readyState == 4 && request.status == 200) 
			{
				let objData = JSON.parse(request.responseText);
				if (objData.status) 
				{
					$('#modalFormCliente').modal('hide');
					formCliente.reset();
					swal('Usuario', objData.msg, 'success');
					tableClientes.api().ajax.reload(null, false);
				}else{
					swal('Error', objData.msg, 'error');
				}
			}
			divLoading.style.display = "none";
			return false;
		}
	}
}

},false);

function fntViewInfo(idpersona) 
{
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function(){
		if (request.readyState == 4 && request.status == 200) 
		{
			let objData = JSON.parse(request.responseText);
			if (objData.status) 
			{				
				document.querySelector('#celIdentificacion').innerHTML = objData.data.identificacion;
				document.querySelector('#celNombre').innerHTML = objData.data.nombres;
				document.querySelector('#celApellido').innerHTML = objData.data.apellidos;
				document.querySelector('#celTelefono').innerHTML = objData.data.telefono;
				document.querySelector('#celEmail').innerHTML = objData.data.email_user;
				document.querySelector('#celNit').innerHTML = objData.data.nit;
				document.querySelector('#celNomFiscal').innerHTML = objData.data.nombrefiscal;
				document.querySelector('#celDirFiscal').innerHTML = objData.data.direccionfiscal;
				document.querySelector('#celFechaRegistro').innerHTML = objData.data.fechaRegistro;
				$('#modalViewCliente').modal('show');
			}else{
				swal('Error', objData.msg, 'error');
			}
		}
	}
}

function fntEditInfo(idpersona) 
{	
	document.querySelector('#titleModal').innerHTML ="Actualizar Cliente";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getCliente/'+idpersona;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function() {
    	
    	if (request.readyState == 4 && request.status == 200) 
    	{
    		let objData = JSON.parse(request.responseText);
    		if (objData.status) 
    		{
    			document.querySelector('#idUsuario').value = objData.data.idpersona;
    			document.querySelector('#txtIdentificacion').value = objData.data.identificacion;
				document.querySelector('#txtNombre').value = objData.data.nombres;
				document.querySelector('#txtApellido').value = objData.data.apellidos;
				document.querySelector('#txtTelefono').value = objData.data.telefono;
				document.querySelector('#txtEmail').value = objData.data.email_user;
				document.querySelector('#txtPassword').value = objData.data.password;
				document.querySelector('#txtNit').value = objData.data.nit;
				document.querySelector('#txtNombreFiscal').value = objData.data.nombrefiscal;
				document.querySelector('#txtDirFiscal').value = objData.data.direccionfiscal;
    		}
    	}
    	$('#modalFormCliente').modal('show');
    }	
}

function fntDelInfo(idpersona) 
{
	swal({
		title: "Eliminar Cliente",
        text: "¿Realmente quiere eliminar al cliente?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
	}, function(isConfirm) {

		if (isConfirm) 
		{
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Clientes/delCliente';
			let strData = "idUsuario=" +idpersona;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(strData);

			request.onreadystatechange = function () 
			{
				if (request.readyState == 4 && request.status == 200) 
				{
					let objData = JSON.parse(request.responseText);
					if (objData.status) 
					{
						swal('Eliminar', objData.msg, 'success');
						tableClientes.api().ajax.reload();
					}else{
						swal('Atencion', objData.msg, 'error');
					}
				}	
			}
		}
	});

	
}

function openModal(){
	document.querySelector('#idUsuario').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    document.querySelector("#formCliente").reset();
	$('#modalFormCliente').modal('show');
}