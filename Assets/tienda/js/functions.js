$(".js-select2").each(function(){
	$(this).select2({
		minimumResultsForSearch: 20,
		dropdownParent: $(this).next('.dropDownSelect2')
	});
});

$('.parallax100').parallax100();

$('.gallery-lb').each(function() { // the containers for all your galleries
	$(this).magnificPopup({
		delegate: 'a', // the selector for gallery item
		type: 'image',
		gallery: {
			enabled:true
		},
		mainClass: 'mfp-fade'
	});
});

$('.js-addwish-b2').on('click', function(e){
	e.preventDefault();
});

$('.js-addwish-b2').each(function(){
	var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
	$(this).on('click', function(){
		swal(nameProduct, "¡Se agrego al carrito!", "success");
	});
});

$('.js-addwish-detail').each(function(){
	var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

	$(this).on('click', function(){
		swal(nameProduct, "is added to wishlist !", "success");

		$(this).addClass('js-addedwish-detail');
		$(this).off('click');
	});
});

/*---------------------------------------------*/

$('.js-addcart-detail').each(function(){
	let nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
	$(this).on('click', function(){

		let cant = 1;
		let id = this.getAttribute('id');
		if (document.querySelector('#cant-product'))
		{
			cant = document.querySelector('#cant-product').value;
		}
		if (this.getAttribute('pr')) 
		{
			cant = this.getAttribute('pr');
		}

		if (Number.isNaN(cant) || cant < 1) 
		{
			swal('¡Atencion!', "La cantidad debe de ser mayor o igual a 1", "error");
			return false;
		}
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/addCarrito';
		let formData = new FormData();
		formData.append('id',id);
		formData.append('cant',cant);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () 
		{
			if (request.readyState != 4) return;
			if (request.status == 200) 
			{
				let objData = JSON.parse(request.responseText);

				if (objData.status) 
				{
					document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
					let cants = document.querySelectorAll(".cantCarrito");
					cants.forEach(element => {
						element.setAttribute("data-notify", objData.cantCarrito);
					});
					swal(nameProduct, "¡Se agrego al carrito!", "success");
				}
			}
			return false;
		}
	});
});

$('.js-pscroll').each(function(){
	$(this).css('position','relative');
	$(this).css('overflow','hidden');
	var ps = new PerfectScrollbar(this, {
		wheelSpeed: 1,
		scrollingThreshold: 1000,
		wheelPropagation: false,
	});

	$(window).on('resize', function(){
		ps.update();
	})
});

/*==================================================================
[ +/- num product ]*/
$('.btn-num-product-down').on('click', function(){
    let numProduct = Number($(this).next().val());
    let idpr = this.getAttribute('idpr');
    if(numProduct > 1) $(this).next().val(numProduct - 1);
    let cant = $(this).next().val();
    if (idpr != null) 
    {
    	fntUpdateCant(idpr,cant);
    }    
});

$('.btn-num-product-up').on('click', function(){
    let numProduct = Number($(this).prev().val());
    let idpr = this.getAttribute('idpr');
    $(this).prev().val(numProduct + 1);
    let cant = $(this).prev().val();
    if (idpr != null) 
    {
    	fntUpdateCant(idpr,cant);
    }
});

if (document.querySelector('.num-product')) 
{
	let inputCant = document.querySelectorAll('.num-product');
		inputCant.forEach(function(inputCant) {
			inputCant.addEventListener('keyup', function(){
				let idpr = this.getAttribute('idpr');
				let cant = this.value;
				if (idpr != null) 
			    {
			    	fntUpdateCant(idpr,cant);
			    }
			});
		});
}

if (document.querySelector("#formRegister")) 
{
    let formRegister = document.querySelector("#formRegister");
    formRegister.onsubmit = function(e) {
        e.preventDefault();

        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmailCliente').value;
        let intTelefono = document.querySelector('#txtTelefono').value;

        if(strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '' )
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
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Tienda/registro'; 
        let formData = new FormData(formRegister);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    window.location.reload(false);
                }else{
                    swal("Error", objData.msg , "error");
                }
            }
            divLoading.style.display = "none";
            return false;
        }
    }
}

