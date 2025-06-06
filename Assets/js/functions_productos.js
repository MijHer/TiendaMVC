document.write(`<script src="${base_url}/Assets/js/plugins/JsBarcode.all.min.js"></script>`);
let tableProductos;
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});

tableProductos = $('#tableProductos').dataTable({
		"aProcessing":true,
		"aServeSide":true,
		"language":{
			"url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
		},
		"ajax":{
			"url": " "+base_url+"/Productos/getProductos",

			"dataSrc":""
		},
		"columns":[
			{"data":"idproducto"},
	        {"data":"codigo"},
	        {"data":"nombre"},
	        {"data":"stock"},
	        {"data":"precio"},
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



window.addEventListener('load', function() {

	if (document.querySelector('#formProducto')) 
	{
		let formProducto = document.querySelector('#formProducto');
		formProducto.onsubmit = function(e) {
			e.preventDefault();

			let strNombre = document.querySelector('#txtNombre').value;
            let intCodigo = document.querySelector('#txtCodigo').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            let intStock = document.querySelector('#txtStock').value;
            let intStatus = document.querySelector('#listStatus').value;

            if (strNombre == '' || intCodigo == '' || strPrecio == '' || intStock == '') 
            {
            	swal('Atencion', 'Todo los campos son obligatorios', 'error');
            	return false;
            }
            if (intCodigo.length < 5) 
            {
            	swal('Atencion', 'El codigo debe ser mayor  5 caracteres', 'error');
            	return false;
            }

            divLoading.style.display = "flex";
            tinyMCE.triggerSave();

            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Productos/setProducto';
            let formData = new FormData(formProducto);
            request.open("POST", ajaxUrl, true);
            request.send(formData);

            request.onreadystatechange = function() {
            	if (request.readyState == 4 && request.status == 200) 
            	{
            		let objData = JSON.parse(request.responseText);

            		if (objData.status) 
            		{
            			swal('', objData.msg, 'success');
            			document.querySelector('#idProducto').value = objData.idproducto;
            			document.querySelector('#containerGallery').classList.remove("notblock");
            			tableProductos.api().ajax.reload(null, false);
            		}else{
            			swal('Error', objData.msg, 'error');
            		}
            	}
            	divLoading.style.display = "none";
            	return false;
            }
		}
	}

	if (document.querySelector('.btnAddImage')) 
	{
		let btnAddImage = document.querySelector('.btnAddImage');
		btnAddImage.onclick = function(e) {
			let key = Date.now();
			let newElement = document.createElement("div");
			newElement.id = "div"+key;
			newElement.innerHTML = `
				<div class="prevImage"></div>
                <input type="file" name="foto" id="img${key}" class="inputUploadfile">
                <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload "></i></label>
                <button class="btnDeleteImage notblock" type="button" onclick="fntDelItem('div${key}')"><i class="fas fa-trash-alt"></i></button>`;
            document.querySelector('#containerImages').appendChild(newElement);
            document.querySelector("#div"+key+" .btnUploadfile").click();// probar con newElement.querySelector('.btnUploadfile').click();
            fntInputFile();
		}
	}

	fntInputFile();
	fntCategoria();
}, false);

if (document.querySelector('#txtCodigo')) 
{
	let inputCodigo = document.querySelector('#txtCodigo');
	inputCodigo.onkeyup = function () {

		if (inputCodigo.value.length >= 5) 
		{
			document.querySelector('#divBarCode').classList.remove('notblock');
			fntBarcode();
		}else{
			document.querySelector('#divBarCode').classList.add('notblock');
		}
	};
}

tinymce.init({
	selector: '#txtDescripcion',
	width: "100%",
    height: 400,    
    statusbar: true, //statubar
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",	
});

function fntInputFile() 
{	
	let inputUploadfile = document.querySelectorAll('.inputUploadfile');
	inputUploadfile.forEach(function (inputUploadfile) {
		inputUploadfile.addEventListener("change", function () {
			let idproducto = document.querySelector('#idProducto').value;
			let parentId = this.parentNode.getAttribute("id"); //coge el id del elemento padre
			let idFile = this.getAttribute("id"); // coge el id del elemeno del que esta usando o manipulando
			let uploadFoto = document.querySelector("#"+idFile).value; //
			let fileimg = document.querySelector("#"+idFile).files;
			let prevImg = document.querySelector("#"+parentId+" .prevImage");
			let nav = window.URL || window.webkit;

			if (uploadFoto != '') 
			{
				let type = fileimg[0].type;
				let name = fileimg[0].name;
				if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') 
				{
					prevImg.innerHTML = "Archivo no válido";
					uploadFoto.value = "";
					return false;
				}else{
					let objeto_url = nav.createObjectURL(this.files[0]);
					prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" >`;

					let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
					let ajaxUrl = base_url+'/Productos/setImage';
					let formData = new FormData();
					formData.append('idproducto', idproducto);
					formData.append('foto', this.files[0]);
					request.open("POST", ajaxUrl, true);
					request.send(formData);

					request.onreadystatechange = function () {
						if (request.readyState != 4) return;
						if (request.status == 200) {

							let objData = JSON.parse(request.responseText);
							if (objData.status) 
							{
								prevImg.innerHTML = `<img src="${objeto_url}">`;
								document.querySelector("#"+parentId+" .btnDeleteImage").setAttribute("imgname",objData.imgname);
								document.querySelector("#"+parentId+" .btnUploadfile").classList.add("notblock");
								document.querySelector("#"+parentId+" .btnDeleteImage").classList.remove("notblock");
							}else{
								swal('Error', objData.msg, 'error');
							}
						}
					}
				}
			}
		});
	});
}

function fntDelItem(element) 
{
	let nameImg = document.querySelector(element+' .btnDeleteImage').getAttribute("imgname");
	let idProducto = document.querySelector('#idProducto').value;

	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Productos/delFile';

	let formData = new FormData();
	formData.append('idproducto', idProducto);
	formData.append("file", nameImg);
	request.open("POST", ajaxUrl, true);
	request.send(formData);

	request.onreadystatechange = function() {
		if (request.readyState != 4) return;
		if (request.status == 200) 
		{
			let objData = JSON.parse(request.responseText);
			if (objData.status) 
			{
				let itemRemove = document.querySelector(element);
				itemRemove.parentNode.removeChild(itemRemove);
			}else{
				swal("", objData.msg, 'error');
			}
		}
	}
}

function fntBarcode(){
    let codigo = document.querySelector("#txtCodigo").value;
    JsBarcode("#barcode", codigo);
}

function fntViewInfo(idProducto) 
{
	let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
	request.open("GET", ajaxUrl, true);
	request.send();

	request.onreadystatechange = function () 
	{
		if (request.readyState == 4 && request.status == 200) 
		{
			let objData = JSON.parse(request.responseText);
			if (objData.status) 
			{
				let htmlImage = "";
				let objProducto = objData.data;

				let estadoProducto = objProducto.status == 1 
														? '<span class="badge badge-success">Activo</span>' 
														: '<span class="badge badge-danger">Inactivo</span>';
				document.querySelector("#celCodigo").innerHTML = objProducto.codigo;
				document.querySelector("#celNombre").innerHTML = objProducto.nombre;
				document.querySelector("#celPrecio").innerHTML = objProducto.precio;
				document.querySelector("#celStock").innerHTML = objProducto.stock;
				document.querySelector("#celCategoria").innerHTML = objProducto.categoria;
				document.querySelector("#celStatus").innerHTML = estadoProducto;
				document.querySelector("#celDescripcion").innerHTML = objProducto.descripcion;

				if (objProducto.images.length > 0) 
				{
					let objProductos = objProducto.images;
					for (let i = 0; i < objProductos.length; i++) {
						htmlImage += `<img src="${objProductos[i].url_image}"></img>`;
					}
				}
				document.querySelector('#celFotos').innerHTML = htmlImage;
				$('#modalViewProducto').modal('show');
			}else{
				swal('Error', objData.msg, 'error');
			}
		}		
	}
	$('#modalViewProducto').modal('show');
}

function fntEditInfo(idProducto) 
{
	document.querySelector('#titleModal').innerHTML ="Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

	if (document.querySelector('#formProducto')) 
	{
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Productos/getProducto/'+idProducto;
		request.open("GET", ajaxUrl, true);
		request.send();

		request.onreadystatechange = function () {
			if (request.readyState == 4 && request.status == 200) 
			{
				console.log(request.responseText);
				let objData = JSON.parse(request.responseText);
				document.querySelector("#containerGallery").classList.remove("notblock");
				if (objData.status) 
				{	
					htmlImage = "";
					let objProducto = objData.data;
					document.querySelector('#idProducto').value = objProducto.idproducto;
					document.querySelector('#txtNombre').value = objProducto.nombre;
					document.querySelector('#txtDescripcion').value = objProducto.descripcion;
					document.querySelector('#txtCodigo').value = objProducto.codigo;
					document.querySelector('#txtPrecio').value = objProducto.precio;
					document.querySelector('#txtStock').value = objProducto.stock;
					document.querySelector('#listCategoria').value = objProducto.categoriaid;
					$('#listCategoria').selectpicker('render');

					if (objData.data.status == 1){
		    			document.querySelector('#listStatus').value = 1;
		    		}else{
		    			document.querySelector('#listStatus').value = 2;
		    		}
		    		$('#listStatus').selectpicker('render');
					
					tinymce.activeEditor.setContent(objProducto.descripcion);
					fntBarcode();
					document.querySelector('#divBarCode').classList.remove('notblock');

					
					if(objProducto.images.length > 0){
	                    let objProductos = objProducto.images;
	                    for (let p = 0; p < objProductos.length; p++) {
	                        let key = Date.now()+p;
	                        htmlImage +=`<div id="div${key}">
	                            <div class="prevImage">
	                            <img src="${objProductos[p].url_image}"></img>
	                            </div>
	                            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objProductos[p].img}">
	                            <i class="fas fa-trash-alt"></i></button></div>`;
	                    }
	                }
					document.querySelector("#containerImages").innerHTML = htmlImage;
					$('#modalFormProducto').modal('show');
				}else{
					swal('Error', objData.msg, 'error');
				}
			}
		}
	}
}

function fntDelInfo(idProducto) 
{
	swal({		
        title: "Eliminar Producto",
        text: "¿Realmente quiere eliminar el producto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
	}, function (isConfirm) 
	{
		if (isConfirm) 
		{
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Productos/delProducto';
			let strData = 'idproducto='+idProducto;
			request.open("POST", ajaxUrl, true);
			request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			request.send(strData);

			request.onreadystatechange = function () {
				if (request.readyState == 4 && request.status == 200) 
				{
					let objData = JSON.parse(request.responseText);

					if (objData.status) 
					{
						swal('Eliminar', objData.msg, 'success');
						tableProductos.api().ajax.reload();
					}else{
						swal('Atencion!', objData.msg, 'error');
					}
				}
			}
		}
	});
	
}

function fntCategoria() 
{
	if (document.querySelector('#listCategoria')) 
	{
		 let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		 let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
		 request.open("GET", ajaxUrl, true);
		 request.send();

		 request.onreadystatechange = function () {
		 	if (request.readyState == 4 && request.status == 200) 
		 	{
		 		document.querySelector('#listCategoria').innerHTML = request.responseText;
		 		$('#listCategoria').selectpicker('render');
		 	}
		 }
	}	
}

function fntPrintBarcode(area) {
	let elemntArea = document.querySelector(area);
    let vprint = window.open(' ', 'popimpr', 'height=400,width=600');
    vprint.document.write(elemntArea.innerHTML);
    vprint.document.close();
    vprint.print();
    vprint.close();
}

function openModal() {
	document.querySelector('#idProducto').value = "";
	document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
	document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
	document.querySelector('#btnText').innerHTML = "Guardar";
	document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
	document.querySelector("#formProducto").reset();
	document.querySelector("#divBarCode").classList.add("notblock");
    document.querySelector("#containerGallery").classList.add("notblock");
    document.querySelector("#containerImages").innerHTML = "";
	$('#modalFormProducto').modal('show');
}