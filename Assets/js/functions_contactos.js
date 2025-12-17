let tableContactos;
let divLoading = document.querySelector("#divLoading");
tableContactos = $('#tableContactos').dataTable({
        "aProcessing":true,
        "aServeSide":true,
        "language":{
            "url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Contactos/getContactos",

            "dataSrc":""
        },
        "columns":[
            {"data":"id"},                
            {"data":"nombre"},
            {"data":"email"},
            {"data":"fecha"},
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

function fntViewInfo(idmensaje) {

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsotf.XMLHTTP');
    let ajaxUrl = base_url+'/Contactos/getMensaje/'+idmensaje;
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) 
        {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector('#idMensaje').innerHTML  = objData.data.id;
                document.querySelector('#Nombre').innerHTML  = objData.data.nombre;
                document.querySelector('#Email').innerHTML  = objData.data.email;
                document.querySelector('#Fecha').innerHTML  = objData.data.fecha;
                document.querySelector('#Mensaje').innerHTML  = objData.data.mensaje;

                $('#modalViewMensaje').modal('show');  
            }else{
                swal('Error', objData.msg, 'error');
            }            
        }
    }

}