if (document.querySelectorAll('.methodpago')) 
{
	let optmetodo = document.querySelectorAll('.methodpago');
	optmetodo.forEach(function(optmetodo) {
		optmetodo.addEventListener('click', function() {
			if (this.value == 'Paypal') 
			{
				document.querySelector('#divpaypal').classList.remove('notblock');
				document.querySelector('#divtipopago').classList.add('notblock');
			}else{
				document.querySelector('#divpaypal').classList.add('notblock');
				document.querySelector('#divtipopago').classList.remove('notblock');
			}
		});
	});
}

function fntdelItem(element) 
{
	let option = element.getAttribute("op");
	let idpr = element.getAttribute("idpr");

	if (option == 1 || option == 2) 
	{
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		let ajaxUrl = base_url+'/Tienda/delCarrito';
		let formData = new FormData();
		formData.append('id', idpr);
		formData.append('option', option);		
		request.open("POST", ajaxUrl, true);
		request.send(formData);
		request.onreadystatechange = function () {
			if (request.readyState != 4 ) return;
			if (request.status == 200) 
			{
				let objData = JSON.parse(request.responseText);
				if (objData.status) 
				{
					if (option == 1) 
					{
						document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
						//document.querySelector("#cantCarrito").setAttribute("data-notify", objData.cantCarrito);
						let cants = document.querySelectorAll(".cantCarrito");
						cants.forEach(element => {
							element.setAttribute("data-notify", objData.cantCarrito);
						});
					}else{
						element.parentNode.parentNode.remove();
						document.querySelector('#subTotalCompra').innerHTML = objData.subTotal;
						document.querySelector('#totalCompra').innerHTML = objData.total;
						if (document.querySelectorAll('#tblCarrito tr').length == 1) 
						{
							window.location.href = base_url;
						}
					}
				}else{
					swal('', objData.msg, 'error');
				}
			}
			return false;
		}
	}
}

function fntUpdateCant(pro, cant) 
{
	if (cant <= 0) 
	{
		document.querySelector('#btnComprar').classList.add('notblock');
	}else{
		document.querySelector('#btnComprar').classList.remove('notblock');

		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/updCarrito';
		let formData = new FormData();
		formData.append('id', pro);
		formData.append('cantidad', cant);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState != 4) return;
			if (request.status == 200) 
			{
				let objData = JSON.parse(request.responseText);
				if (objData.status) 
				{
					let colSubtotal = document.getElementsByClassName(pro)[0];
					colSubtotal.cells[4].textContent = objData.totalProducto;
					document.querySelector('#subTotalCompra').innerHTML = objData.subTotal;
					document.querySelector('#totalCompra').innerHTML = objData.total;
				}else{
					swal('', objData.msg, 'error');
				}
			}
		}
	}
	return false;
}

//para verificar si el campo direccion este rellenado
if (document.querySelector('#txtDireccion')) 
{
	 let direccion = document.querySelector('#txtDireccion');
	 direccion.addEventListener('keyup', function () {
	 	let dir = this.value;
	 	fntViewPago();
	 });
}

//para verificar si el campo ciudad este rellenado
if (document.querySelector('#txtCiudad')) 
{
	let ciudad = document.querySelector('#txtCiudad');
	ciudad.addEventListener('keyup', function () {
		let c = this.value;
		fntViewPago();
	});
}

if (document.querySelector('#condiciones')) {
	let opt = document.querySelector('#condiciones');
	opt.addEventListener("click", function () {
		let opcion = this.checked;
		if (opcion) {
            document.querySelector('#optMetodoPago').classList.remove('notblock');
        } else {
            document.querySelector('#optMetodoPago').classList.add('notblock');
        }
	});
}

