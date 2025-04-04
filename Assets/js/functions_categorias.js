let tableCategorias;
document.addEventListener('DOMContentLoaded', function() {
	tableCategorias = $('#tableCategorias').dataTable({
		"aProcessing":true,
		"aServeSide":true,
		"language":{
			"url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url": " "+base_url+"/Categorias/getCategorias",

			"dataSrc":""
		},
		"columns":[
			{"data":"idcategoria"},
			{"data":"nombre"},
			{"data":"descripcion"},
			{"data":"status"},                  
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


	if(document.querySelector("#foto")){
		var foto = document.querySelector("#foto");
		foto.onchange = function(e) {
			var uploadFoto = document.querySelector("#foto").value;
			var fileimg = document.querySelector("#foto").files;
			var nav = window.URL || window.webkitURL;
			var contactAlert = document.querySelector('#form_alert');
			if(uploadFoto !=''){
				var type = fileimg[0].type;
				var name = fileimg[0].name;
				if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
					contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';
					if(document.querySelector('#img')){
						document.querySelector('#img').remove();
					}
					document.querySelector('.delPhoto').classList.add("notBlock");
					foto.value="";
					return false;
				}else{  
					contactAlert.innerHTML='';
					if(document.querySelector('#img')){
						document.querySelector('#img').remove();
					}
					document.querySelector('.delPhoto').classList.remove("notBlock");
					var objeto_url = nav.createObjectURL(this.files[0]);
					document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objeto_url+">";
				}
			}else{
				alert("No selecciono foto");
				if(document.querySelector('#img')){
					document.querySelector('#img').remove();
				}
			}
		}
	}

	if(document.querySelector(".delPhoto")){
		var delPhoto = document.querySelector(".delPhoto");
		delPhoto.onclick = function(e) {
			document.querySelector("#foto_remove").value = 1;
			removePhoto();
		}
	}

	if (document.querySelector('#formCategoria')) 
	{
		let formCategoria = document.querySelector('#formCategoria');
		formCategoria.onsubmit = function(e) {
			e.preventDefault();

			let strNombre = document.querySelector('#txtNombre').value;
			let strDescripcion = document.querySelector('#txtDescripcion').value;
			let intStatus = document.querySelector('#listStatus').value;

			if (strNombre == "" || strDescripcion == "" || intStatus == "") 
			{
				swal('Atencion', 'Todo los campos son obligatorios', 'error');
				return false;
			}
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Categorias/setCategoria';
			let formData = new FormData(formCategoria);
			request.open("POST", ajaxUrl, true);
			request.send(formData);

			request.onreadystatechange = function() {
				if (request.readyState == 4 && request.status == 200) 
				{
					let objData = JSON.parse(request.responseText);
					if (objData.status) 
					{
						$('#modalFormCategoria').modal('hide');
						formCategoria.reset();
						swal('Categoria', objData.msg, 'success');
						tableCategorias.api().ajax.reload(null, false);
						removePhoto();
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

function fntViewInfo(idcategoria) 
{
	if (document.querySelector('#modalViewCategoria')) 
	{
		let modalViewCategoria = document.querySelector('#modalViewCategoria');
		
		let strNombre = document.querySelector('#txtNombre').value;
		let strDescripcion = document.querySelector('#txtDescripcion').value;
		let intStatus = document.querySelector('#listStatus').value;

		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;
		request.open("GET", ajaxUrl, true);
		request.send();

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) 
			{
				let objData = JSON.parse(request.responseText);

				if (objData.status) 
				{	
					let estado = objData.data.status == 1 ? 
					'<span class="badge badge-success">Activo</span>' : 
                	'<span class="badge badge-danger">Inactivo</span>';

					document.querySelector('#celId').innerHTML = objData.data.idcategoria;
					document.querySelector('#celNombre').innerHTML = objData.data.nombre;
					document.querySelector('#celDescripcion').innerHTML = objData.data.descripcion;
					document.querySelector('#celEstado').innerHTML = estado;
					document.querySelector('#imgCategoria').innerHTML = '<img src="'+objData.data.url_portada+'"></img>';

					$('#modalViewCategoria').modal('show');
				}else{
					swal('Error', objData.msg, 'error');
				}
			}
		}
	}
}

function fntEditInfo(idcategoria) 
{
	if (document.querySelector('#formCategoria')) 
	{
		
		document.querySelector('#titleModal').innerHTML ="Actualizar Categoria";
	    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
	    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
	    document.querySelector('#btnText').innerHTML ="Actualizar";

	    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	    let ajaxUrl = base_url+'/Categorias/getCategoria/'+idcategoria;
	    request.open("GET", ajaxUrl, true);
	    request.send();

	    request.onreadystatechange = function() 
	    {
	    	if (request.readyState == 4 && request.status == 200) 
	    	{
	    		let objData = JSON.parse(request.responseText);
	    		if (objData.status) 
	    		{
	    			document.querySelector('#idCategoria').value = objData.data.idcategoria;
		    		document.querySelector('#txtNombre').value = objData.data.nombre;
		    		document.querySelector('#txtDescripcion').value = objData.data.descripcion;
		    		document.querySelector('#foto_actual').value = objData.data.portada;
	                document.querySelector("#foto_remove").value= 0;

		    		if (objData.data.status == 1){
		    			document.querySelector('#listStatus').value = 1;
		    		}else{
		    			document.querySelector('#listStatus').value = 2;
		    		}
		    		$('#listStatus').selectpicker('render');

		    		if (document.querySelector('#img'))
		    		{
		    			document.querySelector('#img').src = objData.data.url_portada;
		    		}else{
		    			document.querySelector('.prevPhoto div').innerHTML = "<img id='img' src="+objData.data.url_portada+">";
		    		}

		    		if(objData.data.portada == 'portada_categoria.png'){
	                    document.querySelector('.delPhoto').classList.add("notBlock");
	                }else{
	                    document.querySelector('.delPhoto').classList.remove("notBlock");
	                }

	                $('#modalFormCategoria').modal('show');
	    		}else{
	    			swal('Error', objData.msg, 'error');
	    		}
	    	}
	    }
	}
}

function fntDelInfo(idcategoria) 
{
	swal({
		title: "Eliminar Categoría",
        text: "¿Realmente quiere eliminar al categoría?",
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
			let ajaxUrl = base_url+'/Categorias/delCategoria';
			let strData = "idCategoria="+idcategoria;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(strData);

			request.onreadystatechange = function(){
				if (request.readyState == 4 && request.status == 200) 
				{
					let objData = JSON.parse(request.responseText);

					if (objData.status) 
					{
						swal('Eliminar', objData.msg, 'success');
						tableCategorias.api().ajax.reload(null, false);
					}else{
						swal('¡Atencion!', objData, 'error');
					}
				}
			}
		}
	});
}

function removePhoto(){
	document.querySelector('#foto').value ="";
	document.querySelector('.delPhoto').classList.add("notBlock");	
	if (document.querySelector('#img')) {
		document.querySelector('#img').remove();
	}
}

function openModal() {
	document.querySelector('#idCategoria').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nueva Categoria";
	document.querySelector("#formCategoria").reset();
	$('#modalFormCategoria').modal('show');
	removePhoto();
}