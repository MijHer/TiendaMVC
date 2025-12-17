let tablePaginas;
let divLoading = document.querySelector("#divLoading");
tablePaginas = $('#tablePaginas').dataTable({
        "aProcessing":true,
        "aServeSide":true,
        "language":{
            "url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Paginas/getPaginas",

            "dataSrc":""
        },
        "columns":[
            {"data":"idpost"},                
            {"data":"titulo"},
            {"data":"fecha"},
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

tinymce.init({
    selector: '#txtContenido',
    width: "100%",
    height: 600,    
    statusbar: true, //statubar
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",   
});

if (document.querySelector('#formPaginas')) 
{
    let formPaginas = document.querySelector('#formPaginas');
    formPaginas.onsubmit = function(e) {
        e.preventDefault();

        let strTitulo = document.querySelector('#txtTitulo').value;
        let strContenido = document.querySelector('#txtContenido').value;
        let intStatus = document.querySelector('#listStatus').value;

        if (strTitulo == '' || strContenido == '' || intStatus == '') 
        {
            swal('Atencion', 'Todo los campos son obligatorios', 'error');
            return false;
        }

        divLoading.style.display = "flex";
        tinyMCE.triggerSave();

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Paginas/setPagina';
        let formData = new FormData(formPaginas);
        request.open("POST", ajaxUrl, true);
        request.send(formData);

        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) 
            {
                console.log(request.responseText);
                let objData = JSON.parse(request.responseText);
                if (objData.status) 
                {
                    swal({
                        title: "",
                        text: objData.msg,
                        type: "success",
                        confirmButtonText: "Aceptar",
                        closeOnConfirm: false,
                    }, function(isConfirm) {
                        location.reload();
                    });                   
                }else{
                    swal('Error', objData.msg, 'error');
                }
            }
            divLoading.style.display = "none";
            return false;
        }
    }
}

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

function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");  
    if (document.querySelector('#img')) {
        document.querySelector('#img').remove();
    }
}

function fntDelInfo(idPagina) 
{
    swal({      
        title: "Eliminar Pagina",
        text: "¿Realmente quiere eliminar la pagina?",
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
            let ajaxUrl = base_url+'/Paginas/delPagina';
            let strData = 'idPagina='+idPagina;
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
                        tablePaginas.api().ajax.reload();
                    }else{
                        swal('Atencion!', objData.msg, 'error');
                    }
                }
            }
        }
    });
    
}