function fntViewPago() 
{
	let direccion = document.querySelector('#txtDireccion').value;
	let ciudad = document.querySelector('#txtCiudad').value;

	if (direccion == '' || ciudad == '') 
	{
		document.querySelector('#divMetodoPago').classList.add('notblock');		
	}else{
		document.querySelector('#divMetodoPago').classList.remove('notblock');
	}
}

if (document.querySelector('#btnComprar')){
	let btnPago = document.querySelector('#btnComprar');
	btnPago.addEventListener('click', function () {

		let dir = document.querySelector('#txtDireccion').value;
		let ciudad = document.querySelector('#txtCiudad').value;
		let inttipopago = document.querySelector('#listtipopago').value;
		if (dir == "" || ciudad == "" || inttipopago == "") 
		{
			swal('Ingrese todo los datos de envio', error);
			return false;
		}else{
			divLoading.style.display = "flex";
			let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
			let ajaxUrl = base_url+'/Tienda/procesarVenta';
			let formData = new FormData();
			formData.append('direccion', dir);
			formData.append('ciudad', ciudad);
			formData.append('inttipopago', inttipopago);
			request.open("POST", ajaxUrl, true);
			request.send(formData);

			request.onreadystatechange = function() {
				if (request.readyState != 4) return;
				if (request.status == 200) {
					let objData = JSON.parse(request.responseText);
					if (objData.status) 
					{
						window.location = base_url+'/Tienda/confirmarpedido';
					}else{
						swal("", objData.msg, 'error')
					}
				}
				divLoading.style.display = "none";
				return false;
			}
		}

	},false);
}

if (document.querySelector("#formSuscripcion")) 
{
	let formSuscripcion = document.querySelector('#formSuscripcion');
	formSuscripcion.addEventListener('submit', function (e) {
		e.preventDefault();
		let nombre = document.querySelector('#nombreSuscripcion').value;
		let email = document.querySelector('#emailSuscripcion').value;

		if (nombre == "") {
			swal('', 'El nombre es obligatorio', 'error')
			return false;
		}
		if (!fntEmailValidate(email)) {
			swal('', 'El corro no es valido', 'error');
			return false;
		}
		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+'/Tienda/suscripcion';
		let formData = new FormData(formSuscripcion);		
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function(){
			if (request.readyState != 4) return;
			if (request.status == 200) {
				console.log(request.responseText);
				let objData = JSON.parse(request.responseText);
				if (objData.status) {
					swal('', objData.msg, 'success');
					document.querySelector("#formSuscripcion").reset();
				}else{
					swal ('', objData.msg, 'error');
				}		
			}
			divLoading.style.display = "none";
			return false;
		}
	},false);
}

if (document.querySelector("#formContacto")) 
{
	let formContacto = document.querySelector("#formContacto");
	formContacto.addEventListener('submit', function (e) {
		e.preventDefault();

		let nombre = document.querySelector("#nombreContacto").value;
		let email = document.querySelector("#emailContacto").value;
		let mensaje = document.querySelector("#mensaje").value;

		if (nombre == "") 
		{
			swal('', '¡Nombre es obligatorio!', 'error');
			return false;
		}
		if (!fntEmailValidate(email)) 
		{
			swal('', '¡Email no valido!', 'error');
			return false;
		}
		if (mensaje == "") 
		{
			swal('', '¡Ingrese mensaje!', 'error');
			return false;
		}

		divLoading.style.display = "flex";
		let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		let ajaxUrl = base_url+"/Tienda/contacto";
		let formData = new FormData(formContacto);
		request.open("POST", ajaxUrl, true);
		request.send(formData);

		request.onreadystatechange = function () {
			if (request.readyState != 4) return ;
			if (request.status = 200){

				let objData = JSON.parse(request.responseText);
				if (objData.status) {
					swal('¡Felicidades!', objData.msg, 'success');
					document.querySelector("#formContacto").reset();
				}else{
					swal('¡Atencion!', objData.msg, 'error');
				}
			}
			divLoading.style.display = "none";
			return false;
		}
	},false);
}


