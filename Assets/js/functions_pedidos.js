let tablePedidos;
tablePedidos = $('#tablePedidos').dataTable({
		"aProcessing":true,
		"aServeSide":true,
		"language":{
			"url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url": " "+base_url+"/Pedidos/getPedidos",
			"dataSrc":""
			//"error": function(xhr, status, error) {
            //console.log("Error en la respuesta AJAX:");
            //console.log(xhr.responseText); 
            //}// Muestra la respuesta del servidor        
		},
		"columns":[
			{"data":"idpedido"},
	        {"data":"transaccion"},
	        {"data":"fecha"},
	        {"data":"monto"},
	        {"data":"tipopago"},
	        {"data":"status"},
	        {"data":"options"}
		],
		"columnDefs":[
				{'className': "textcenter", "targets": [3] },
				{'className': "textcenter", "targets": [4] },
				{'className': "textcenter", "targets": [6] }
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
			"className": "btn btn-success",
			"exportOptions": {
		        "columns": ":not(:last-child)" //(--> Excluye la última columna), (esto indica solo col a exportar -->[0,2,3,4])
		    }
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

function fntTransaccion(idtransaccion)
{
	let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Pedidos/getTransaccion/'+idtransaccion;
	divLoading.style.display = "flex";
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) 
		{
			let objData = JSON.parse(request.responseText);
			if (objData.status) 
			{
				document.querySelector('#divModal').innerHTML = objData.html;
				$('#modalReembolso').modal('show');
			}else{
				swal('Error', objData.msg, 'error');
			}
			divLoading.style.display = "none";
			return false;
		}
	}
}

function fntReembolsar() 
{
	let idtransaccion = document.querySelector("#idtransaccion").value;
	let observacion = document.querySelector("#txtObservacion").value;
	if (idtransaccion == '' || observacion == '' ) 
	{
		swal("Error", "Complete los datos para continuar." , "error");
		return false;
	}

	swal({
		title: "Hacer Reembolso",
		text: "¿Realmente quiere reelbosar?",
		type: "warning",
		showCancelButton: true,
		confirmButtonText: "Si, Reembolsar!",
		cancelButtonText: "No, cancelar!",
		closeOnConfirm: true,
		closeOnCancel: true
	}, function(isConfirm) {
		if (isConfirm) {
			$("#modalReembolso").modal('hide');
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Pedidos/setReembolso';
			let formData = new FormData();
			formData.append('idtransaccion', idtransaccion);
			formData.append('observacion', observacion);
			request.open("POST", ajaxUrl, true);
			request.send(formData);

			request.onreadystatechange = function () {
				if (request.readyState != 4) return;
				if (request.status == 200) 
				{
					let objData = JSON.parse(request.responseText);
					if (objData.status) 
					{
						window.location.reload();
					}else{
						swal('Error', objData.msg, 'error');
					}
					divLoading.style.display = "none";
					return false;
				}
			}
		}
	});
}

function fntEditInfo(idpedido) 
{
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Pedidos/getPedido/'+idpedido;
	divLoading.style.display = "flex";
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {		
		if (request.readyState ==4 && request.status == 200) 
		{
			let objData = JSON.parse(request.responseText);
			if (objData.status) 
			{
				document.querySelector("#divModal").innerHTML = objData.html;
				$("#modalFormPedido").modal('show');
				$("select").selectpicker();
				fntUpdateInfo();
			}else{
				swal("Error", objData.msg, "error");
			}
			divLoading.style.display = "none";
			return false;
		}
	}

}

function fntUpdateInfo() 
{
	let formUpdatePedido = document.querySelector("#formUpdatePedido");
	formUpdatePedido.onsubmit = function (e) {
		e.preventDefault();
		let transaccion;		
		if (document.querySelector("#txtTransaccion")) 
		{
			transaccion = document.querySelector("#txtTransaccion").value;
			if (transaccion == "") 
			{
				swal("", "Complete los datos para continuar", "error");
				return false;
			}
		}

		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Pedidos/setPedido/';
		divLoading.style.display = "flex";
		let formData = new FormData(formUpdatePedido);
		request.open("POST", ajaxUrl, true);
		request.send(formData);
		request.onreadystatechange = function () {
			if (request.readyState != 4) return;
			if (request.status == 200) 
			{
				let objData = JSON.parse(request.responseText);
				if (objData.status) {
					swal("", objData.msg, "success");
					$("#modalFormPedido").modal('hide');
					tablePedidos.api().ajax.reload(null, false);
				}
				divLoading.style.display = "none";
				return false;
			}
		}
	}
}
