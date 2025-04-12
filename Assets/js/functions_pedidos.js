let tablePedidos
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
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Pedidos/getTransaccion/'+idtransaccion;
	divLoading.style.display = "flex";
	request.open('GET', ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () {
		if (request.readyState == 4 && request.status == 200) 
		{
			let objData = JSON.parse(reques.responseText);
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
